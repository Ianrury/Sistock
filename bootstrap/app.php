<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Daftarkan semua middleware alias
        $middleware->alias([
            'isSuperAdmin' => \App\Http\Middleware\Issuperadmin::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'guest.custom' => \App\Http\Middleware\RedirectIfAuthenticatedCustom::class,
            'auth.custom' => \App\Http\Middleware\EnsureUserIsAuthenticated::class,
            'auth.superadmin' => \App\Http\Middleware\SuperAdminAuth::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();