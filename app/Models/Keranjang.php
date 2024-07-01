<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjangs';

    protected $fillable = [
        'user_id',
        'penjualan_id',
        'product_id',
        'qty',
        'harga',
        'panjang',
        'lebar',
        'total',
        'desain'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class,'penjualan_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
