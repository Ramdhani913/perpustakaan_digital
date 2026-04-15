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
     Schema::create('pengembalians', function (Blueprint $table) {
    $table->id();
    $table->foreignId('peminjaman_id')->constrained('peminjamans')->onDelete('cascade');
    $table->date('tanggal_pengembalian');
    // Tambahkan status_pengembalian untuk alur antrean
    $table->enum('status_pengembalian', ['diajukan', 'selesai'])->default('diajukan');
    $table->enum('jenis_pelanggaran', ['tidak_ada', 'kerusakan', 'hilang'])->default('tidak_ada');
    $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};
