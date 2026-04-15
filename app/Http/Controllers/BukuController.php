<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
      

   public function index(Request $request)
{
    // 1. Ambil input
    $search = $request->search;

    // 2. Query dasar
    $query = Buku::query();

    // 3. Jika ada input search, lakukan pencarian
    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('judul', 'like', "%{$search}%")
              ->orWhere('pengarang', 'like', "%{$search}%")
              ->orWhere('penerbit', 'like', "%{$search}%");
        });
    }

    // 4. Eksekusi
    $bukus = $query->latest()->get();

    return view('pages.backend.buku.index', compact('bukus'));
}
    public function create()
    {
        $buku = Buku::all();
        return view('pages.backend.buku.create', compact('buku'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|date',
            'pengarang' => 'required',
            'kategori' => 'required',
            'stok' => 'required|integer|min:1',
            'status' => 'nullable|in:tersedia,dipinjam',
            'deskripsi' => 'nullable',
            'kondisi' => 'nullable|in:layak,rusak',
            'gambar' => 'nullable|image|max:2048',
        ],
        ['stok.min' => 'Stok buku minimal harus 1 pcs.',
        ]);

      
        
         $gambar = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('buku', 'public');
            // hasil nya: "buku/namafile.jpg"
        }

        Buku::create([
            'judul' => $request->judul,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'pengarang' => $request->pengarang,
            'kategori' => $request->kategori,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambar, // simpan path gambar ke database
            'status' => $request->status ?? 'tersedia',
            'kondisi' => $request->kondisi ?? 'layak',
        ]);


        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show($id)
    {
        $buku = Buku::findOrFail($id);
        return view('pages.backend.buku.show', compact('buku'));
    }

    public function edit($id
    
    )
    {
        $buku = Buku::findOrFail($id);
        return view('pages.backend.buku.edit', compact('buku'));
    }

public function update(Request $request, Buku $buku)
{
    $request->validate([
        'judul' => 'required',
        'penerbit' => 'required',
        'tahun_terbit' => 'required|date',
        'pengarang' => 'required',
        'kategori' => 'required',
        'stok' => 'required|integer',
        'status' => 'nullable|in:tersedia,dipinjam',
        'deskripsi' => 'nullable',
        'kondisi' => 'nullable|in:layak,rusak',
        'gambar' => 'nullable|image|max:2048', // Pastikan nama di form adalah 'gambar'
    ]);

    // Ambil semua data kecuali gambar
    $data = $request->except('gambar');

    // LOGIKA SIMPAN FOTO (Sesuai permintaan Anda)
    if ($request->hasFile('gambar')) {

        // 1. HAPUS GAMBAR LAMA DARI STORAGE
        if ($buku->gambar && Storage::disk('public')->exists($buku->gambar)) {
            Storage::disk('public')->delete($buku->gambar);
        }

        // 2. UPLOAD BARU (Disimpan ke folder 'buku')
        $data['gambar'] = $request->file('gambar')->store('buku', 'public');
    }

    $buku->update($data);

    return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui.');
}

   public function destroy($id)
{
    $buku = Buku::findOrFail($id);

    // Gunakan Facades Storage agar konsisten dengan proses Upload
    if ($buku->gambar && Storage::disk('public')->exists($buku->gambar)) {
        Storage::disk('public')->delete($buku->gambar);
    }

    $buku->delete();

    return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
}
}
