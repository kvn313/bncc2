@extends('layouts.app')

@section('content')
    <h1>Edit Barang</h1>

    <form action="{{ route('admin.barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>Nama Barang:</label>
        <input type="text" name="nama_barang" value="{{ $barang->nama_barang }}"><br>

        <label>Harga:</label>
        <input type="number" name="harga" value="{{ $barang->harga }}"><br>

        <label>Jumlah:</label>
        <input type="number" name="jumlah" value="{{ $barang->jumlah }}"><br>

        <label>Kategori:</label>
        <select name="kategori_id">
            @foreach ($kategoris as $kategori)
                <option value="{{ $kategori->id }}" {{ $kategori->id == $barang->kategori_id ? 'selected' : '' }}>
                    {{ $kategori->nama }}
                </option>
            @endforeach
        </select><br>

        <label>Foto Baru (Opsional):</label>
        <input type="file" name="foto"><br>
        @if ($barang->foto)
            <p>Foto saat ini:</p>
            <img src="{{ asset('storage/' . $barang->foto) }}" width="120">
        @endif

        <button type="submit">Update</button>
    </form>
@endsection
