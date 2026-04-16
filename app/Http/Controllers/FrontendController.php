<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
   public function index()
{
    // Mengambil semua buku dan dikelompokkan berdasarkan kolom 'kategori'
    $bukus = Buku::all()->groupBy('kategori');
    return view('pages.frontend.home.index', compact('bukus'));
}

     public function show($id)
{
    $buku = Buku::findOrFail($id);
    $anggotaId = Auth::guard('anggota')->id();

    // Cek apakah anggota sedang meminjam atau mengajukan buku ini
    $borrowed = Peminjaman::where('anggota_id', $anggotaId)
        ->where('buku_id', $id)
        ->whereIn('status_peminjaman', ['diajukan', 'dipinjam'])
        ->exists();

    return view('pages.frontend.home.detail', compact('buku', 'borrowed'));
}

    public function search(Request $request)
{
    $keyword = $request->get('keyword');
          
    // Cari buku berdasarkan judul atau pengarang
    $results = Buku::where('judul', 'like', "%{$keyword}%")
                    ->orWhere('pengarang', 'like', "%{$keyword}%")
                    ->latest()
                    ->get();

    return view('pages.frontend.home.search_results', compact('results', 'keyword'));
}

}


