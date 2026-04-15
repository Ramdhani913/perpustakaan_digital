<?php

namespace App\Models;

// Perhatikan: Kita mengimpor Authenticatable dari Foundation, bukan Middleware
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Anggota extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'anggotas';
    
    // Karena Anda menggunakan guarded, pastikan tidak ada properti $fillable di file ini
    protected $guarded = [];

    protected $hidden = [
        'password', 
        'remember_token',
    ];

    // Menghindari error saat login karena password belum di-hash otomatis
    protected $casts = [
        'password' => 'hashed',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'anggota_id');
    }
}