<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'require.selected.website' => \App\Http\Middleware\RequireSelectedWebsite::class,
            'sync.auth.eme10' => \App\Http\Middleware\SyncAuthEME10::class,
            'prevent.back' => \App\Http\Middleware\PreventBackHistory::class,
        ]);
        
        // Agregar middleware global para sincronización con Auth EME10
        // TEMPORALMENTE DESHABILITADO - Causa errores 404 en auth.eme10.com
        // $middleware->web(append: [
        //     \App\Http\Middleware\SyncAuthEME10::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
