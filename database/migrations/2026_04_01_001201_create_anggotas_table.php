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
        Schema::create('anggotas', function (Blueprint $table) {
            $table->id();   
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('image')->nullable();
            $table->text('alamat');
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->default('laki-laki');
            $table->integer('buku_dipinjam')->unsigned()->default(0);
            $table->date('tgl_lahir');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggotas');
    }
};
