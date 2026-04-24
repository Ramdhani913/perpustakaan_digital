<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    $totalBuku = Buku::count();
    $totalAnggota = Anggota::count();
    $totalPeminjaman = Peminjaman::count();
    
    // Ambil 5 peminjaman terbaru dengan relasinya
    $peminjamanTerbaru = Peminjaman::with(['anggota', 'buku'])
                        ->latest()
                        ->take(5)
                        ->get();

    return view('pages.backend.dashboard.index', compact(
        'totalBuku', 
        'totalAnggota', 
        'totalPeminjaman', 
        'peminjamanTerbaru'
    ));
}
}
