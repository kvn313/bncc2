<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Faktur;
use App\Models\FakturItem;

class FakturController extends Controller
{
    public function index()
    {
        $keranjang = session('keranjang', []);
        return view('user.faktur.index', compact('keranjang'));
    }

    public function simpan(Request $request)
    {
        $keranjang = session('keranjang', []);
        if (empty($keranjang)) {
            return redirect()->route('user.katalog.index')->with('error', 'Faktur kosong');
        }

        $request->validate([
            'alamat' => 'required|string|min:10|max:100',
            'kode_pos' => 'required|digits:5',
        ]);

        $invoice = 'INV-' . strtoupper(Str::random(8));
        $total = 0;

        foreach ($keranjang as $item) {
            $total += $item['harga'] * $item['qty'];
        }

        $faktur = Faktur::create([
            'invoice' => $invoice,
            'alamat' => $request->alamat,
            'kode_pos' => $request->kode_pos,
            'total' => $total,
            'user_id' => auth()->id()
        ]);

        foreach ($keranjang as $id => $item) {
            FakturItem::create([
                'faktur_id' => $faktur->id,
                'nama_barang' => $item['nama'],
                'kategori' => $item['kategori'],
                'harga' => $item['harga'],
                'qty' => $item['qty'],
                'subtotal' => $item['harga'] * $item['qty'],
            ]);
        }

        session()->forget('keranjang');

        return redirect()->route('user.faktur.index')->with('success', 'Faktur berhasil dicetak!');
    }
}
