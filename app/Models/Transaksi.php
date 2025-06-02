<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',         // <-- TAMBAHKAN INI!
        'nama_penyewa',
        'nama_barang',
        'barang_id',
        'jumlah_sewa',
        'durasi_sewa',
        'total_harga',
        'status'
        // pastikan semua kolom yang ingin Anda isi melalui create() atau update() ada di sini
    ];
}