<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('admin.login');
        }

        $user = Auth::guard('web')->user();

        // JIKA KEPALA, IZINKAN AKSES KE MANA SAJA (Super Admin)
        if ($user->role === 'kepala') {
            return $next($request);
        }

        // JIKA BUKAN KEPALA, CEK APAKAH ROLE USER ADA DI DAFTAR AKSES
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        return redirect()->route('admin.dashboard')->with('error', 'Akses dibatasi hanya untuk Kepala Perpustakaan.');
    }
}
