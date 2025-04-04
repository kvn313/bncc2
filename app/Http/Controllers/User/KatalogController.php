<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index()
    {
        $barangs = Barang::with('kategori')->get();
        return view('user.katalog.index', compact('barangs'));
    }

    public function tambahKeFaktur($id)
    {
        $barang = Barang::findOrFail($id);

        // Ambil data keranjang dari session
        $keranjang = session()->get('keranjang', []);

        // Kalau sudah ada, tambahkan qty
        if (isset($keranjang[$id])) {
            $keranjang[$id]['qty']++;
        } else {
            // Kalau belum ada, tambahkan baru
            $keranjang[$id] = [
                'nama' => $barang->nama,
                'kategori' => $barang->kategori->nama,
                'harga' => $barang->harga,
                'qty' => 1
            ];
        }

        session()->put('keranjang', $keranjang);
        return redirect()->route('user.katalog.index')->with('success', 'Barang berhasil ditambahkan ke faktur!');
    }
}
