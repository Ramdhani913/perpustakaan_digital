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
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            
            // Relasi utama
            $table->foreignId('peminjaman_id')->constrained('peminjamans')->onDelete('cascade');
            $table->foreignId('pengembalian_id')->nullable()->constrained('pengembalians')->onDelete('cascade');
            
            // Data Keuangan denda
            $table->double('total_denda')->default(0);  // Nominal yang seharusnya dibayar
            $table->double('denda_dibayar')->default(0); // Nominal yang sudah dibayar oleh anggota
            
            // Status Keterlambatan & Pengembalian
            $table->enum('status_keterlambatan', ['tepat_waktu', 'terlambat'])->default('tepat_waktu');
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};