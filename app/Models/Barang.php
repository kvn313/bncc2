<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    protected $fillable = [
        'nama_barang',
        'harga',
        'jumlah',
        'kategori_id',
        'foto',
    ];

    public function fakturDetails()
{
    return $this->hasMany(FakturDetail::class);
}

    
}
