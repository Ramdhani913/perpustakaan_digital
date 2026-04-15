<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $guarded = [];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'buku_id');
    }

    public function laporan() {
        return $this->hasOne(Laporan::class);
    }
}
