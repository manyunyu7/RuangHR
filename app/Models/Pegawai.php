<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $table = "pegawai";

    protected $fillable = [
        "id",
        "nama_depan",
        "nama_belakang",
        "email",
        "no_hp",
        "gender",
        "alamat",
        "photo_path",
        "tanggal_masuk",
        "tanggal_lahir",
        "id_pekerjaan",
        "id_divisi",
        "created_at",
        "updated_at",
    ];

    protected $appends = ['divisi', 'pekerjaan'];

    function getDivisiAttribute()
    {
        return Divisi::find($this->id_divisi);
    }
    function getPekerjaanAttribute()
    {
        return Pekerjaan::find($this->id_pekerjaan);
    }

}
