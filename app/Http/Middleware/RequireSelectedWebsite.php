<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireSelectedWebsite
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Rutas que no requieren sitio web seleccionado
        $excludedRoutes = [
            'creator.select-website',
            'creator.websites.create',
            'creator.websites.store',
            'creator.templates.index',
            'creator.templates.show',
            'creator.templates.preview',
        ];

        if (in_array($request->route()->getName(), $excludedRoutes)) {
            return $next($request);
        }

        // Si no hay sitio web seleccionado, redirigir a selección
        if (!session('selected_website_id')) {
            return redirect()->route('creator.select-website');
        }

        // Verificar que el sitio web seleccionado pertenece al usuario
        $website = \App\Models\Website::where('id', session('selected_website_id'))
            ->where('user_id', auth()->id())
            ->first();

        if (!$website) {
            session()->forget('selected_website_id');
            return redirect()->route('creator.select-website');
        }

        // Agregar el sitio web a la request para que esté disponible en todos los controladores
        $request->merge(['selected_website' => $website]);

        return $next($request);
    }
}
