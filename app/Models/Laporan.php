<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $guarded = [];

public function peminjaman() {
    return $this->belongsTo(Peminjaman::class);
}

public function pengembalian() {
    return $this->belongsTo(Pengembalian::class);
}
}
