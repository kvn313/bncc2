@extends('layouts.app')

@section('content')
    <h1>Daftar Kategori</h1>

    <a href="{{ route('admin.kategori.create') }}">+ Tambah Kategori</a>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kategoris as $kategori)
                <tr>
                    <td>{{ $kategori->nama }}</td>
                    <td>
                        <a href="{{ route('admin.kategori.edit', $kategori->id) }}">Edit</a>
                        <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
