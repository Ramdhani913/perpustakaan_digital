<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
   
    protected $guarded = [];

    // Di Model Denda
    public function pengembalian() {
        return $this->belongsTo(Pengembalian::class, 'pengembalian_id');
    }



    public function laporan(){
        return $this->hasOne(Laporan::class);
    }


}
