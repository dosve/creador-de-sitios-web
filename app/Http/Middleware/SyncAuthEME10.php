<?php

namespace App\Http\Middleware;

use App\Services\AuthEME10Service;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SyncAuthEME10
{
    protected AuthEME10Service $authService;

    public function __construct(AuthEME10Service $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Si no hay usuario autenticado, continuar
        if (!$user) {
            return $next($request);
        }

        // Si el usuario no está sincronizado con Auth EME10, continuar
        // (usuarios antiguos o creados manualmente)
        if (!$user->isSyncedWithAuthEME10()) {
            return $next($request);
        }

        // Si no necesita sincronización, continuar
        if (!$user->needsSync()) {
            return $next($request);
        }

        // Intentar sincronizar con Auth EME10
        $token = $user->getAuthEME10Token();
        $result = $this->authService->getUser($token);

        if ($result['success']) {
            // Actualizar datos del usuario
            $user->syncFromAuthEME10($result['user']);
        } else {
            // Token inválido o expirado - pero solo cerrar sesión si es crítico
            // Por ahora, solo loguear el error pero no cerrar la sesión
            \Log::warning('Auth EME10 sync failed for user: ' . $user->id, ['error' => $result['error'] ?? 'Unknown error']);
            
            // Solo cerrar sesión si el error es crítico (token completamente inválido)
            if (isset($result['error']) && str_contains($result['error'], 'invalid_token')) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->with('error', 'Tu sesión ha expirado. Por favor, inicia sesión nuevamente.');
            }
        }

        return $next($request);
    }
}

