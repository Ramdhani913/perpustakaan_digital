<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        return view('pages.frontend.home.detail', compact('buku'));
    }

}
