<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faktur;
use App\Models\FakturDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FakturController extends Controller
{
    public function checkout(Request $request)
    {
        // Validasi input
        $request->validate([
            'alamat' => 'required|string|min:10|max:100',
            'kode_pos' => 'required|string|digits:5',
        ]);

        $keranjang = session('keranjang', []);

        if (empty($keranjang)) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        // Hitung total
        $total = 0;
        foreach ($keranjang as $item) {
            $total += $item['jumlah'] * $item['harga'];
        }

        // Generate nomor invoice
        $nomor_invoice = 'INV-' . strtoupper(Str::random(8));

        // Simpan faktur
        $faktur = Faktur::create([
            'user_id' => Auth::id(),
            'nomor_invoice' => $nomor_invoice,
            'alamat' => $request->alamat,
            'kode_pos' => $request->kode_pos,
            'total_harga' => $total,
        ]);

        // Simpan detail faktur
        foreach ($keranjang as $item) {
            FakturDetail::create([
                'faktur_id' => $faktur->id,
                'barang_id' => $item['id'],
                'nama_barang' => $item['nama'],
                'kategori_barang' => $item['kategori'],
                'kuantitas' => $item['jumlah'],
                'subtotal' => $item['jumlah'] * $item['harga'],
            ]);
        }

        // Hapus keranjang dari session
        session()->forget('keranjang');

        return redirect()->route('invoice', $faktur->id)->with('success', 'Checkout berhasil!');
    }

    public function invoice($id)
    {
        $faktur = Faktur::with('detail')->where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        return view('user.invoice', compact('faktur'));
    }
}
