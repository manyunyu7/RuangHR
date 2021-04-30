<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;
    protected $table = "api_token";

    protected $fillable = [
        "name",
        "token",
        "access_type",
        "created_at",
        "updated_at",
    ];

}
