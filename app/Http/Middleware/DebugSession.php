<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DebugSession
{
    public function handle(Request $request, Closure $next): Response
    {
        // Solo para rutas del creador
        if (str_starts_with($request->path(), 'creator/')) {
            \Log::info('Debug Session - Path: ' . $request->path());
            \Log::info('Debug Session - User ID: ' . auth()->id());
            \Log::info('Debug Session - Selected Website ID: ' . session('selected_website_id'));
            \Log::info('Debug Session - All Session Data: ', session()->all());
        }

        return $next($request);
    }
}
