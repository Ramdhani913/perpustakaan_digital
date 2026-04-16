<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// --- GUEST ROUTES ---
Route::get('/login', [AuthController::class, 'showLoginAnggota'])->name('login')->middleware('guest:anggota');
Route::post('/login', [AuthController::class, 'loginAnggota']);
Route::get('/register', [AuthController::class, 'showRegisterAnggota'])->name('register')->middleware('guest:anggota');
Route::post('/register', [AuthController::class, 'registerAnggota']);

Route::get('/admin/login', [AuthController::class, 'showLoginAdmin'])->name('admin.login')->middleware('guest:web');
Route::post('/admin/login', [AuthController::class, 'loginAdmin']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- ANGGOTA ROUTES (Frontend) ---
Route::middleware(['auth:anggota'])->group(function () {
    Route::get('/profil', [AuthController::class, 'profil'])->name('anggota.profil');
    Route::get('/', [FrontendController::class, 'index'])->name('frontend.index');
    Route::get('/buku-detail/{id}', [FrontendController::class, 'show'])->name('frontend.show');
    
    // Alur Pinjam & Lapor Kembali
    Route::post('/pinjam-buku/{id}', [PeminjamanController::class, 'ajukanPinjam'])->name('pinjam.ajukan');
    Route::post('/pengembalian/ajukan/{id}', [PengembalianController::class, 'ajukan'])->name('pengembalian.ajukan');
    });

    Route::get('/search', [FrontendController::class, 'search'])->name('frontend.search');
    
      Route::get('/pengembalian/cetak/{id}', [PengembalianController::class, 'cetakStruk'])->name('cetak.struk');
// --- ADMIN/PETUGAS ROUTES (Backend) ---
    Route::middleware(['auth:web'])->prefix('admin')->group(function () {
        
        // Dashboard
        Route::get('/dashboard', function () {
            return view('pages.backend.dashboard.index');
        })->name('admin.dashboard');

        // Master Data
        Route::resource('buku', BukuController::class);
        Route::resource('anggota', AnggotaController::class);
        Route::resource('users', UserController::class); 

        // Alur Peminjaman
        Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('admin.peminjaman.index');
        Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
        Route::put('/peminjaman/{id}/konfirmasi', [PeminjamanController::class, 'konfirmasiPinjam'])->name('admin.peminjaman.konfirmasi');
        Route::delete('/peminjaman/{id}/tolak', [PeminjamanController::class, 'tolakPinjam'])->name('admin.peminjaman.tolak');

        // Route untuk melihat detail
        Route::get('/admin/pengembalian/{id}', [PengembalianController::class, 'show'])->name('pengembalian.show');

        // Route untuk proses bayar
        Route::put('/admin/denda/bayar/{id}', [PengembalianController::class, 'bayarDenda'])->name('denda.bayar');
        // --- ALUR PENGEMBALIAN (Sinkron) ---
        Route::prefix('pengembalian')->name('pengembalian.')->group(function() {
        // Menampilkan antrean yang baru dilaporkan anggota
        Route::get('/index', [PengembalianController::class, 'index'])->name('index'); 
        
        // Halaman cek fisik & denda
        Route::get('/konfirmasi/{id}', [PengembalianController::class, 'konfirmasi'])->name('konfirmasi');
        
        // Proses final simpan denda & update stok
        Route::post('/selesai/{id}', [PengembalianController::class, 'selesai'])->name('selesai');
        
        // // Riwayat pengembalian yang sudah sukses
        // Route::get('/riwayat', [PengembalianController::class, 'riwayat'])->name('index');
      
    });

    // Laporan 
    Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');
    Route::post('/laporan/filter', [LaporanController::class, 'filter'])->name('admin.laporan.filter');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');
  
    Route::middleware(['role:kepala'])->group(function () {
        // Route khusus kepala sekolah jika ada
    });
});