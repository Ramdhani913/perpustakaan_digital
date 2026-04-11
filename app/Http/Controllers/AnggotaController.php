<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{

    public function index()
    {
        $anggota = Anggota::all();
        return view('anggota.index', compact('anggota'));
    }

    public function create()
    {
        return view('anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:anggota,email',
            'password' => 'required|min:6',
            'alamat' => 'required',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'tgl_lahir' => 'required|date',
            'status' => 'required|in:aktif,nonaktif',
            'image' => 'nullable|image|max:2048',
        ]);

        $anggota = new Anggota();
        $anggota->nama = $request->nama;
        $anggota->email = $request->email;
        $anggota->password = bcrypt($request->password);
        $anggota->alamat = $request->alamat;
        $anggota->jenis_kelamin = $request->jenis_kelamin;
        $anggota->tgl_lahir = $request->tgl_lahir;
        $anggota->status = $request->status;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = public_path('/images/' . $filename);
            file_put_contents($filePath, file_get_contents($file));
            $anggota->image = '/images/' . $filename;
        }

        $anggota->save();

        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function show($id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('anggota.show', compact('anggota'));
    }

    public function edit($id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:anggota,email,' . $id,
            'password' => 'nullable|min:6',
            'alamat' => 'required',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'tgl_lahir' => 'required|date',
            'status' => 'required|in:aktif,nonaktif',
            'image' => 'nullable|image|max:2048',
        ]);

        $anggota = Anggota::findOrFail($id);
        $anggota->nama = $request->nama;
        $anggota->email = $request->email;
        if ($request->filled('password')) {
            $anggota->password = bcrypt($request->password);
        }
        $anggota->alamat = $request->alamat;
        $anggota->jenis_kelamin = $request->jenis_kelamin;
        $anggota->tgl_lahir = $request->tgl_lahir;
        $anggota->status = $request->status;

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($anggota->image) {
                unlink(public_path($anggota->image));
            }
            // Simpan gambar baru
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = public_path('/images/' . $filename);
            file_put_contents($filePath, file_get_contents($file));
            $anggota->image = '/images/' . $filename;
        }

        $anggota->save();

        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);
        if ($anggota->image) {
            unlink(public_path($anggota->image));
        }
        $anggota->delete();

        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil dihapus.');
    }

}
