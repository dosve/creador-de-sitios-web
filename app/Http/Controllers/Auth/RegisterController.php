<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthEME10Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    protected AuthEME10Service $authService;

    public function __construct(AuthEME10Service $authService)
    {
        $this->authService = $authService;
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:20',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Verificar que el email no esté en uso localmente
        if (User::where('email', $request->email)->exists()) {
            throw ValidationException::withMessages([
                'email' => 'Este correo electrónico ya está registrado.',
            ]);
        }

        // Registrar en Auth EME10
        $result = $this->authService->register([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
        ]);

        if (!$result['success']) {
            // Manejar errores de validación de EME10
            if (isset($result['errors']) && is_array($result['errors'])) {
                throw ValidationException::withMessages($result['errors']);
            }

            throw ValidationException::withMessages([
                'email' => $result['message'] ?? 'Error al registrar el usuario',
            ]);
        }

        // Crear usuario local con datos de Auth EME10
        $user = User::create([
            'auth_eme10_id' => $result['user']['id'],
            'name' => $result['user']['name'],
            'email' => $result['user']['email'],
            'phone' => $result['user']['phone'] ?? null,
            'avatar' => $result['user']['avatar'] ?? null,
            'password' => bcrypt(uniqid()), // Password dummy ya que Auth EME10 maneja la auth
            'role' => 'creator', // Por defecto todos los registros son creadores
            'plan_id' => 1, // Plan gratuito por defecto
            'is_active' => true,
            'auth_eme10_token' => $result['token'],
            'two_factor_enabled' => $result['user']['two_factor_enabled'] ?? false,
            'last_auth_sync' => now(),
        ]);

        // Autenticar usuario localmente
        Auth::login($user);

        // Crear sesión en Auth EME10
        $this->authService->createAppSession($result['token']);

        return redirect()->route('creator.select-website')->with('success', '¡Cuenta creada exitosamente!');
    }
}

