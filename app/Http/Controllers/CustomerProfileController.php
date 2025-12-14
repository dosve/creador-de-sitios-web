<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Models\WebsiteCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Controlador para el perfil de clientes
 * 
 * Maneja la visualización y actualización de datos del cliente,
 * cambio de contraseña y gestión de direcciones.
 */
class CustomerProfileController extends Controller
{
    /**
     * Verificar autenticación del cliente
     */
    private function checkAuth($websiteSlug)
    {
        if (!Session::has('customer_logged_in') || !Session::get('customer_logged_in')) {
            return redirect()->route('website.show', $websiteSlug)
                ->with('error', 'Debes iniciar sesión para acceder a esta sección');
        }

        return null;
    }

    /**
     * Renderizar vista con plantilla del sitio
     */
    private function renderWithTemplate($website, $title, $slug, $contentView, $data = [])
    {
        if ($website->template_id) {
            $templateService = app(\App\Services\TemplateService::class);
            $template = $templateService->find($website->template_id);

            if ($template) {
                $customization = $template['customization'] ?? [];

                // Crear página virtual
                $page = (object)[
                    'id' => null,
                    'title' => $title,
                    'slug' => $slug,
                    'meta_title' => $title,
                    'meta_description' => $title,
                    'meta_keywords' => null,
                    'html_content' => view($contentView, array_merge($data, ['website' => $website]))->render(),
                    'css_content' => null,
                    'js_content' => null,
                    'enable_store' => true,
                    'is_home' => false,
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

        // Si no hay template, usar el layout blank
        $page = (object)[
            'id' => null,
            'title' => $title,
            'slug' => $slug,
            'meta_title' => $title,
            'meta_description' => $title,
            'meta_keywords' => null,
            'html_content' => view($contentView, array_merge($data, ['website' => $website]))->render(),
            'css_content' => null,
            'js_content' => null,
            'enable_store' => true,
            'is_home' => false,
        ];

        return view('public.blank', [
            'website' => $website,
            'page' => $page,
            'pages' => $website->pages()->where('is_published', true)->get(),
        ]);
    }

    /**
     * Mostrar perfil del cliente
     */
    public function index($websiteSlug)
    {
        $website = Website::where('slug', $websiteSlug)->firstOrFail();

        $authCheck = $this->checkAuth($websiteSlug);
        if ($authCheck) return $authCheck;

        $customerData = Session::get('customer_data');
        $addresses = $this->fetchCustomerAddresses($website);
        $orders = $this->fetchCustomerOrders($website);

        return $this->renderWithTemplate(
            $website,
            'Mi Perfil',
            'profile',
            'customer.profile-content',
            [
                'customerData' => $customerData,
                'addresses' => $addresses,
                'orders' => $orders
            ]
        );
    }

    /**
     * Actualizar datos del perfil
     */
    public function update(Request $request, $websiteSlug)
    {
        $website = Website::where('slug', $websiteSlug)->firstOrFail();

        if (!Session::has('customer_logged_in') || !Session::get('customer_logged_in')) {
            return response()->json([
                'success' => false,
                'message' => 'No hay sesión activa'
            ], 401);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        try {
            $adminNegociosUserId = Session::get('customer_admin_negocios_id');
            $token = Session::get('customer_token');

            // Separar nombre en firstName y lastName
            $nameParts = explode(' ', $request->name, 2);
            $firstName = $nameParts[0];
            $lastName = $nameParts[1] ?? '';

            // Actualizar en AdminNegocios
            $apiUrl = rtrim($website->api_base_url, '/');
            $response = Http::timeout(10)
                ->withHeaders(['Authorization' => 'Bearer ' . $token])
                ->put($apiUrl . '/user/' . $adminNegociosUserId, [
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'phone' => $request->phone,
                ]);

            if ($response->successful()) {
                // Actualizar en local
                $websiteCustomer = WebsiteCustomer::where('website_id', $website->id)
                    ->where('admin_negocios_user_id', $adminNegociosUserId)
                    ->first();

                if ($websiteCustomer) {
                    $websiteCustomer->update([
                        'name' => $request->name,
                        'phone' => $request->phone,
                    ]);
                }

                // Actualizar sesión
                Session::put('customer_data', array_merge(Session::get('customer_data'), [
                    'name' => $request->name,
                    'phone' => $request->phone,
                ]));

                return response()->json([
                    'success' => true,
                    'message' => 'Perfil actualizado exitosamente'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el perfil'
            ], 400);
        } catch (\Exception $e) {
            Log::error('Error actualizando perfil', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la actualización'
            ], 500);
        }
    }

    /**
     * Cambiar contraseña
     */
    public function updatePassword(Request $request, $websiteSlug)
    {
        $website = Website::where('slug', $websiteSlug)->firstOrFail();

        if (!Session::has('customer_logged_in') || !Session::get('customer_logged_in')) {
            return response()->json([
                'success' => false,
                'message' => 'No hay sesión activa'
            ], 401);
        }

        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        try {
            $adminNegociosUserId = Session::get('customer_admin_negocios_id');
            $token = Session::get('customer_token');

            // Actualizar contraseña en AdminNegocios
            $apiUrl = rtrim($website->api_base_url, '/');
            $response = Http::timeout(10)
                ->withHeaders(['Authorization' => 'Bearer ' . $token])
                ->put($apiUrl . '/user/updatePassword/' . $adminNegociosUserId, [
                    'current_password' => $request->current_password,
                    'password' => $request->new_password,
                    'password_confirmation' => $request->new_password_confirmation,
                ]);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Contraseña actualizada exitosamente'
                ]);
            }

            $data = $response->json();
            return response()->json([
                'success' => false,
                'message' => $data['message'] ?? 'Error al actualizar la contraseña'
            ], 400);
        } catch (\Exception $e) {
            Log::error('Error actualizando contraseña', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la actualización'
            ], 500);
        }
    }


