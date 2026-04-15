<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnggotaController extends Controller
{
   public function index(Request $request)
    {
        $search = $request->get('search');

        $anggota = Anggota::when($search, function ($query) use ($search) {
            return $query->where('nama', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('alamat', 'like', "%{$search}%");
        })
        ->latest()
        ->get();

        return view('pages.backend.anggota.index', compact('anggota'));
    }

    public function create()
    {
        return view('pages.backend.anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required',
            'email'         => 'required|email|unique:anggotas,email',
            'password'      => 'required|min:6',
            'alamat'        => 'required',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'tgl_lahir'     => 'required|date',
            'status'        => 'nullable|in:aktif,nonaktif',
            'image'         => 'nullable|image|max:2048',
            'buku_dipinjam' => 'nullable',
            
        ]);

        // Logika simpan foto menggunakan Storage ke disk public
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('anggota', 'public');
        }

        Anggota::create([
            'nama'          => $request->nama,
            'email'         => $request->email,
            'password'      => bcrypt($request->password),
            'alamat'        => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tgl_lahir'     => $request->tgl_lahir,
            'status'        => $request->status ?? 'aktif',
            'image'         => $imagePath,
            'buku_dipinjam' => $request->buku_dipinjam ?? 0,
        ]);

        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function show($id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('pages.backend.anggota.show', compact('anggota'));
    }

    public function edit($id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('pages.backend.anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'          => 'required',
            'email'         => 'required|email|unique:anggotas,email,' . $id,
            'password'      => 'nullable|min:6',
            'alamat'        => 'required',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'tgl_lahir'     => 'required|date',
            'status'        => 'required|in:aktif,nonaktif',
            'image'         => 'nullable|image|max:2048',
        ]);

        $anggota = Anggota::findOrFail($id);
        $data = $request->except(['image', 'password']);

        // Logika Update Password (hanya jika diisi)
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        // Logika Simpan Foto menggunakan Storage Facade
        if ($request->hasFile('image')) {
            // 1. Hapus gambar lama jika ada di storage
            if ($anggota->image && Storage::disk('public')->exists($anggota->image)) {
                Storage::disk('public')->delete($anggota->image);
            }

            // 2. Upload gambar baru ke folder 'anggota'
            $data['image'] = $request->file('image')->store('anggota', 'public');
        }

        $anggota->update($data);

        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);

        // Hapus file fisik dari storage disk public
        if ($anggota->image && Storage::disk('public')->exists($anggota->image)) {
            Storage::disk('public')->delete($anggota->image);
        }

        $anggota->delete();

        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil dihapus.');
    }
}