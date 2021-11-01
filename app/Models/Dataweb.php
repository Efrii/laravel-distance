<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dataweb extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'url',
        'url_img',
    ];

}
