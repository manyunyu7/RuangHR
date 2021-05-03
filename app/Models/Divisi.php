<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;
    protected $table = "divisi";

    protected $fillable = [
        "nama_divisi",
        "lead_divisi",
        "co_lead_divisi",
        "email_divisi",
        "alamat_divisi",
        "kontak_divisi",
    ];

 
}
