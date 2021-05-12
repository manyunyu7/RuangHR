<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perizinan extends Model
{
    use HasFactory;
    protected $table = "perizinan";

    function pegawai()
    {
        return $this->belongsTo(Pegawai::class,'id_pegawai');
    }

}
