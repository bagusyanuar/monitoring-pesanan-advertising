<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualans';

    protected $fillable = [
//        'penjualan_id',
        'user_id',
        'tanggal',
        'no_penjualan',
        'total',
        'status'
    ];

    //status note
    // 0 menunggu pembayaran
    // 1 menunggu konfirmasi pembayaran
    // 2 pesanan di proses
    // 3 pesanan siap di ambil
    // 4 selesai
    // 5 pesanan di tolak

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

//    public function penjualan()
//    {
//        return $this->belongsTo(Penjualan::class, 'penjualan_id');
//    }

    public function pembayaran_status()
    {
        return $this->hasOne(Pembayaran::class, 'penjualan_id')->orderBy('created_at', 'DESC');
    }

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'penjualan_id');
    }
}
