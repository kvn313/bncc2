@extends('layouts.app')

@section('content')
    <h1>Daftar Barang</h1>

    <a href="{{ route('admin.barang.create') }}">+ Tambah Barang</a>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangs as $barang)
                <tr>
                    <td>
                        @if($barang->foto)
                            <img src="{{ asset('storage/' . $barang->foto) }}" width="80">
                        @else
                            Tidak ada foto
                        @endif
                    </td>
                    <td>{{ $barang->nama_barang }}</td>
                    <td>Rp. {{ number_format($barang->harga, 0, ',', '.') }}</td>
                    <td>{{ $barang->jumlah }}</td>
                    <td>{{ $barang->kategori->nama }}</td>
                    <td>
                        <a href="{{ route('admin.barang.edit', $barang->id) }}">Edit</a>

                        <form action="{{ route('admin.barang.destroy', $barang->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
