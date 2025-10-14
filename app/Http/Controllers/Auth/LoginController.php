<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthEME10Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    protected AuthEME10Service $authService;

    public function __construct(AuthEME10Service $authService)
    {
        $this->authService = $authService;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Intentar login con Auth EME10
        $result = $this->authService->login($request->email, $request->password);

        if (!$result['success']) {
            throw ValidationException::withMessages([
                'email' => $result['message'] ?? 'Credenciales incorrectas',
            ]);
        }

        // Si requiere 2FA
        if ($result['requires_two_factor']) {
            session([
                'two_factor_temp_token' => $result['temp_token'],
                'two_factor_email' => $request->email,
            ]);

            return redirect()->route('two-factor.show')->with([
                'message' => $result['message'],
                'sent_to' => $result['sent_to'],
                'method' => $result['method'],
            ]);
        }

        // Login exitoso - buscar o crear usuario local
        $user = $this->findOrCreateLocalUser($result['user'], $result['token']);

        // Autenticar usuario localmente
        Auth::login($user, $request->filled('remember'));
        $request->session()->regenerate();

        // Crear sesión en Auth EME10
        $this->authService->createAppSession($result['token']);

        // Redirigir según el rol del usuario
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('creator.select-website');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        // Cerrar sesión en Auth EME10 si está sincronizado
        if ($user && $user->isSyncedWithAuthEME10()) {
            $token = $user->getAuthEME10Token();
            $this->authService->logout($token);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
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
}