    /**
     * API: Listar direcciones para el checkout
     */
    public function apiAddresses(Request $request)
    {
        Log::info('📍 apiAddresses - Inicio', [
            'website_param' => $request->input('website')
        ]);

        $website = $this->getWebsiteFromRequest($request);

        if (!$this->isCustomerLoggedIn()) {
            Log::warning('❌ Usuario no autenticado intentando obtener direcciones');
            return response()->json([
                'success' => false,
                'message' => 'Debes iniciar sesión para continuar'
            ], 401);
        }

        if (!$website) {
            Log::error('❌ Website no encontrado', ['request' => $request->all()]);
            return response()->json([
                'success' => false,
                'message' => 'Tienda no encontrada'
            ], 404);
        }

        Log::info('🌐 Website encontrado para direcciones', [
            'website_id' => $website->id,
            'customer_id' => Session::get('customer_id'),
            'admin_negocios_id' => Session::get('customer_admin_negocios_id')
        ]);

        $addresses = $this->fetchCustomerAddresses($website);

        Log::info('✅ Direcciones obtenidas', [
            'count' => count($addresses)
        ]);

        return response()->json([
            'success' => true,
            'addresses' => $addresses
        ]);
    }

    /**
     * API: Crear dirección desde el checkout
     */
    public function apiStoreAddress(Request $request)
    {
        $website = $this->getWebsiteFromRequest($request);

        if (!$website) {
            return response()->json([
                'success' => false,
                'message' => 'Tienda no encontrada'
            ], 404);
        }

        if (!$this->isCustomerLoggedIn()) {
            return response()->json([
                'success' => false,
                'message' => 'Debes iniciar sesión para continuar'
            ], 401);
        }

        $request->validate([
            'direccion' => 'required|string|max:500',
            'barrio' => 'required|string|max:100',
            'ciudad' => 'required|string|max:100',
            'codigo_postal' => 'nullable|string|max:20',
        ]);

        $created = $this->createCustomerAddress($website, $request);

        if (!$created) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo crear la dirección'
            ], 500);
        }

        $addresses = $this->fetchCustomerAddresses($website);

        return response()->json([
            'success' => true,
            'addresses' => $addresses
        ]);
    }

    /**
     * API: Actualizar dirección existente
     */
    public function apiUpdateAddress(Request $request, $id)
    {
        $website = $this->getWebsiteFromRequest($request);

        if (!$website) {
            return response()->json([
                'success' => false,
                'message' => 'Tienda no encontrada'
            ], 404);
        }

        if (!$this->isCustomerLoggedIn()) {
            return response()->json([
                'success' => false,
                'message' => 'Debes iniciar sesión para continuar'
            ], 401);
        }

        $request->validate([
            'direccion' => 'required|string|max:500',
            'barrio' => 'required|string|max:100',
            'ciudad' => 'required|string|max:100',
        ]);

        $updated = $this->updateCustomerAddress($website, $id, $request);

        if (!$updated) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo actualizar la dirección'
            ], 500);
        }

        $addresses = $this->fetchCustomerAddresses($website);

        return response()->json([
            'success' => true,
            'addresses' => $addresses
        ]);
    }

    /**
     * API: Eliminar dirección
     */
    public function apiDeleteAddress(Request $request, $id)
    {
        $website = $this->getWebsiteFromRequest($request);

        if (!$website) {
            return response()->json([
                'success' => false,
                'message' => 'Tienda no encontrada'
            ], 404);
        }

        if (!$this->isCustomerLoggedIn()) {
            return response()->json([
                'success' => false,
                'message' => 'Debes iniciar sesión para continuar'
            ], 401);
        }

        $deleted = $this->deleteCustomerAddress($website, $id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo eliminar la dirección'
            ], 500);
        }

        $addresses = $this->fetchCustomerAddresses($website);

        return response()->json([
            'success' => true,
            'message' => 'Dirección eliminada exitosamente',
            'addresses' => $addresses
        ]);
    }

    private function isCustomerLoggedIn(): bool
    {
        return Session::has('customer_logged_in') && Session::get('customer_logged_in');
    }

    private function getWebsiteFromRequest(Request $request): ?Website
    {
        $slug = $request->input('website');
        if (!$slug) {
            return null;
        }

        return Website::where('slug', $slug)->first();
    }

    private function createCustomerAddress(Website $website, Request $request)
    {
        $customerAdminNegociosId = Session::get('customer_admin_negocios_id');

        Log::info('🏠 createCustomerAddress - Inicio', [
            'website_id' => $website->id,
            'user_id' => $customerAdminNegociosId,
            'has_api_url' => !empty($website->api_base_url),
            'has_api_key' => !empty($website->api_key)
        ]);

        if (!$website->api_base_url || !$website->api_key || !$customerAdminNegociosId) {
            Log::error('❌ Faltan datos para crear dirección', [
                'has_api_url' => !empty($website->api_base_url),
                'has_api_key' => !empty($website->api_key),
                'has_user_id' => !empty($customerAdminNegociosId)
            ]);
            return null;
        }

        try {
            $payload = [
                'user_id' => $customerAdminNegociosId,
                'direccion' => $request->direccion,
                'barrio' => $request->barrio,
                'ciudad' => $request->ciudad,
                'codigo_postal' => $request->codigo_postal,
            ];

            Log::info('📤 Enviando dirección a AdminNegocios', $payload);

            $response = Http::timeout(15)
                ->withHeaders([
                    'X-API-Key' => $website->api_key,
                    'Accept' => 'application/json',
                ])
                ->post(rtrim($website->api_base_url, '/') . '/api-key/addresses', $payload);

            Log::info('📨 Respuesta de AdminNegocios (crear dirección)', [
                'status' => $response->status(),
                'successful' => $response->successful(),
                'body' => $response->json()
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning('⚠️ No se pudo crear dirección', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('❌ Error creando dirección', [
                'error' => $e->getMessage(),
                'website_id' => $website->id,
            ]);

            return null;
        }
    }

    /**
     * Obtener direcciones del cliente desde AdminNegocios
     */
    private function fetchCustomerAddresses(Website $website)
    {
        Log::info('🔍 fetchCustomerAddresses - Inicio', [
            'website_id' => $website->id,
            'has_api_url' => !empty($website->api_base_url),
            'has_api_key' => !empty($website->api_key)
        ]);

        if (!$website->api_base_url || !$website->api_key) {
            Log::warning('⚠️ Website sin API configurada');
            return collect();
        }

        $token = Session::get('customer_token');
        $customerAdminNegociosId = Session::get('customer_admin_negocios_id');
        $appKey = config('services.admin_negocios.app_key');

        Log::info('🔑 Credenciales para obtener direcciones', [
            'has_token' => !empty($token),
            'customer_admin_negocios_id' => $customerAdminNegociosId,
            'has_app_key' => !empty($appKey)
        ]);

        if (!$customerAdminNegociosId) {
            Log::warning('⚠️ No hay customer_admin_negocios_id en sesión');
            return collect();
        }

        try {
            $url = rtrim($website->api_base_url, '/') . '/api-key/addresses';
            Log::info('📡 Consultando direcciones en AdminNegocios', [
                'url' => $url,
                'user_id' => $customerAdminNegociosId
            ]);

            $response = Http::timeout(15)
                ->withHeaders([
                    'X-API-Key' => $website->api_key,
                    'Accept' => 'application/json',
                ])
                ->get($url, [
                    'user_id' => $customerAdminNegociosId,
                ]);

            Log::info('📨 Respuesta de AdminNegocios (direcciones)', [
                'status' => $response->status(),
                'successful' => $response->successful(),
                'body_preview' => substr($response->body(), 0, 500)
            ]);

            if (!$response->successful()) {
                Log::warning('❌ No se pudieron obtener direcciones externas', [
                    'status' => $response->status(),
                    'body' => $response->json(),
                ]);
                return collect();
            }

            $payload = $response->json();
            $addressesRaw = $payload['data'] ?? $payload ?? [];

            Log::info('✅ Direcciones externas recibidas', [
                'count' => is_array($addressesRaw) ? count($addressesRaw) : 0,
                'payload' => $payload,
            ]);

            $addresses = collect(is_array($addressesRaw) ? $addressesRaw : [])->map(function ($address) {
                return (object)[
                    'id' => $address['id'] ?? null,
                    'direccion' => $address['direccion'] ?? '',
                    'barrio' => $address['barrio'] ?? '',
                    'ciudad' => $address['ciudad'] ?? '',
                    'codigo_postal' => $address['codigo_postal'] ?? null,
                    'lat' => $address['latitud'] ?? $address['lat'] ?? null,
                    'lng' => $address['longitud'] ?? $address['lng'] ?? null,
                    'name' => $address['nombre'] ?? $address['alias'] ?? 'Dirección',
                    'address' => $address['direccion'] ?? '',
                    'city' => $address['ciudad'] ?? '',
                    'state' => $address['barrio'] ?? '',
                    'reference' => $address['referencia'] ?? null,
                    'phone' => $address['phone'] ?? $address['telefono'] ?? null,
                    'is_primary' => (bool)($address['principal'] ?? false),
                    'created_at' => isset($address['created_at']) ? \Carbon\Carbon::parse($address['created_at']) : null,
                ];
            });

            return $addresses;
        } catch (\Exception $e) {
            Log::error('Error obteniendo direcciones externas', [
                'error' => $e->getMessage(),
                'website_id' => $website->id,
            ]);

            return collect();
        }
    }

    /**
     * Actualizar dirección del cliente en AdminNegocios
     */
    private function updateCustomerAddress(Website $website, $addressId, Request $request)
    {
        $customerAdminNegociosId = Session::get('customer_admin_negocios_id');

        Log::info('🏠 updateCustomerAddress - Inicio', [
            'website_id' => $website->id,
            'address_id' => $addressId,
            'user_id' => $customerAdminNegociosId,
            'has_api_url' => !empty($website->api_base_url),
            'has_api_key' => !empty($website->api_key)
        ]);

        if (!$website->api_base_url || !$website->api_key || !$customerAdminNegociosId) {
            Log::error('❌ Faltan datos para actualizar dirección', [
                'has_api_url' => !empty($website->api_base_url),
                'has_api_key' => !empty($website->api_key),
                'has_user_id' => !empty($customerAdminNegociosId)
            ]);
            return null;
        }

        try {
            $payload = [
                'user_id' => $customerAdminNegociosId,
                'direccion' => $request->direccion,
                'barrio' => $request->barrio,
                'ciudad' => $request->ciudad,
                'codigo_postal' => $request->codigo_postal,
            ];

            Log::info('📤 Enviando actualización de dirección a AdminNegocios', $payload);

            $response = Http::timeout(15)
                ->withHeaders([
                    'X-API-Key' => $website->api_key,
                    'Accept' => 'application/json',
                ])
                ->put(rtrim($website->api_base_url, '/') . '/api-key/addresses/' . $addressId, $payload);

            Log::info('📨 Respuesta de AdminNegocios (actualizar dirección)', [
                'status' => $response->status(),
                'successful' => $response->successful(),
                'body' => $response->json()
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning('⚠️ No se pudo actualizar dirección', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('❌ Error actualizando dirección', [
                'error' => $e->getMessage(),
                'website_id' => $website->id,
                'address_id' => $addressId,
            ]);

            return null;
        }
    }

    /**
     * Eliminar dirección del cliente en AdminNegocios
     */
    private function deleteCustomerAddress(Website $website, $addressId)
    {
        $customerAdminNegociosId = Session::get('customer_admin_negocios_id');

        Log::info('🗑️ deleteCustomerAddress - Inicio', [
            'website_id' => $website->id,
            'address_id' => $addressId,
            'user_id' => $customerAdminNegociosId,
            'has_api_url' => !empty($website->api_base_url),
            'has_api_key' => !empty($website->api_key)
        ]);

        if (!$website->api_base_url || !$website->api_key || !$customerAdminNegociosId) {
            Log::error('❌ Faltan datos para eliminar dirección', [
                'has_api_url' => !empty($website->api_base_url),
                'has_api_key' => !empty($website->api_key),
                'has_user_id' => !empty($customerAdminNegociosId)
            ]);
            return false;
        }

        try {
            $response = Http::timeout(15)
                ->withHeaders([
                    'X-API-Key' => $website->api_key,
                    'Accept' => 'application/json',
                ])
                ->delete(rtrim($website->api_base_url, '/') . '/api-key/addresses/' . $addressId);

            Log::info('📨 Respuesta de AdminNegocios (eliminar dirección)', [
                'status' => $response->status(),
                'successful' => $response->successful(),
                'body' => $response->json()
            ]);

            if ($response->successful()) {
                return true;
            }

            Log::warning('⚠️ No se pudo eliminar dirección', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('❌ Error eliminando dirección', [
                'error' => $e->getMessage(),
                'website_id' => $website->id,
                'address_id' => $addressId,
            ]);

            return false;
        }
    }

    /**
     * Obtener pedidos del cliente desde AdminNegocios
     */
    private function fetchCustomerOrders(Website $website)
    {
        Log::info('🛒 fetchCustomerOrders - Inicio', [
            'website_id' => $website->id,
            'has_api_url' => !empty($website->api_base_url),
            'has_api_key' => !empty($website->api_key)
        ]);

        if (!$website->api_base_url || !$website->api_key) {
            Log::warning('⚠️ Website sin API configurada para pedidos');
            return collect();
        }

        $token = Session::get('customer_token');
        $customerAdminNegociosId = Session::get('customer_admin_negocios_id');
        $appKey = config('services.admin_negocios.app_key');

        Log::info('🔑 Credenciales para obtener pedidos', [
            'has_token' => !empty($token),
            'customer_admin_negocios_id' => $customerAdminNegociosId,
            'has_app_key' => !empty($appKey)
        ]);

        if (!$customerAdminNegociosId) {
            Log::warning('⚠️ No hay customer_admin_negocios_id en sesión');
            return collect();
        }

        try {
            // Usar la ruta correcta con API Key (no requiere JWT)
            $url = rtrim($website->api_base_url, '/') . '/api-key/orders';
            Log::info('📡 Consultando pedidos en AdminNegocios', [
                'url' => $url,
                'user_id' => $customerAdminNegociosId,
                'api_key_preview' => substr($website->api_key, 0, 10) . '...'
            ]);

            $response = Http::timeout(15)
                ->withHeaders([
                    'X-API-Key' => $website->api_key,
                    'Accept' => 'application/json',
                ])
                ->get($url, [
                    'user_id' => $customerAdminNegociosId,
                ]);

            Log::info('📨 Respuesta COMPLETA de AdminNegocios (pedidos)', [
                'status' => $response->status(),
                'successful' => $response->successful(),
                'headers' => $response->headers(),
                'body_full' => $response->body(),
                'json_decoded' => $response->json()
            ]);

            if (!$response->successful()) {
                Log::warning('❌ No se pudieron obtener pedidos externos', [
                    'status' => $response->status(),
                    'body' => $response->json(),
                ]);
                return collect();
            }

            $payload = $response->json();
            $ordersRaw = $payload['data'] ?? $payload ?? [];

            Log::info('✅ Pedidos externos procesados', [
                'count' => is_array($ordersRaw) ? count($ordersRaw) : 0,
                'payload_keys' => array_keys($payload),
                'first_order' => is_array($ordersRaw) && count($ordersRaw) > 0 ? $ordersRaw[0] : null,
                'orders_raw' => $ordersRaw
            ]);

            $orders = collect(is_array($ordersRaw) ? $ordersRaw : [])->map(function ($order) {
                // Calcular el total sumando precio * cantidad de cada producto
                $productos = $order['productos'] ?? [];
                $total = 0;
                if (is_array($productos)) {
                    foreach ($productos as $producto) {
                        $precio = floatval($producto['precio'] ?? 0);
                        $cantidad = intval($producto['cantidad'] ?? 0);
                        $total += $precio * $cantidad;
                    }
                }
                
                return (object)[
                    'id' => $order['id'] ?? null,
                    'order_number' => $order['id'] ?? $order['order_number'] ?? null,
                    'total' => $total,
                    'status' => $order['estado'] ?? $order['status'] ?? 'pending',
                    'estado' => $order['estado'] ?? 'pendiente',
                    'created_at' => isset($order['created_at']) ? \Carbon\Carbon::parse($order['created_at']) : null,
                    'productos' => $productos,
                    'items_count' => is_array($productos) ? count($productos) : 0,
                    'payment_method' => $order['medio_pago'] ?? $order['payment_method'] ?? null,
                    'direccion' => $order['direccion'] ?? null,
                    'barrio' => $order['barrio'] ?? null,
                ];
            });

            Log::info('🎯 Pedidos TRANSFORMADOS para la vista', [
                'count' => $orders->count(),
                'orders' => $orders->toArray()
            ]);

            return $orders;
        } catch (\Exception $e) {
            Log::error('Error obteniendo pedidos externos', [
                'error' => $e->getMessage(),
                'website_id' => $website->id,
            ]);

            return collect();
        }
    }
}
