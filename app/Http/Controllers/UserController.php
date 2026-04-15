<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Gunakan Storage agar konsisten

class UserController extends Controller
{
    public function index(Request $request)
{
    $search = $request->get('search');

    $users = User::when($search, function ($query) use ($search) {
        return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%");
        })
    
    ->latest() // Mengurutkan dari yang terbaru
    ->get();

    return view('pages.backend.users.index', compact('users'));
}

    public function create()
    {
        return view('pages.backend.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'image' => 'nullable|image|max:2048',
            'role' => 'required|in:petugas,kepala',
            'status' => 'nullable|in:aktif,nonaktif',
            'tgl_lahir' => 'required|date',
            'no_hp' => 'required',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
        ]);

        // Logika simpan foto menggunakan Storage (mirip BukuController)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('users', 'public');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Password di-bcrypt
            'role' => $request->role,
            'status' => $request->status ?? 'aktif',
            'tgl_lahir' => $request->tgl_lahir,
            'no_hp' => $request->no_hp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'image' => $imagePath,
        ]);

            return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('pages.backend.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.backend.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'image' => 'nullable|image|max:2048',
            'role' => 'required|in:petugas,kepala',
            'status' => 'required|in:aktif,nonaktif',
            'tgl_lahir' => 'required|date',
            'no_hp' => 'required',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
        ]);

        $data = $request->except(['image', 'password']);

        // Logika Update Password (hanya jika diisi)
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        // Logika Simpan Foto (Mirip BukuController)
        if ($request->hasFile('image')) {
            // 1. Hapus gambar lama jika ada
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }

            // 2. Upload gambar baru ke folder 'users'
            $data['image'] = $request->file('image')->store('users', 'public');
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Hapus file fisik menggunakan Storage Facade
        if ($user->image && Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}