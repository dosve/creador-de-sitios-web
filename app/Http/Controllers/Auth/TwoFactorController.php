<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthEME10Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TwoFactorController extends Controller
{
    protected AuthEME10Service $authService;

    public function __construct(AuthEME10Service $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Mostrar formulario de verificación 2FA
     */
    public function show(Request $request)
    {
        if (!session()->has('two_factor_temp_token')) {
            return redirect()->route('login');
        }

        return view('auth.two-factor', [
            'email' => session('two_factor_email'),
            'sent_to' => session('sent_to'),
            'method' => session('method', 'email'),
        ]);
    }

    /**
     * Verificar código 2FA
     */
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $tempToken = session('two_factor_temp_token');

        if (!$tempToken) {
            return redirect()->route('login')->with('error', 'Sesión expirada. Por favor, inicia sesión nuevamente.');
        }

        // Verificar código con Auth EME10
        $result = $this->authService->verifyTwoFactor($tempToken, $request->code);

        if (!$result['success']) {
            throw ValidationException::withMessages([
                'code' => $result['message'] ?? 'Código inválido',
            ]);
        }

        // Buscar o crear usuario local
        $user = $this->findOrCreateLocalUser($result['user'], $result['token']);

        // Autenticar usuario localmente
        Auth::login($user);
        $request->session()->regenerate();

        // Limpiar datos de 2FA de la sesión
        session()->forget(['two_factor_temp_token', 'two_factor_email']);

        // Crear sesión en Auth EME10
        $this->authService->createAppSession($result['token']);

        // Redirigir según el rol del usuario
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('creator.select-website');
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

