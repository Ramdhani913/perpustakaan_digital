<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Kepala Perpustakaan
        User::create([
            'name'          => 'Admin Utama (Kepala)',
            'email'         => 'kepala@gmail.com',
            'password'      => Hash::make('123456'),
            'role'          => 'kepala',
            'status'        => 'aktif',
            'tgl_lahir'     => '1985-05-20',
            'no_hp'         => '081234567890',
            'jenis_kelamin' => 'laki-laki',
            'image'         => null, // Bisa diisi path jika ada file default
        ]);

        // 2. Akun Petugas
        User::create([
            'name'          => 'Petugas Perpustakaan',
            'email'         => 'petugas@gmail.com',
            'password'      => Hash::make('123456'),
            'role'          => 'petugas',
            'status'        => 'aktif',
            'tgl_lahir'     => '1995-10-10',
            'no_hp'         => '089876543210',
            'jenis_kelamin' => 'perempuan',
            'image'         => null,
        ]);
    }
}