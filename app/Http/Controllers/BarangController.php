<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangs = Barang::with('kategori')->get();
        return view('admin.barang.index', compact('barangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.barang.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|min:5|max:80',
            'harga' => 'required|integer',
            'jumlah' => 'required|integer',
            'kategori_id' => 'required|exists:kategoris,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto_barang', 'public');
            $validated['foto'] = $fotoPath;
        }
    
        \App\Models\Barang::create($validated);
    
        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $barang = \App\Models\Barang::findOrFail($id);
        $kategoris = \App\Models\Kategori::all();
        return view('admin.barang.edit', compact('barang', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $barang = \App\Models\Barang::findOrFail($id);

        $validated = $request->validate([
            'nama_barang' => 'required|string|min:5|max:80',
            'harga' => 'required|integer',
            'jumlah' => 'required|integer',
            'kategori_id' => 'required|exists:kategoris,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        // Cek jika upload foto baru
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto_barang', 'public');
            $validated['foto'] = $fotoPath;
        }
    
        $barang->update($validated);
    
        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barang = \App\Models\Barang::findOrFail($id);

        if ($barang->foto && \Storage::exists('public/' . $barang->foto)) {
            \Storage::delete('public/' . $barang->foto);
        }

        $barang->delete();

        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil dihapus!');
    }
}
