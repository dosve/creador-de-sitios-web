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

        \Log::info('Intento de login', ['email' => $request->email]);

        // Verificar si el usuario existe
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            \Log::warning('Usuario no encontrado', ['email' => $request->email]);
            throw ValidationException::withMessages([
                'email' => 'Usuario no encontrado. ¿Ejecutaste el seeder?',
            ]);
        }

        \Log::info('Usuario encontrado', ['email' => $user->email, 'role' => $user->role]);

        // Intentar login local primero
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            \Log::info('Login exitoso', ['user_id' => $user->id, 'role' => $user->role]);

            // Si el usuario está sincronizado con Auth EME10, intentar actualizar token
            if ($user->isSyncedWithAuthEME10()) {
                try {
                    $result = $this->authService->login($request->email, $request->password);
                    if ($result['success'] && !$result['requires_two_factor']) {
                        $user->updateAuthEME10Token($result['token']);
                        $this->authService->createAppSession($result['token']);
                    }
                } catch (\Exception $e) {
                    // Si falla Auth EME10, continuar con login local
                    \Log::warning('Auth EME10 sync failed during login', ['error' => $e->getMessage()]);
                }
            }

            // Redirigir según el rol del usuario
            if ($user->isAdmin()) {
                \Log::info('Redirigiendo a admin dashboard');
                return redirect()->route('admin.dashboard');
            }

            \Log::info('Redirigiendo a creator select-website');
            return redirect()->route('creator.select-website');
        }

        // Si falla login local, lanzar error
        \Log::error('Credenciales incorrectas', ['email' => $request->email]);
        throw ValidationException::withMessages([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ]);
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
