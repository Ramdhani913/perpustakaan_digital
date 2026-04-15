<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Anggota;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    // --- AREA ANGGOTA ---
    public function showLoginAnggota()
    {
        return view('pages.frontend.auth.login');
    }

   public function loginAnggota(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    // Tambahkan kondisi status aktif langsung di sini
    $credentials = [
        'email' => $request->email,
        'password' => $request->password,
        'status' => 'aktif' // Hanya izinkan jika statusnya aktif
    ];

    if (Auth::guard('anggota')->attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/');
    }

    // Jika gagal, cek apakah karena email/password salah ATAU karena akun nonaktif
    $user = \App\Models\Anggota::where('email', $request->email)->first();
    if ($user && $user->status !== 'aktif') {
        return back()->withErrors(['email' => 'Akun Anda telah dinonaktifkan. Silakan hubungi petugas.']);
    }

    return back()->withErrors(['email' => 'Email atau Password anggota salah.']);
}

    // --- AREA ADMIN (Petugas/Kepala) ---
public function showLoginAdmin()
{
    return view('pages.backend.auth.login');
}


   public function loginAdmin(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $credentials = [
        'email' => $request->email,
        'password' => $request->password,
        'status' => 'aktif' 
    ];

    if (Auth::guard('web')->attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended(route('buku.index')); // Gunakan route() agar lebih aman
    }

    $user = \App\Models\User::where('email', $request->email)->first();
    if ($user && $user->status !== 'aktif') {
        return back()->withErrors(['email' => 'Akses ditolak. Status akun admin Anda tidak aktif.']);
    }

    return back()->withErrors(['email' => 'Email atau Password admin salah.']);
}

    public function logout(Request $request)
    {
        $isAdmin = Auth::guard('web')->check();

        Auth::guard('web')->logout();
        Auth::guard('anggota')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        //redirect berdasarkan tipe akun. jika dmin maka akan reirect ke form login admin, jika anggota maka akan redirect ke form login anggota
        return $isAdmin ? redirect()->route('admin.login') : redirect('/');
    }
 
// ... di dalam class AuthController

    public function showRegisterAnggota()
    {
        return view('pages.frontend.auth.register');
    }

   public function registerAnggota(Request $request)
{
    // 1. Validasi
    $request->validate([
        'nama'          => 'required|string|max:255',
        'email'         => 'required|email|unique:anggotas,email',
        'password'      => 'required|min:6|confirmed',
        'alamat'        => 'required',
        'jenis_kelamin' => 'required|in:laki-laki,perempuan',
        'tgl_lahir'     => 'required|date',
        'image'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // 2. Handle Upload Gambar
    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('anggota', 'public');
    }

    // 3. Simpan ke Database
    Anggota::create([
        'nama'          => $request->nama,
        'email'         => $request->email,
        'password'      => Hash::make($request->password),
        'alamat'        => $request->alamat,
        'jenis_kelamin' => $request->jenis_kelamin,
        'tgl_lahir'     => $request->tgl_lahir,
        'status'        => 'aktif',
        'image'         => $imagePath,
        'buku_dipinjam' => 0,
    ]);

    return redirect()->route('login')->with('success', 'Registrasi berhasil! Silahkan login.');
}

// Tambahkan di App\Http\Controllers\AuthController

public function profil()
{
    // Mengambil data anggota yang sedang login
    $anggota = Auth::guard('anggota')->user();

    // Mengambil riwayat peminjaman anggota tersebut (asumsi Anda punya model Peminjaman)
    // Gunakan eager loading 'buku' agar query efisien
    $peminjamans = \App\Models\Peminjaman::with('buku')
                    ->where('anggota_id', $anggota->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

    return view('pages.frontend.home.profile', compact('anggota', 'peminjamans'));
}
}

