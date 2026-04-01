<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('penerbit');
            $table->date('tahun_terbit');
            $table->string('pengarang');
            $table->string('kategori');
            $table->integer('stok')->unsigned();
            $table->enum('status', ['tersedia', 'dipinjam'])->default('tersedia');
            $table->text('deskripsi')->nullable();
            $table->enum('kondisi', ['layak', 'rusak'])->default('layak');
            $table->string('gambar')->nullable();           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
