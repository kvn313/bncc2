<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faktur extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nomor_invoice',
        'alamat',
        'kode_pos',
        'total_harga',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detail()
    {
        return $this->hasMany(FakturDetail::class);
    }
}
