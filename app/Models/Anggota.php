<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'angotas';
    protected $guarded = [];
    protected $hidden = ['password', 'remember_token'];
}
