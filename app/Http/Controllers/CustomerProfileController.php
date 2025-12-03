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

        return $this->renderWithTemplate(
            $website,
            'Mi Perfil',
            'profile',
            'customer.profile-content',
            [
                'customerData' => $customerData,
                'addresses' => $addresses
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
     * Mostrar direcciones del cliente
     */
    public function addresses($websiteSlug)
    {
        $website = Website::where('slug', $websiteSlug)->firstOrFail();

        $authCheck = $this->checkAuth($websiteSlug);
        if ($authCheck) return $authCheck;

        $customerData = Session::get('customer_data');
        $addresses = $this->fetchCustomerAddresses($website);

        return $this->renderWithTemplate(
            $website,
            'Mis Direcciones',
            'addresses',
            'customer.addresses-content',
            ['customerData' => $customerData, 'addresses' => $addresses]
        );
    }

    /**
     * Guardar nueva dirección
     */
    public function storeAddress(Request $request, $websiteSlug)
    {
        $website = Website::where('slug', $websiteSlug)->firstOrFail();

        if (!Session::has('customer_logged_in') || !Session::get('customer_logged_in')) {
            return response()->json([
                'success' => false,
                'message' => 'No hay sesión activa'
            ], 401);
        }

        $validated = $request->validate([
            'direccion' => 'required|string|max:500',
            'barrio' => 'required|string|max:100',
            'ciudad' => 'required|string|max:100',
            'codigo_postal' => 'nullable|string|max:20',
        ]);

        $userId = Session::get('customer_admin_negocios_id');
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 401);
        }

        // Guardar dirección en AdminNegocios usando API key
        try {
            if (!$website->api_base_url || !$website->api_key) {
                return response()->json([
                    'success' => false,
                    'message' => 'La tienda no tiene configurada la integración con AdminNegocios'
                ], 500);
            }

            $apiUrl = rtrim($website->api_base_url, '/') . '/api-key/addresses';
            $response = Http::withHeaders([
                'X-API-Key' => $website->api_key,
                'Content-Type' => 'application/json',
            ])->post($apiUrl, [
                'user_id' => $userId,
                'direccion' => $validated['direccion'],
                'barrio' => $validated['barrio'],
                'ciudad' => $validated['ciudad'],
                'codigo_postal' => $validated['codigo_postal'] ?? null,
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                return response()->json([
                    'success' => true,
                    'message' => $responseData['message'] ?? 'Dirección guardada exitosamente',
                    'data' => $responseData['data'] ?? null
                ]);
            }

            $errorMessage = $response->json()['message'] ?? 'Error al guardar la dirección';
            return response()->json([
                'success' => false,
                'message' => $errorMessage
            ], $response->status());
        } catch (\Exception $e) {
            Log::error('Error al guardar dirección', [
                'error' => $e->getMessage(),
                'user_id' => $userId
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error de conexión: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar dirección existente
     */
    public function updateAddress(Request $request, $websiteSlug, $id)
    {
        // TODO: Implementar actualización de dirección

        return response()->json([
            'success' => true,
            'message' => 'Dirección actualizada exitosamente'
        ]);
    }

    /**
     * Eliminar dirección
     */
    public function deleteAddress($websiteSlug, $id)
    {
        // TODO: Implementar eliminación de dirección

        return response()->json([
            'success' => true,
            'message' => 'Dirección eliminada exitosamente'
        ]);
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
}
