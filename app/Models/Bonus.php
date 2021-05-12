<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    use HasFactory;
    protected $table = "bonus";

    // nama_bonus	deskripsi_bonus	jumlah	id_pemberi	id_penerima	created_at	updated_at
    protected $fillable=[
        "nama_bonus",
        "deskripsi_bonus",
        "jumlah",
        "id_pemberi",
        "id_penerima",
        "created_at",
        "updated_at",
    ];

    protected $appends = ['pemberi', 'penerima'];

    function getPemberiAttribute()
    {
        return Pegawai::find($this->id_pemberi);
    }
    function getPenerimaAttribute()
    {
        return Pegawai::find($this->id_penerima);
    }
}
