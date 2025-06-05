<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang', 
        'gambar', 
        'harga', 
        'stok'
    ];

    protected $casts = [
        'harga' => 'integer',
        'stok' => 'integer',
    ];
}
