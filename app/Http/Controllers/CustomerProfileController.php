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
                    'meta_description' => $title,
                    'html_content' => view($contentView, array_merge($data, ['website' => $website]))->render(),
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
        
        return view($contentView, array_merge($data, ['website' => $website]));
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
        
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'reference' => 'nullable|string|max:255',
        ]);
        
        $created = $this->createCustomerAddress($website, $request);

        if (!$created) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo crear la dirección'
            ], 500);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Dirección guardada exitosamente'
        ]);
    }
    
    /**
     * Actualizar dirección existente
     */
    public function updateAddress(Request $request, $websiteSlug, $id)
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
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'reference' => 'nullable|string|max:255',
        ]);
        
        $updated = $this->updateCustomerAddress($website, $id, $request);

        if (!$updated) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo actualizar la dirección'
            ], 500);
        }
        
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
        $website = Website::where('slug', $websiteSlug)->firstOrFail();
        
        if (!Session::has('customer_logged_in') || !Session::get('customer_logged_in')) {
            return response()->json([
                'success' => false,
                'message' => 'No hay sesión activa'
            ], 401);
        }
        
        $deleted = $this->deleteCustomerAddress($website, $id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo eliminar la dirección'
            ], 500);
        }
        
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
        $website = $this->getWebsiteFromRequest($request);

        if (!$this->isCustomerLoggedIn()) {
            return response()->json([
                'success' => false,
                'message' => 'Debes iniciar sesión para continuar'
            ], 401);
        }

        if (!$website) {
            return response()->json([
                'success' => false,
                'message' => 'Tienda no encontrada'
            ], 404);
        }

        $addresses = $this->fetchCustomerAddresses($website);

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
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'reference' => 'nullable|string|max:255',
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
        $token = Session::get('customer_token');
        $customerAdminNegociosId = Session::get('customer_admin_negocios_id');
        $appKey = config('services.admin_negocios.app_key');

        if (!$website->api_base_url || !$token || !$customerAdminNegociosId) {
            return null;
        }

        try {
            $payload = [
                'user_id' => $customerAdminNegociosId,
                'direccion' => $request->address,
                'ciudad' => $request->city,
                'barrio' => $request->state,
                'postal_code' => $request->postal_code,
                'pais' => $request->country,
                'referencia' => $request->reference,
                'phone' => $request->phone,
                'alias' => $request->name,
                'latitud' => $request->input('lat'),
                'longitud' => $request->input('lng'),
            ];

            $response = Http::timeout(15)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'X-API-Key' => $website->api_key,
                    'X-App-Key' => $appKey,
                    'Accept' => 'application/json',
                ])
                ->post(rtrim($website->api_base_url, '/') . '/segundos/direcciones', $payload);

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning('No se pudo crear dirección externa', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Error creando dirección externa', [
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
        if (!$website->api_base_url || !$website->api_key) {
            return collect();
        }

        $token = Session::get('customer_token');
        $customerAdminNegociosId = Session::get('customer_admin_negocios_id');
        $appKey = config('services.admin_negocios.app_key');

        if (!$customerAdminNegociosId) {
            return collect();
        }

        try {
            $response = Http::timeout(15)
                ->withHeaders([
                    'Authorization' => $token ? 'Bearer ' . $token : '',
                    'X-API-Key' => $website->api_key,
                    'X-App-Key' => $appKey,
                    'Accept' => 'application/json',
                ])
                ->get(rtrim($website->api_base_url, '/').'/segundos/direcciones', [
                    'user_id' => $customerAdminNegociosId,
                ]);

            if (!$response->successful()) {
                Log::warning('No se pudieron obtener direcciones externas', [
                    'status' => $response->status(),
                    'body' => $response->json(),
                ]);
                return collect();
            }

            $payload = $response->json();
            $addressesRaw = $payload['data'] ?? $payload ?? [];

            Log::info('Direcciones externas recibidas', [
                'count' => is_array($addressesRaw) ? count($addressesRaw) : 0,
                'payload' => $payload,
            ]);

            $addresses = collect(is_array($addressesRaw) ? $addressesRaw : [])->map(function ($address) {
                return (object)[
                    'id' => $address['id'] ?? null,
                    'name' => $address['nombre'] ?? $address['alias'] ?? 'Dirección',
                    'address' => $address['direccion'] ?? '',
                    'city' => $address['ciudad'] ?? '',
                    'state' => $address['barrio'] ?? '',
                    'reference' => $address['referencia'] ?? null,
                    'phone' => $address['phone'] ?? $address['telefono'] ?? null,
                    'lat' => $address['latitud'] ?? $address['lat'] ?? null,
                    'lng' => $address['longitud'] ?? $address['lng'] ?? null,
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
        $token = Session::get('customer_token');
        $customerAdminNegociosId = Session::get('customer_admin_negocios_id');
        $appKey = config('services.admin_negocios.app_key');

        if (!$website->api_base_url || !$token || !$customerAdminNegociosId) {
            return null;
        }

        try {
            $payload = [
                'direccion' => $request->address,
                'ciudad' => $request->city,
                'barrio' => $request->state,
                'postal_code' => $request->postal_code,
                'pais' => $request->country,
                'referencia' => $request->reference,
                'phone' => $request->phone,
                'alias' => $request->name,
                'latitud' => $request->input('lat'),
                'longitud' => $request->input('lng'),
            ];

            $response = Http::timeout(15)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'X-API-Key' => $website->api_key,
                    'X-App-Key' => $appKey,
                    'Accept' => 'application/json',
                ])
                ->put(rtrim($website->api_base_url, '/') . '/segundos/direcciones/' . $addressId, $payload);

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning('No se pudo actualizar dirección externa', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Error actualizando dirección externa', [
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
        $token = Session::get('customer_token');
        $customerAdminNegociosId = Session::get('customer_admin_negocios_id');
        $appKey = config('services.admin_negocios.app_key');

        if (!$website->api_base_url || !$token || !$customerAdminNegociosId) {
            return null;
        }

        try {
            $response = Http::timeout(15)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'X-API-Key' => $website->api_key,
                    'X-App-Key' => $appKey,
                    'Accept' => 'application/json',
                ])
                ->delete(rtrim($website->api_base_url, '/') . '/segundos/direcciones/' . $addressId);

            if ($response->successful()) {
                return true;
            }

            Log::warning('No se pudo eliminar dirección externa', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('Error eliminando dirección externa', [
                'error' => $e->getMessage(),
                'website_id' => $website->id,
                'address_id' => $addressId,
            ]);

            return false;
        }
    }
}

