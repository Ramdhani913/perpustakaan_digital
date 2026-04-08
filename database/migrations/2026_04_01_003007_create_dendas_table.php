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
        Schema::create('dendas', function (Blueprint $table) {
            $table->id();
            $table->integer('jumlah_hari')->unsigned();
            $table->double('total_denda')->unsigned();
            $table->enum('status', ['unpaid', 'paid'])->default('unpaid');
            $table->double('total_bayar')->unsigned();
            $table->double('total_kembali')->unsigned();
            $table->enum('tipe_denda', ['keterlambatan', 'kerusakan', 'hilang'])->default('keterlambatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dendas');
    }
};
