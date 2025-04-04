@extends('layouts.app')

@section('content')
    <h1>Tambah Kategori</h1>

    <form action="{{ route('admin.kategori.store') }}" method="POST">
        @csrf
        <label>Nama Kategori:</label>
        <input type="text" name="nama" required>
        <button type="submit">Simpan</button>
    </form>
@endsection
