<?php

namespace Database\Seeders;

use App\Models\Buku;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */public function run(): void
{
    // 1. Matikan pengecekan foreign key
    Schema::disableForeignKeyConstraints();

    // 2. Kosongkan tabel
    DB::table('bukus')->truncate();

      Buku::create([
            'judul'        => 'Laskar Pelangi',
            'penerbit'     => 'Bentang Pustaka',
            'tahun_terbit' => '2005-01-01',
            'pengarang'    => 'Andrea Hirata',
            'kategori'     => 'novel',
            'stok'         => 1, // Permintaan: Stok 1
            'deskripsi'    => 'Sebuah novel luar biasa tentang persahabatan 10 anak di Belitung.',
            'gambar'       => null, // Diisi null karena gambar biasanya diupload manual
            'status'       => 'tersedia', // Permintaan: Tersedia
            'kondisi'      => 'layak', // Permintaan: Layak
        ]);

        Buku::create([
            'judul'        => 'Filosofi Teras',
            'penerbit'     => 'Kompas Gramedia',
            'tahun_terbit' => '2018-01-01',
            'pengarang'    => 'Henry Manampiring',
            'kategori'     => 'novel',
            'stok'         => 1,
            'deskripsi'    => 'Filsafat Yunani-Romawi Kuno untuk Mental Tangguh Masa Kini.',
            'gambar'       => null,
            'status'       => 'tersedia',
            'kondisi'      => 'layak',
        ]);  
    // 4. Hidupkan kembali pengecekan foreign key
    Schema::enableForeignKeyConstraints();
}
    
}