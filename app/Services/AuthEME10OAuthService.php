<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class AuthEME10OAuthService
{
    private string $baseUrl;
    private string $apiBaseUrl;
    private string $clientId;
    private string $redirectUri;

    public function __construct()
    {
        $this->baseUrl = config('services.auth_eme10.base_url', 'https://auth.eme10.com');
        $this->apiBaseUrl = $this->baseUrl . '/api';
        $this->clientId = config('services.auth_eme10.client_id', '1');
        $this->redirectUri = config('services.auth_eme10.redirect_uri', url('/auth/oauth/callback'));
    }

    /**
     * Generar URL de autorización OAuth2
     */
    public function getAuthorizationUrl(): string
    {
        $state = Str::random(40);
        
        // Guardar state en sesión para validación CSRF
        session(['oauth_state' => $state]);
        
        Log::info('OAuth Authorization URL Generated', [
            'state' => $state,
            'session_id' => session()->getId(),
            'redirect_uri' => $this->redirectUri
        ]);
        
        $params = http_build_query([
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'response_type' => 'code',
            'scope' => '',
            'state' => $state,
        ]);

        return "{$this->baseUrl}/oauth/authorize?{$params}";
    }

    /**
     * Intercambiar código de autorización por token de acceso
     */
    public function getAccessToken(string $code): ?array
    {
        try {
            Log::info('Intentando obtener access token', [
                'code_preview' => substr($code, 0, 10) . '...',
            'redirect_uri' => $this->redirectUri
        ]);
        
            $response = Http::asForm()->post("{$this->baseUrl}/oauth/token", [
                'grant_type' => 'authorization_code',
                'client_id' => $this->clientId,
                'redirect_uri' => $this->redirectUri,
                'code' => $code,
            ]);

            Log::info('Respuesta de token endpoint', [
                'status' => $response->status(),
                'successful' => $response->successful(),
                'body' => $response->body()
            ]);

            if (!$response->successful()) {
                Log::error('Error al obtener access token', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return null;
            }

            $data = $response->json();
            
            Log::info('Access token obtenido exitosamente', [
                'token_type' => $data['token_type'] ?? 'unknown',
                'expires_in' => $data['expires_in'] ?? 'unknown'
            ]);

            return $data;
        } catch (\Exception $e) {
            Log::error('Excepción al obtener access token', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Validar state OAuth (protección CSRF)
     */
    public function validateState(string $receivedState): bool
    {
        $sessionState = session('oauth_state');
        
        if (!$sessionState) {
            Log::warning('No hay state en sesión');
            return false;
        }
        
        $isValid = hash_equals($sessionState, $receivedState);
        
        if ($isValid) {
            // Limpiar state de la sesión después de validarlo
            session()->forget('oauth_state');
        }
        
        return $isValid;
    }

    /**
     * Obtener información del usuario autenticado
     */
    public function getUserProfile(string $token): ?array
    {
        try {
            $url = "{$this->apiBaseUrl}/auth/profile";
            
            Log::info('Intentando obtener perfil de usuario', [
                'token_preview' => substr($token, 0, 20) . '...',
                'url_completa' => $url,
                'base_url' => $this->baseUrl,
                'api_base_url' => $this->apiBaseUrl
            ]);
            
            // El endpoint correcto es GET /api/auth/profile (sin CSRF para Bearer tokens)
                $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
                'Accept' => 'application/json',
            ])->get($url);
            
            Log::info("Respuesta GET {$url}", [
                'status' => $response->status(),
                'successful' => $response->successful(),
                'body_preview' => substr($response->body(), 0, 200)
            ]);
            
            if ($response->successful()) {
                $responseData = $response->json();
                $profile = $responseData['data']['user'] ?? $responseData;
                
                Log::info('Perfil obtenido exitosamente', [
                    'user_id' => $profile['id'] ?? 'unknown',
                    'email' => $profile['email'] ?? 'unknown'
                ]);
                return $profile;
            }

            Log::error('Error en respuesta de Auth EME10', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Excepción al obtener perfil de usuario', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Crear sesión de aplicación en Auth EME10
     */
    public function createAppSession(string $token): bool
    {
        try {
            $appName = config('app.name', 'Creador de Sitios Web');
            
            Log::info('Registrando sesión de app en Auth EME10', [
                'app_name' => $appName
            ]);
            
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
                'Accept' => 'application/json',
            ])->post("{$this->apiBaseUrl}/app-sessions/register", [
                'app_name' => $appName,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            if ($response->successful()) {
                Log::info('Sesión de app registrada exitosamente', [
                    'response' => $response->json()
                ]);
                return true;
            }

            Log::warning('No se pudo registrar sesión de app', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('Excepción al crear sesión de app', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Cerrar sesión en Auth EME10
     */
    public function logout(string $token): bool
    {
        try {
            Log::info('Cerrando sesión en Auth EME10');
            
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
                'Accept' => 'application/json',
            ])->post("{$this->apiBaseUrl}/auth/logout");

            if ($response->successful()) {
                Log::info('Sesión cerrada exitosamente en Auth EME10');
                return true;
            }

            Log::warning('No se pudo cerrar sesión en Auth EME10', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('Excepción al cerrar sesión', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
