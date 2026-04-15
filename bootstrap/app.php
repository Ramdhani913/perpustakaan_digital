<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
    
    $middleware->alias([
        'role' => \App\Http\Middleware\CheckRole::class,
    ]);

    $middleware->redirectTo(
        // Jika belum login, dilempar ke sini
        guests: function (Request $request) {
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login');
            }
            return route('login');
        },
        // JIKA SUDAH LOGIN (Ini yang kurang!), dilempar ke sini
        users: function () {
            if (Auth::guard('web')->check()) {
                return route('buku.index'); // Admin ke dashboard
            }
            if (Auth::guard('anggota')->check()) {
                return '/'; // Anggota ke frontend
            }
            return '/';
        }
    );
})
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();