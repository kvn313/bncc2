<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakturDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'faktur_id',
        'barang_id',
        'nama_barang',
        'kategori_barang',
        'kuantitas',
        'subtotal',
    ];

    public function faktur()
    {
        return $this->belongsTo(Faktur::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
