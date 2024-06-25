<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'nama',
        'gambar',
        'deskripsi',
        'isi',
        'harga',
        'harga_ukuran',
    ];

    protected $casts = [
        'harga_ukuran' => 'boolean'
    ];
}
