<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FakturItem extends Model
{
    protected $fillable = ['faktur_id', 'nama_barang', 'kategori', 'harga', 'qty', 'subtotal'];

    public function faktur()
    {
        return $this->belongsTo(Faktur::class);
    }
}
