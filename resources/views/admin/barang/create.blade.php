@extends('layouts.app')

@section('content')
    <h1>Tambah Barang</h1>

    <form action="{{ route('admin.barang.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>Nama Barang:</label>
        <input type="text" name="nama_barang"><br>

        <label>Harga:</label>
        <input type="number" name="harga"><br>

        <label>Jumlah:</label>
        <input type="number" name="jumlah"><br>

        <label>Kategori:</label>
        <select name="kategori_id">
            @foreach ($kategoris as $kategori)
                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
            @endforeach
        </select><br>

        <label>Foto:</label>
        <input type="file" name="foto"><br>

        <button type="submit">Simpan</button>
    </form>
@endsection
