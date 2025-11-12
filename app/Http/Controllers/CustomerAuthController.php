<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Models\WebsiteCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

/**
 * Controlador para autenticación de clientes desde la tienda pública
 * 
 * Este controlador permite que los usuarios que ya tienen cuenta en AdminNegocios
 * puedan hacer login desde cualquier tienda creada con el creador de tiendas.
 */
class CustomerAuthController extends Controller
{
    /**
     * Login de cliente usando credenciales de AdminNegocios
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'website_slug' => 'required',
        ]);

        // Buscar el website
        $website = Website::where('slug', $request->website_slug)->first();
        
        if (!$website) {
            return response()->json([
                'success' => false,
                'message' => 'Tienda no encontrada'
            ], 404);
        }

        // Verificar que la tienda tenga configurada la API de AdminNegocios
        if (!$website->api_base_url || !$website->api_key) {
            return response()->json([
                'success' => false,
                'message' => 'Esta tienda no tiene configurada la integración con AdminNegocios'
            ], 400);
        }

        try {
            // Intentar login en AdminNegocios
            $apiUrl = rtrim($website->api_base_url, '/');
            
            Log::info('Intentando login de cliente', [
                'email' => $request->email,
                'api_url' => $apiUrl,
                'website_id' => $website->id
            ]);

            $response = Http::timeout(10)->post($apiUrl . '/login', [
                'email' => $request->email,
                'password' => $request->password,
            ]);

            $data = $response->json();

            if (!$response->successful() || !isset($data['success']) || !$data['success']) {
                Log::warning('Login fallido desde tienda', [
                    'email' => $request->email,
                    'response' => $data
                ]);

                return response()->json([
                    'success' => false,
                    'message' => $data['message'] ?? 'Credenciales incorrectas'
                ], 401);
            }

            // Login exitoso
            $user = $data['user'];
            $token = $data['token'];

            // Registrar o actualizar en website_customers
            $websiteCustomer = WebsiteCustomer::updateOrCreate(
                [
                    'website_id' => $website->id,
                    'admin_negocios_user_id' => $user['id'],
                ],
                [
                    'email' => $user['email'],
                    'name' => $user['name'] ?? $user['email'],
                    'phone' => $user['phone'] ?? null,
                ]
            );

            // Registrar el login
            $websiteCustomer->recordLogin();

            // Guardar en sesión
            Session::put('customer_logged_in', true);
            Session::put('customer_id', $websiteCustomer->id);
            Session::put('customer_admin_negocios_id', $user['id']);
            Session::put('customer_token', $token);
            Session::put('customer_data', [
                'id' => $user['id'],
                'email' => $user['email'],
                'name' => $user['name'] ?? $user['email'],
                'phone' => $user['phone'] ?? null,
            ]);

            Log::info('Login de cliente exitoso', [
                'email' => $request->email,
                'website_customer_id' => $websiteCustomer->id,
                'admin_negocios_user_id' => $user['id']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Login exitoso',
                'customer' => [
                    'id' => $websiteCustomer->id,
                    'admin_negocios_id' => $user['id'],
                    'email' => $user['email'],
                    'name' => $user['name'] ?? $user['email'],
                    'phone' => $user['phone'] ?? null,
                    'total_orders' => $websiteCustomer->total_orders,
                    'total_spent' => $websiteCustomer->total_spent,
                ],
                'token' => $token, // Para usar en futuras peticiones si es necesario
            ]);

        } catch (\Exception $e) {
            Log::error('Error en login de cliente', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el login. Por favor, intenta nuevamente.'
            ], 500);
        }
    }

    /**
     * Logout de cliente
     */
    public function logout(Request $request)
    {
        Session::forget('customer_logged_in');
        Session::forget('customer_id');
        Session::forget('customer_admin_negocios_id');
        Session::forget('customer_token');
        Session::forget('customer_data');

        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada exitosamente'
        ]);
    }

    /**
     * Verificar si el cliente está autenticado
     */
    public function check(Request $request)
    {
        if (!Session::has('customer_logged_in') || !Session::get('customer_logged_in')) {
            return response()->json([
                'success' => false,
                'authenticated' => false,
                'message' => 'No hay sesión activa'
            ]);
        }

        return response()->json([
            'success' => true,
            'authenticated' => true,
            'customer' => Session::get('customer_data'),
        ]);
    }

    /**
     * Obtener información del cliente autenticado
     */
    public function me(Request $request)
    {
        if (!Session::has('customer_logged_in') || !Session::get('customer_logged_in')) {
            return response()->json([
                'success' => false,
                'message' => 'No hay sesión activa'
            ], 401);
        }

        $websiteCustomerId = Session::get('customer_id');
        $websiteCustomer = WebsiteCustomer::find($websiteCustomerId);

        if (!$websiteCustomer) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'customer' => [
                'id' => $websiteCustomer->id,
                'admin_negocios_id' => $websiteCustomer->admin_negocios_user_id,
                'email' => $websiteCustomer->email,
                'name' => $websiteCustomer->name,
                'phone' => $websiteCustomer->phone,
                'total_orders' => $websiteCustomer->total_orders,
                'total_spent' => $websiteCustomer->total_spent,
                'first_login_at' => $websiteCustomer->first_login_at,
                'last_login_at' => $websiteCustomer->last_login_at,
                'first_purchase_at' => $websiteCustomer->first_purchase_at,
                'last_purchase_at' => $websiteCustomer->last_purchase_at,
            ]
        ]);
    }

    /**
     * Registrar un nuevo usuario desde la tienda
     * (Opcional - si quieres permitir registro)
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:20',
            'website_slug' => 'required',
        ]);

        $website = Website::where('slug', $request->website_slug)->first();
        
        if (!$website) {
            return response()->json([
                'success' => false,
                'message' => 'Tienda no encontrada'
            ], 404);
        }

        if (!$website->api_base_url) {
            return response()->json([
                'success' => false,
                'message' => 'Esta tienda no tiene configurada la integración con AdminNegocios'
            ], 400);
        }

        try {
            $apiUrl = rtrim($website->api_base_url, '/');
            
            // Intentar registro en AdminNegocios
            $response = Http::timeout(10)->post($apiUrl . '/register', [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'phone' => $request->phone,
            ]);

            $data = $response->json();

            if (!$response->successful() || !isset($data['success']) || !$data['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $data['message'] ?? 'Error al registrar usuario'
                ], 400);
            }

            // Registro exitoso, hacer login automático
            return $this->login($request);

        } catch (\Exception $e) {
            Log::error('Error en registro de cliente', [
                'email' => $request->email,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el registro. Por favor, intenta nuevamente.'
            ], 500);
        }
    }
}

