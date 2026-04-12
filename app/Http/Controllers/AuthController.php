<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
 // --- LOGIN ANGGOTA (FRONTEND) ---
    public function showLoginAnggota() {
        return view('pages.frontend.auth.login');
    }

    public function loginAnggota(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('anggota')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors(['email' => 'Email atau Password salah.']);
    }

    // --- LOGIN ADMIN/PETUGAS ---
    public function showLoginAdmin() {
        return view('pages.admin.auth.login');
    }

    public function loginAdmin(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors(['email' => 'Akses ditolak. Silahkan cek kredensial Anda.']);
    }

    // --- LOGOUT ---
    public function logout(Request $request) {
        // Cek guard mana yang aktif, lalu logout
        if (Auth::guard('anggota')->check()) {
            Auth::guard('anggota')->logout();
        } elseif (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

}
