<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\WebsiteCustomer;
use App\Services\ExternalApiService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

/**
 * Controlador para el proceso de checkout público
 * 
 * Maneja la finalización de compras tanto para usuarios autenticados
 * como para usuarios invitados (guest checkout).
 */
class CheckoutController extends Controller
{
    /**
     * Iniciar el proceso de checkout
     */
    public function index(Request $request, $websiteSlug)
    {
        $website = Website::where('slug', $websiteSlug)->first();
        
        if (!$website) {
            abort(404, 'Tienda no encontrada');
        }

        // Verificar si el cliente está autenticado
        $isAuthenticated = Session::has('customer_logged_in') && Session::get('customer_logged_in');
        $customerData = $isAuthenticated ? Session::get('customer_data') : null;

        return view('checkout.index', compact('website', 'isAuthenticated', 'customerData'));
    }

    /**
     * Procesar el checkout y crear la orden
     */
    public function processCheckout(Request $request)
    {
        Log::info('🛒 Iniciando proceso de checkout', [
            'website_slug' => $request->website_slug,
            'items_count' => count($request->items ?? []),
            'payment_method' => $request->payment_method,
            'customer_email' => $request->input('customer.email'),
            'full_request' => $request->all()
        ]);
        
        $request->validate([
            'website_slug' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required',
            'items.*.name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'customer.name' => 'required|string|max:255',
            'customer.email' => 'required|email|max:255',
            'customer.phone' => 'required|string|max:20',
            'shipping_address' => 'required|array',
            'billing_address' => 'nullable|array',
            'payment_method' => 'required|string',
        ]);

        $website = Website::where('slug', $request->website_slug)->first();
        
        if (!$website) {
            return response()->json([
                'success' => false,
                'message' => 'Tienda no encontrada'
            ], 404);
        }

        DB::beginTransaction();

        try {
            // Verificar si el cliente está autenticado
            $isAuthenticated = Session::has('customer_logged_in') && Session::get('customer_logged_in');
            $adminNegociosUserId = $isAuthenticated ? Session::get('customer_admin_negocios_id') : null;

            // Crear o encontrar el customer
            $customer = $this->createOrUpdateCustomer($website, $request->customer, $adminNegociosUserId, $isAuthenticated);

            // Calcular totales
            $subtotal = 0;
            foreach ($request->items as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            $taxAmount = $request->input('tax_amount', 0);
            $shippingAmount = $request->input('shipping_amount', 0);
            $total = $subtotal + $taxAmount + $shippingAmount;

            // Crear la orden
            $order = new Order();
            $order->website_id = $website->id;
            $order->customer_id = $customer->id;
            $order->order_number = $order->generateOrderNumber();
            $order->status = 'pending';
            $order->payment_status = 'pending';
            $order->subtotal = $subtotal;
            $order->tax_amount = $taxAmount;
            $order->shipping_amount = $shippingAmount;
            $order->total = $total;
            $order->currency = $request->input('currency', 'COP');
            $order->payment_method = $request->payment_method;
            $order->shipping_address = $request->shipping_address;
            $order->billing_address = $request->billing_address ?? $request->shipping_address;
            $order->notes = $request->input('notes');
            $order->save();

            // Crear los items de la orden
            foreach ($request->items as $item) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                
                // Intentar encontrar el producto local por su admin_negocios_product_id
                $adminNegociosProductId = $item['product_id'] ?? $item['id'] ?? null;
                $localProduct = null;
                
                if ($adminNegociosProductId) {
                    $localProduct = \App\Models\BlogPost::where('website_id', $website->id)
                        ->where('is_product', true)
                        ->where(function($query) use ($adminNegociosProductId) {
                            $query->whereJsonContains('meta_data->admin_negocios_id', (string)$adminNegociosProductId)
                                  ->orWhereJsonContains('meta_data->admin_negocios_id', (int)$adminNegociosProductId);
                        })
                        ->first();
                }
                
                $orderItem->blog_post_id = $localProduct ? $localProduct->id : null;
                $orderItem->admin_negocios_product_id = $adminNegociosProductId;
                $orderItem->product_name = $item['name'];
                $orderItem->product_sku = $item['sku'] ?? null;
                
                // Guardar la imagen del producto (viene del carrito con la URL completa)
                $orderItem->product_image = $item['image'] ?? null;
                
                $orderItem->quantity = $item['quantity'];
                $orderItem->price = $item['price'];
                $orderItem->total = $item['price'] * $item['quantity'];
                $orderItem->save();
            }

            // Si hay integración con AdminNegocios, enviar la orden
            $adminNegociosOrderId = null;
            if ($website->api_key && $website->api_base_url) {
                $adminNegociosOrderId = $this->sendOrderToAdminNegocios($website, $order, $request->items, $customer);
                
                if ($adminNegociosOrderId) {
                    $order->admin_negocios_order_id = $adminNegociosOrderId;
                    $order->save();
                }
            }

            // Actualizar estadísticas del website_customer si está autenticado
            if ($isAuthenticated && $adminNegociosUserId) {
                $websiteCustomer = WebsiteCustomer::where('website_id', $website->id)
                    ->where('admin_negocios_user_id', $adminNegociosUserId)
                    ->first();
                
                if ($websiteCustomer) {
                    $websiteCustomer->recordPurchase($total);
                }
            }

            DB::commit();

            Log::info('Orden creada exitosamente', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'customer_id' => $customer->id,
                'total' => $total,
                'is_authenticated' => $isAuthenticated,
                'admin_negocios_order_id' => $adminNegociosOrderId
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Orden creada exitosamente',
                'order' => [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'status' => $order->status,
                    'payment_status' => $order->payment_status,
                    'total' => $order->total,
                    'currency' => $order->currency,
                    'admin_negocios_order_id' => $adminNegociosOrderId,
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();

            Log::error('❌ Error de validación en checkout', [
                'errors' => $e->errors(),
                'website_slug' => $request->website_slug
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Datos de checkout inválidos: ' . implode(', ', array_map(fn($errors) => implode(', ', $errors), $e->errors())),
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('❌ Error al procesar checkout', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'website_slug' => $request->website_slug,
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la orden: ' . $e->getMessage(),
                'debug' => config('app.debug') ? [
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ] : null
            ], 500);
        }
    }

    /**
     * Crear o actualizar un customer
     */
    private function createOrUpdateCustomer($website, $customerData, $adminNegociosUserId = null, $isAuthenticated = false)
    {
        $data = [
            'website_id' => $website->id,
            'name' => $customerData['name'],
            'email' => $customerData['email'],
            'phone' => $customerData['phone'],
            'address' => $customerData['address'] ?? null,
            'city' => $customerData['city'] ?? null,
            'state' => $customerData['state'] ?? null,
            'postal_code' => $customerData['postal_code'] ?? null,
            'country' => $customerData['country'] ?? null,
            'admin_negocios_id' => $adminNegociosUserId,
            'is_authenticated' => $isAuthenticated,
        ];

        // Si está autenticado, buscar por admin_negocios_id
        if ($isAuthenticated && $adminNegociosUserId) {
            $customer = Customer::where('website_id', $website->id)
                ->where('admin_negocios_id', $adminNegociosUserId)
                ->first();

            if ($customer) {
                $customer->update($data);
                return $customer;
            }
        }

        // Si no está autenticado o no se encontró, buscar por email
        $customer = Customer::where('website_id', $website->id)
            ->where('email', $customerData['email'])
            ->first();

        if ($customer) {
            $customer->update($data);
            return $customer;
        }

        // Crear nuevo customer
        return Customer::create($data);
    }

    /**
     * Enviar la orden a AdminNegocios
     */
    private function sendOrderToAdminNegocios($website, $order, $items, $customer)
    {
        try {
            Log::info('📤 Enviando pedido a AdminNegocios', [
                'order_id' => $order->id,
                'customer' => $customer->admin_negocios_id ?? $customer->email
            ]);
            
            // Obtener el ID del usuario autenticado de AdminNegocios
            $adminNegociosUserId = Session::get('customer_admin_negocios_id');
            
            if (!$adminNegociosUserId) {
                Log::warning('⚠️ No hay customer_admin_negocios_id en sesión');
                return null;
            }
            
            // Obtener la dirección seleccionada del pedido
            $shippingAddress = $order->shipping_address;
            $addressId = $shippingAddress['address_id'] ?? null;
            
            if (!$addressId) {
                Log::warning('⚠️ No se proporcionó address_id');
                return null;
            }
            
            // Preparar productos para AdminNegocios
            $productos = array_map(function($item) {
                return [
                    'id_producto' => $item['product_id'],
                    'producto' => $item['name'],
                    'precio' => $item['price'],
                    'cantidad' => $item['quantity'],
                    'comentario' => null
                ];
            }, $items);
            
            // Preparar datos del pedido según el formato de AdminNegocios
            $orderData = [
                'user_id' => $adminNegociosUserId,
                'id_direccion' => $addressId,
                'id_negocio' => $website->negocio_id ?? null, // Debes tener el negocio_id configurado
                'observaciones' => $order->notes,
                'medio_pago' => $order->payment_method === 'cash_on_delivery' ? 'Efectivo' : 'En línea',
                'origen' => 'web-mash', // Origen del pedido desde el creador de sitios
                'productos' => $productos
            ];
            
            Log::info('📦 Datos del pedido a enviar', $orderData);

            // Usar el endpoint con API Key
            $apiUrl = rtrim($website->api_base_url, '/') . '/api-key/orders';

            $response = Http::timeout(30)
                ->withHeaders([
                    'X-API-Key' => $website->api_key,
                    'Accept' => 'application/json',
                ])
                ->post($apiUrl, $orderData);

            $data = $response->json();
            
            Log::info('📨 Respuesta de AdminNegocios', [
                'status' => $response->status(),
                'data' => $data
            ]);

            if ($response->successful() && isset($data['data']['id'])) {
                Log::info('✅ Pedido creado en AdminNegocios', [
                    'local_order_id' => $order->id,
                    'admin_negocios_order_id' => $data['data']['id']
                ]);

                return $data['data']['id'];
            }

            Log::warning('❌ No se pudo crear el pedido en AdminNegocios', [
                'response' => $data,
                'status' => $response->status()
            ]);

            return null;

        } catch (\Exception $e) {
            Log::error('❌ Error al enviar pedido a AdminNegocios', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'order_id' => $order->id
            ]);

            return null;
        }
    }

    /**
     * Ver detalles de una orden
     */
    public function showOrder(Request $request, $websiteSlug, $orderNumber)
    {
        $website = Website::where('slug', $websiteSlug)->first();
        
        if (!$website) {
            abort(404, 'Tienda no encontrada');
        }

        // Si el orderNumber es numérico y corto, asumimos que es un ID de AdminNegocios
        $isAdminNegociosId = is_numeric($orderNumber) && strlen($orderNumber) < 10;
        
        Log::info('🔍 Buscando orden', [
            'order_number' => $orderNumber,
            'is_admin_negocios_id' => $isAdminNegociosId
        ]);

        if ($isAdminNegociosId) {
            // Buscar primero en AdminNegocios por ID
            $order = $this->fetchExternalOrder($website, $orderNumber);
            
            // Si no se encuentra en AdminNegocios, buscar localmente
            if (!$order) {
                $order = Order::where('website_id', $website->id)
                    ->where('admin_negocios_order_id', $orderNumber)
                    ->with(['customer', 'items.product'])
                    ->first();
            }
        } else {
            // Buscar por order_number largo (ORD202512030009)
            $order = Order::where('website_id', $website->id)
                ->where('order_number', $orderNumber)
                ->with(['customer', 'items.product'])
                ->first();

            if (!$order) {
                $order = $this->fetchExternalOrder($website, $orderNumber);
            }
        }

        if (!$order) {
            abort(404, 'Orden no encontrada');
        }

        // Verificar que el usuario tenga acceso a esta orden
        $isAuthenticated = Session::has('customer_logged_in') && Session::get('customer_logged_in');
        
        if ($isAuthenticated && isset($order->customer->admin_negocios_id)) {
            $customerAdminNegociosId = Session::get('customer_admin_negocios_id');
            
            if ($order->customer->admin_negocios_id != $customerAdminNegociosId) {
                abort(403, 'No tienes acceso a esta orden');
            }
        } elseif (!$isAuthenticated) {
            // Si no está autenticado, verificar por email en la sesión o parámetro
            $email = $request->input('email');
            
            if ($order->customer->email != $email) {
                abort(403, 'No tienes acceso a esta orden');
            }
        }

        if ($website->template_id) {
            $templateService = app(\App\Services\TemplateService::class);
            $template = $templateService->find($website->template_id);
            
            if ($template) {
                $customization = $template['customization'] ?? [];
                
                $page = (object)[
                    'id' => null,
                    'title' => 'Orden #' . $order->order_number,
                    'slug' => 'order-' . $order->order_number,
                    'meta_description' => 'Detalle de tu compra',
                    'html_content' => view('checkout.order-content', compact('website', 'order'))->render(),
                    'css_content' => null,
                    'enable_store' => true,
                ];
                
                $templateFile = $template['templates']['page'] ?? 'template';
                $viewPath = 'templates.' . $template['slug'] . '.' . str_replace('.blade.php', '', $templateFile);
                
                $templateConfig = \App\Models\TemplateConfiguration::firstOrCreate(
                    [
                        'website_id' => $website->id,
                        'template_slug' => $template['slug']
                    ],
                    [
                        'configuration' => \App\Models\TemplateConfiguration::getDefaultConfiguration($template['slug']),
                        'customization' => [],
                        'settings' => [],
                        'is_active' => true
                    ]
                );
                
                return view($viewPath, [
                    'website' => $website,
                    'page' => $page,
                    'pages' => $website->pages()->where('is_published', true)->get(),
                    'customization' => $customization,
                    'templateConfig' => $templateConfig
                ]);
            }
        }

        return view('checkout.order', compact('website', 'order'));
    }


    /**
     * Obtener órdenes desde AdminNegocios para el cliente autenticado
     */
    protected function fetchExternalOrders(Request $request, Website $website, ?int $customerAdminNegociosId): ?LengthAwarePaginator
    {
        if (!$website->api_base_url || !$website->api_key || !$customerAdminNegociosId) {
            return null;
        }

        $token = Session::get('customer_token');
        $appKey = config('services.admin_negocios.app_key');
        // Usar la ruta correcta con API Key (no requiere JWT)
        $apiUrl = rtrim($website->api_base_url, '/') . '/api-key/orders';

        try {
            $response = Http::timeout(15)
                ->withHeaders([
                    'X-API-Key' => $website->api_key,
                    'Accept' => 'application/json',
                ])
                ->get($apiUrl, [
                    'user_id' => $customerAdminNegociosId,
                    'page' => $request->input('page', 1),
                ]);

            if (!$response->successful()) {
                Log::warning('No se pudieron obtener órdenes externas', [
                    'status' => $response->status(),
                    'body' => $response->json(),
                ]);

                return null;
            }

            $payload = $response->json();
            $ordersData = collect($payload['data'] ?? [])->map(function ($order) use ($website) {
                return $this->transformExternalOrder($order, $website);
            });

            return new LengthAwarePaginator(
                $ordersData,
                $payload['total'] ?? $ordersData->count(),
                $payload['per_page'] ?? 10,
                $payload['current_page'] ?? 1,
                [
                    'path' => $request->url(),
                    'query' => $request->query(),
                ]
            );
        } catch (\Exception $e) {
            Log::error('Error consumiendo órdenes externas', [
                'error' => $e->getMessage(),
                'website_id' => $website->id,
            ]);

            return null;
        }
    }

    /**
     * Obtener los detalles de una orden remota
     */
    protected function fetchExternalOrder(Website $website, $orderNumber): ?object
    {
        if (!$website->api_base_url || !$website->api_key) {
            return null;
        }

        $token = Session::get('customer_token');
        $appKey = config('services.admin_negocios.app_key');
        // Usar la ruta correcta con API Key (no requiere JWT)
        $apiUrl = rtrim($website->api_base_url, '/') . '/api-key/orders/' . $orderNumber;

        try {
            $response = Http::timeout(15)
                ->withHeaders([
                    'X-API-Key' => $website->api_key,
                    'Accept' => 'application/json',
                ])
                ->get($apiUrl);

            if (!$response->successful()) {
                Log::warning('No se pudo obtener la orden externa', [
                    'status' => $response->status(),
                    'order_number' => $orderNumber,
                ]);

                return null;
            }

            $payload = $response->json();
            $data = $payload['data'] ?? $payload;

            return $this->transformExternalOrder($data, $website);
        } catch (\Exception $e) {
            Log::error('Error consumiendo orden externa', [
                'error' => $e->getMessage(),
                'order_number' => $orderNumber,
                'website_id' => $website->id,
            ]);

            return null;
        }
    }

    /**
     * Unificar la estructura de pedidos externos con la esperada por las vistas
     */
    protected function transformExternalOrder(array $order, ?Website $website = null): object
    {
        $createdAt = $order['created_at'] ?? $order['fecha_solicitud'] ?? now()->toDateTimeString();
        $products = collect($order['productos'] ?? []);
        $subtotal = $products->sum(function ($item) {
            $price = $item['precio'] ?? 0;
            $quantity = $item['cantidad'] ?? 1;
            return $price * $quantity;
        });

        $shipping = $order['delivery_fee'] ?? 0;
        $total = $order['total'] ?? ($subtotal + $shipping);

        $items = $products->map(function ($item) use ($website) {
            $rawName = $item['producto']
                ?? ($item['product']['producto'] ?? null)
                ?? ($item['product']['name'] ?? null)
                ?? ($item['product_name'] ?? null)
                ?? 'Producto';

            if (is_array($rawName)) {
                $rawName = $rawName['producto']
                    ?? $rawName['name']
                    ?? (is_array($rawName['product'] ?? null) ? ($rawName['product']['name'] ?? 'Producto') : 'Producto');
            }

            // Obtener la imagen del producto desde AdminNegocios
            // Primero intentar desde la relación imagenes (orden 0)
            $productImage = null;
            
            if (isset($item['producto']['imagenes']) && is_array($item['producto']['imagenes']) && count($item['producto']['imagenes']) > 0) {
                // Tomar la primera imagen de la relación
                $primeraImagen = $item['producto']['imagenes'][0];
                $productImage = $primeraImagen['imagen'] ?? null;
            } elseif (isset($item['product']['imagenes']) && is_array($item['product']['imagenes']) && count($item['product']['imagenes']) > 0) {
                $primeraImagen = $item['product']['imagenes'][0];
                $productImage = $primeraImagen['imagen'] ?? null;
            } else {
                // Fallback a campos directos
                $productImage = $item['product_image'] 
                    ?? $item['imagen']
                    ?? ($item['producto']['img'] ?? null)
                    ?? ($item['product']['img'] ?? null)
                    ?? null;
            }
            
            // Si hay imagen, construir la URL completa
            if ($productImage && !str_starts_with($productImage, 'http')) {
                // Usar siempre la URL de producción para las imágenes
                $productImage = 'https://servidor.adminnegocios.com/storage/productos/' . $productImage;
            }

            return (object)[
                'product_name' => is_string($rawName) ? $rawName : 'Producto',
                'quantity' => $item['cantidad'] ?? 1,
                'price' => $item['precio'] ?? 0,
                'total' => ($item['precio'] ?? 0) * ($item['cantidad'] ?? 1),
                'product_image' => $productImage,
            ];
        });

        $customer = $order['user'] ?? [];
        $customerName = trim(($customer['firstName'] ?? '') . ' ' . ($customer['lastName'] ?? ''));

        return (object)[
            'order_number' => $order['id'] ?? $order['order_number'] ?? 'N/A',
            'status' => $this->mapExternalOrderStatus($order['estado'] ?? null),
            'payment_status' => $this->mapExternalPaymentStatus($order['estado'] ?? null),
            'payment_method' => $order['medio_pago'] ?? 'online',
            'created_at' => Carbon::parse($createdAt),
            'items' => $items,
            'subtotal' => $subtotal,
            'tax_amount' => $order['tax'] ?? 0,
            'shipping_amount' => $shipping,
            'total' => $total,
            'currency' => $order['currency'] ?? 'COP',
            'notes' => $order['observaciones'] ?? null,
            'customer' => (object)[
                'name' => $customerName ?: ($customer['email'] ?? 'Cliente'),
                'email' => $customer['email'] ?? 'N/A',
                'phone' => $customer['phone'] ?? null,
                'admin_negocios_id' => $customer['id'] ?? null,
            ],
            'shipping_address' => [
                'address' => $order['direccion'] ?? ($order['shipping_address']['address'] ?? ''),
                'city' => $order['ciudad'] ?? '',
                'state' => $order['barrio'] ?? '',
                'country' => $order['pais'] ?? 'Colombia',
            ],
            'billing_address' => [
                'address' => $order['billing_address']['address'] ?? ($order['direccion'] ?? ''),
                'city' => $order['billing_address']['city'] ?? ($order['ciudad'] ?? ''),
                'state' => $order['billing_address']['state'] ?? ($order['barrio'] ?? ''),
                'country' => $order['billing_address']['country'] ?? 'Colombia',
            ],
        ];
    }

    protected function mapExternalOrderStatus(?string $status): string
    {
        return match ($status) {
            'solicitado' => 'pending',
            'aceptado', 'listo' => 'processing',
            'asignado', 'en_camino' => 'shipped',
            'entregado' => 'delivered',
            'cancelado' => 'cancelled',
            default => 'pending',
        };
    }

    protected function mapExternalPaymentStatus(?string $status): string
    {
        return match ($status) {
            'entregado' => 'paid',
            'cancelado' => 'refunded',
            default => 'pending',
        };
    }
}

