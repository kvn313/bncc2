<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Faktur;
use App\Models\FakturDetail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    // === LOGIN & REGISTER ===

    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|ends_with:@gmail.com',
            'password' => 'required|min:6|max:12',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            if ($user->role == 'admin') {
                return redirect()->route('admin.barang.index');
            } else {
                return redirect()->route('user.katalog');
            }
        }

        return redirect()->back()->with('error', 'Email atau password salah.');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|min:3|max:40',
            'email' => 'required|email|ends_with:@gmail.com|unique:users,email',
            'password' => 'required|min:6|max:12|confirmed',
            'nomor_handphone' => 'required|regex:/^08[0-9]{8,13}$/',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nomor_handphone' => $request->nomor_handphone,
            'role' => 'user',
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    // === KATALOG DAN KERANJANG ===

    public function katalog()
    {
        $barangs = Barang::with('kategori')->get();
        return view('user.katalog', compact('barangs'));
    }

    public function tambahKeKeranjang($id)
    {
        $barang = Barang::findOrFail($id);

        if ($barang->jumlah <= 0) {
            return redirect()->back()->with('error', 'Barang sudah habis, silakan tunggu restock.');
        }

        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$id])) {
            $keranjang[$id]['kuantitas']++;
        } else {
            $keranjang[$id] = [
                'id' => $barang->id,
                'nama' => $barang->nama,
                'kategori' => $barang->kategori->nama,
                'harga' => $barang->harga,
                'kuantitas' => 1
            ];
        }

        session()->put('keranjang', $keranjang);

        return redirect()->back()->with('success', 'Barang berhasil dimasukkan ke keranjang.');
    }

    public function keranjang()
    {
        $keranjang = session()->get('keranjang', []);
        return view('user.keranjang', compact('keranjang'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'alamat' => 'required|string|min:10|max:100',
            'kode_pos' => 'required|digits:5',
        ]);

        $keranjang = session()->get('keranjang', []);
        if (empty($keranjang)) {
            return redirect()->back()->with('error', 'Keranjang kamu kosong.');
        }

        $nomor_invoice = 'INV-' . strtoupper(Str::random(8));
        $total_harga = 0;

        foreach ($keranjang as $item) {
            $total_harga += $item['harga'] * $item['kuantitas'];
        }

        $faktur = Faktur::create([
            'user_id' => Auth::id(),
            'nomor_invoice' => $nomor_invoice,
            'alamat' => $request->alamat,
            'kode_pos' => $request->kode_pos,
            'total_harga' => $total_harga,
        ]);

        foreach ($keranjang as $item) {
            FakturDetail::create([
                'faktur_id' => $faktur->id,
                'nama_barang' => $item['nama'],
                'kategori_barang' => $item['kategori'],
                'kuantitas' => $item['kuantitas'],
                'subtotal' => $item['harga'] * $item['kuantitas'],
            ]);

            // Kurangi stok barang
            $barang = Barang::find($item['id']);
            if ($barang) {
                $barang->jumlah -= $item['kuantitas'];
                $barang->save();
            }
        }

        session()->forget('keranjang');

        return redirect()->route('user.invoice', $faktur->id)->with('success', 'Checkout berhasil!');
    }

    public function invoice($id)
    {
        $faktur = Faktur::with('detail')->findOrFail($id);
        return view('user.invoice', compact('faktur'));
    }
}
