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
    Schema::create('peminjamans', function (Blueprint $table) {
        $table->id();
        // Relasi ke tabel anggotas (User yang login di frontend)
        $table->foreignId('anggota_id')->constrained('anggotas')->onDelete('cascade');
        // Relasi ke tabel bukus
        $table->foreignId('buku_id')->constrained('bukus')->onDelete('cascade');
        
        $table->date('tanggal_peminjaman')->nullable(); // Null saat status 'dibuat'
        $table->date('tenggat_waktu')->nullable();      // Null saat status 'dibuat'
        $table->enum('status_peminjaman', ['diajukan', 'dipinjam', 'selesai'])->default('diajukan');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
