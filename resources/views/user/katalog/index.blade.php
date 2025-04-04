@extends('layouts.app')

@section('content')
    <h1>Katalog Barang</h1>

    @foreach ($barangs as $barang)
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
            <img src="{{ asset('storage/' . $barang->foto) }}" width="100">
            <p><strong>{{ $barang->nama }}</strong></p>
            <p>Kategori: {{ $barang->kategori->nama }}</p>
            <p>Harga: Rp. {{ number_format($barang->harga) }}</p>
            <p>Jumlah: {{ $barang->jumlah }}</p>

            @if($barang->jumlah > 0)
                <a href="{{ route('user.katalog.tambah', $barang->id) }}">Tambah ke Faktur</a>
            @else
                <p style="color:red;">Barang sudah habis, silakan tunggu hingga restock.</p>
            @endif
        </div>
    @endforeach
@endsection
