<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    
  
    protected $guarded = [];

    public function peminjaman() {
        return $this->belongsTo(Peminjaman::class);
    }

    public function denda() {
        return $this->hasOne(Denda::class,);
    }

    public function laporan() {
        return $this->hasOne(Denda::class);
    }
}
