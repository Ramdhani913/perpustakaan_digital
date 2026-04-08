<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('pages.backend.dashboard.index');
});

Route::resource('users', UserController::class);
Route::resource('anggota', AnggotaController::class);
Route::resource('buku', BukuController::class);

