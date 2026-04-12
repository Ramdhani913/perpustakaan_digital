<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Halaman Katalog Utama (Home)
Route::get('/', [FrontendController::class, 'index'])->name('frontend.index');

// Halaman Detail Buku
// {id} adalah parameter dinamis yang akan dikirim ke fungsi show($id)
Route::get('/buku/{id}', [FrontendController::class, 'show'])->name('frontend.show');

Route::get('/dashboard', function () {
    return view('pages.backend.dashboard.index');
});

Route::resource('users', UserController::class);
Route::resource('anggota', AnggotaController::class);
Route::resource('buku', BukuController::class);

