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
        Log::info('🔐 CustomerAuth::login - Inicio', [
            'email' => $request->email,
            'website_slug' => $request->website_slug,
            'has_captcha' => !empty($request->captcha_token)
        ]);

        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
                'website_slug' => 'required',
                'captcha_token' => 'nullable|string', // CAPTCHA token opcional
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('❌ Validación fallida', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Datos de login inválidos',
                'errors' => $e->errors()
            ], 422);
        }

        // Buscar el website
        $website = Website::where('slug', $request->website_slug)->first();

        Log::info('🌐 Website encontrado', [
            'website_id' => $website->id ?? null,
            'api_base_url' => $website->api_base_url ?? null
        ]);

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
                'website_id' => $website->id,
                'has_captcha_token' => !empty($request->captcha_token),
                'captcha_token_length' => $request->captcha_token ? strlen($request->captcha_token) : 0,
                'captcha_token_preview' => $request->captcha_token ? substr($request->captcha_token, 0, 20) . '...' : null
            ]);

            $response = Http::timeout(10)->post($apiUrl . '/login', [
                'email' => $request->email,
                'password' => $request->password,
                'captcha_token' => $request->captcha_token, // Enviar CAPTCHA token a AdminNegocios
            ]);

            $data = $response->json();

            Log::info('Respuesta del servidor AdminNegocios', [
                'status' => $response->status(),
                'successful' => $response->successful(),
                'data' => $data
            ]);

            if (!$response->successful() || !isset($data['success']) || !$data['success']) {
                Log::warning('Login fallido desde tienda', [
                    'email' => $request->email,
                    'response_status' => $response->status(),
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

            // Construir nombre completo desde firstName y lastName
            $fullName = trim(($user['firstName'] ?? '') . ' ' . ($user['lastName'] ?? ''));
            if (empty($fullName)) {
                $fullName = $user['email'];
            }

            // Registrar o actualizar en website_customers
            $websiteCustomer = WebsiteCustomer::updateOrCreate(
                [
                    'website_id' => $website->id,
                    'admin_negocios_user_id' => $user['id'],
                ],
                [
                    'email' => $user['email'],
                    'name' => $fullName,
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
                'name' => $fullName,
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
                    'name' => $fullName,
                    'phone' => $user['phone'] ?? null,
                    'total_orders' => $websiteCustomer->total_orders,
                    'total_spent' => $websiteCustomer->total_spent,
                ],
                'token' => $token, // Para usar en futuras peticiones si es necesario
            ]);
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('❌ Error de conexión con AdminNegocios', [
                'email' => $request->email,
                'api_url' => $loginUrl ?? 'N/A',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'No se pudo conectar con el servidor de autenticación. Verifica tu conexión.'
            ], 500);
        } catch (\Exception $e) {
            Log::error('❌ Error general en login de cliente', [
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
            'captcha_token' => 'nullable|string', // CAPTCHA token opcional
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

            // Separar el nombre en firstName y lastName
            $nameParts = explode(' ', $request->name, 2);
            $firstName = $nameParts[0] ?? $request->name;
            $lastName = $nameParts[1] ?? '';

            // Intentar registro en AdminNegocios
            // Construir URL correctamente (evitar duplicar /api)
            $registerUrl = str_ends_with($apiUrl, '/api') ? $apiUrl . '/register' : $apiUrl . '/api/register';

            $response = Http::timeout(10)->post($registerUrl, [
                'firstName' => $firstName,
                'lastName' => $lastName,
                'email' => $request->email,
                'password' => $request->password,
                'password_confirmation' => $request->password, // AdminNegocios requiere confirmación
                'phone' => $request->phone,
                'captcha_token' => $request->captcha_token, // Enviar CAPTCHA token
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

    /**
     * Verificar si el usuario está autenticado
     */
    public function checkAuth(Request $request)
    {
        $isAuthenticated = Session::has('customer_logged_in') && Session::get('customer_logged_in');

        return response()->json([
            'authenticated' => $isAuthenticated,
            'user' => $isAuthenticated ? Session::get('customer_data') : null
        ]);
    }
}
