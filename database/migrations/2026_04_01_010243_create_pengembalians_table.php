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
            $table->string('peminjam');
            $table->date('tanggal_pengembalian');
            $table->enum('status_pengembalian', ['dibuat', 'diproses', 'selesai'])->default('dibuat');
            $table->enum('jenis_pelanggaran', ['keterlambatan', 'kerusakan', 'hilang'])->default('keterlambatan');  
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
