<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthEME10OAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OAuthController extends Controller
{
    protected AuthEME10OAuthService $oauthService;

    public function __construct(AuthEME10OAuthService $oauthService)
    {
        $this->oauthService = $oauthService;
    }

    /**
     * Redirigir a Auth EME10 para login OAuth
     */
    public function redirect()
    {
        $authUrl = $this->oauthService->getAuthorizationUrl();
        return redirect()->away($authUrl);
    }

    /**
     * Página de callback que procesa el token desde el hash
     */
    public function callback()
    {
        // Esta vista tiene JavaScript que procesa el token del hash
        return view('auth.oauth-callback');
    }

    /**
     * Endpoint que recibe el token procesado por JavaScript
     */
    public function handleToken(Request $request)
    {
        $request->validate([
            'access_token' => 'required|string',
            'state' => 'required|string',
        ]);

        // Validar state (protección CSRF)
        \Log::info('OAuth State Validation', [
            'received_state' => $request->state,
            'session_state' => session('oauth_state'),
            'session_id' => session()->getId(),
            'all_session' => session()->all()
        ]);
        
        if (!$this->oauthService->validateState($request->state)) {
            \Log::error('OAuth State Validation Failed', [
                'received_state' => $request->state,
                'session_state' => session('oauth_state'),
                'session_id' => session()->getId()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Estado OAuth inválido - posible ataque CSRF',
            ], 400);
        }

        // Obtener perfil del usuario desde Auth EME10
        $userProfile = $this->oauthService->getUserProfile($request->access_token);

        if (!$userProfile) {
            \Log::error('No se pudo obtener perfil del usuario', [
                'token_preview' => substr($request->access_token, 0, 20) . '...',
                'expires_in' => $request->get('expires_in')
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'No se pudo obtener el perfil del usuario',
            ], 400);
        }
        
        \Log::info('Perfil de usuario obtenido exitosamente', [
            'user_id' => $userProfile['id'] ?? 'unknown',
            'email' => $userProfile['email'] ?? 'unknown'
        ]);

        // Buscar o crear usuario local
        $user = $this->findOrCreateLocalUser($userProfile, $request->access_token);

        // Autenticar usuario localmente
        Auth::login($user);
        $request->session()->regenerate();

        // Crear sesión en Auth EME10
        $this->oauthService->createAppSession($request->access_token);

        // Determinar redirección según rol
        $redirectUrl = $user->isAdmin() 
            ? route('admin.dashboard') 
            : route('creator.select-website');

        return response()->json([
            'success' => true,
            'redirect_url' => $redirectUrl,
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ]);
    }

    /**
     * Buscar o crear usuario local desde datos de Auth EME10
     */
    protected function findOrCreateLocalUser(array $userData, string $token): User
    {
        // Buscar por auth_eme10_id
        $user = User::where('auth_eme10_id', $userData['id'])->first();

        if ($user) {
            // Actualizar token y datos
            $user->updateAuthEME10Token($token);
            $user->syncFromAuthEME10($userData);
            return $user;
        }

        // Buscar por email (usuarios existentes antes de la integración)
        $user = User::where('email', $userData['email'])->first();

        if ($user) {
            // Vincular con Auth EME10
            $user->update([
                'auth_eme10_id' => $userData['id'],
                'auth_eme10_token' => $token,
                'phone' => $userData['phone'] ?? $user->phone,
                'avatar' => $userData['avatar'] ?? $user->avatar,
                'two_factor_enabled' => $userData['two_factor_enabled'] ?? false,
                'last_auth_sync' => now(),
            ]);
            return $user;
        }

        // Crear nuevo usuario
        $user = User::create([
            'auth_eme10_id' => $userData['id'],
            'name' => $userData['name'],
            'email' => $userData['email'],
            'phone' => $userData['phone'] ?? null,
            'avatar' => $userData['avatar'] ?? null,
            'password' => bcrypt(uniqid()), // Password dummy ya que Auth EME10 maneja la auth
            'role' => 'creator', // Por defecto todos los nuevos son creadores
            'plan_id' => 1, // Plan gratuito por defecto
            'is_active' => $userData['is_active'] ?? true,
            'auth_eme10_token' => $token,
            'two_factor_enabled' => $userData['two_factor_enabled'] ?? false,
            'last_auth_sync' => now(),
        ]);

        return $user;
    }

    /**
     * Logout OAuth
     */
    public function logout(Request $request)
    {
        $user = Auth::user();

        // Cerrar sesión en Auth EME10 si está sincronizado
        if ($user && $user->isSyncedWithAuthEME10()) {
            $token = $user->getAuthEME10Token();
            $this->oauthService->logout($token);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

