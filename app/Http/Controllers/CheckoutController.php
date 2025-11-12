<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\WebsiteCustomer;
use App\Services\ExternalApiService;
use Illuminate\Http\Request;
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
                $orderItem->product_id = $item['product_id'];
                $orderItem->product_name = $item['name'];
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

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error al procesar checkout', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'website_slug' => $request->website_slug
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la orden. Por favor, intenta nuevamente.'
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
            $apiService = new ExternalApiService($website->api_key, $website->api_base_url);
            
            // Preparar datos de la orden para AdminNegocios
            $orderData = [
                'customer_id' => $customer->admin_negocios_id, // Si existe
                'customer_email' => $customer->email,
                'customer_name' => $customer->name,
                'customer_phone' => $customer->phone,
                'items' => array_map(function($item) {
                    return [
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ];
                }, $items),
                'shipping_address' => $order->shipping_address,
                'billing_address' => $order->billing_address,
                'payment_method' => $order->payment_method,
                'notes' => $order->notes,
                'subtotal' => $order->subtotal,
                'tax_amount' => $order->tax_amount,
                'shipping_amount' => $order->shipping_amount,
                'total' => $order->total,
                'currency' => $order->currency,
                'external_order_number' => $order->order_number,
                'source' => 'creador_tiendas',
            ];

            // Enviar a AdminNegocios (ajustar endpoint según tu API)
            $apiUrl = rtrim($website->api_base_url, '/');
            $token = Session::get('customer_token'); // Si el usuario está autenticado

            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => $token ? 'Bearer ' . $token : '',
                    'X-API-Key' => $website->api_key,
                ])
                ->post($apiUrl . '/segundos/pedidos', $orderData);

            $data = $response->json();

            if ($response->successful() && isset($data['pedido']['id'])) {
                Log::info('Orden enviada a AdminNegocios', [
                    'local_order_id' => $order->id,
                    'admin_negocios_order_id' => $data['pedido']['id']
                ]);

                return $data['pedido']['id'];
            }

            Log::warning('No se pudo enviar orden a AdminNegocios', [
                'response' => $data,
                'status' => $response->status()
            ]);

            return null;

        } catch (\Exception $e) {
            Log::error('Error al enviar orden a AdminNegocios', [
                'error' => $e->getMessage(),
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

        $order = Order::where('website_id', $website->id)
            ->where('order_number', $orderNumber)
            ->with(['customer', 'items'])
            ->first();

        if (!$order) {
            abort(404, 'Orden no encontrada');
        }

        // Verificar que el usuario tenga acceso a esta orden
        $isAuthenticated = Session::has('customer_logged_in') && Session::get('customer_logged_in');
        
        if ($isAuthenticated) {
            $customerAdminNegociosId = Session::get('customer_admin_negocios_id');
            
            if ($order->customer->admin_negocios_id != $customerAdminNegociosId) {
                abort(403, 'No tienes acceso a esta orden');
            }
        } else {
            // Si no está autenticado, verificar por email en la sesión o parámetro
            $email = $request->input('email');
            
            if ($order->customer->email != $email) {
                abort(403, 'No tienes acceso a esta orden');
            }
        }

        return view('checkout.order', compact('website', 'order'));
    }

    /**
     * Listar órdenes del cliente autenticado
     */
    public function myOrders(Request $request, $websiteSlug)
    {
        $website = Website::where('slug', $websiteSlug)->first();
        
        if (!$website) {
            abort(404, 'Tienda no encontrada');
        }

        // Verificar autenticación
        if (!Session::has('customer_logged_in') || !Session::get('customer_logged_in')) {
            return redirect()->route('customer.login', ['website' => $websiteSlug])
                ->with('error', 'Debes iniciar sesión para ver tus órdenes');
        }

        $customerAdminNegociosId = Session::get('customer_admin_negocios_id');

        $orders = Order::where('website_id', $website->id)
            ->whereHas('customer', function($query) use ($customerAdminNegociosId) {
                $query->where('admin_negocios_id', $customerAdminNegociosId);
            })
            ->with(['customer', 'items'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('checkout.my-orders', compact('website', 'orders'));
    }
}

