<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayarans';

    protected $fillable = [
        'penjualan_id',
        'tanggal',
        'bank',
        'atas_nama',
        'bukti',
        'deskripsi',
        'status'
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class,'penjualan_id');
    }
}
