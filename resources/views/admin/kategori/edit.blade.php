@extends('layouts.app')

@section('content')
    <h1>Edit Kategori</h1>

    <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Nama Kategori:</label>
        <input type="text" name="nama" value="{{ $kategori->nama }}" required>
        <button type="submit">Update</button>
    </form>
@endsection
