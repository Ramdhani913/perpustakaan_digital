<?php

namespace Database\Seeders;

use App\Models\Anggota;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AnggotaSeeder extends Seeder
{
    public function run(): void
    {
        Anggota::create([
            'nama'          => 'asep karyono',
            'email'         => 'asep@gmail.com',
            'password'      => Hash::make('123456'),
            'alamat'        => 'Jl. Contoh No. 123',
            'jenis_kelamin' => 'laki-laki',
            'tgl_lahir'     => '2000-01-01',
            'status'        => 'aktif',
            'buku_dipinjam' => 0,
            // 'image' bisa dikosongkan dulu untuk seeder
        ]);
    }
}