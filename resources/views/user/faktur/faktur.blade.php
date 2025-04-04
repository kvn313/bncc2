@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Faktur / Keranjang Belanja</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(count($keranjang) > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($keranjang as $item)
                    @php
                        $subtotal = $item['harga'] * $item['jumlah'];
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $item['nama'] }}</td>
                        <td>{{ $item['kategori'] }}</td>
                        <td>Rp. {{ number_format($item['harga']) }}</td>
                        <td>{{ $item['jumlah'] }}</td>
                        <td>Rp. {{ number_format($subtotal) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="4" class="text-end">Total</th>
                    <th>Rp. {{ number_format($total) }}</th>
                </tr>
            </tbody>
        </table>

        <form action="{{ route('faktur.simpan') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat Pengiriman</label>
                <input type="text" name="alamat" class="form-control" required minlength="10" maxlength="100" value="{{ old('alamat') }}">
            </div>
            <div class="mb-3">
                <label for="kode_pos" class="form-label">Kode Pos</label>
                <input type="text" name="kode_pos" class="form-control" required pattern="\d{5}" maxlength="5" value="{{ old('kode_pos') }}">
            </div>
            <button type="submit" class="btn btn-primary">Simpan & Cetak Faktur</button>
        </form>

    @else
        <p>Keranjang kosong.</p>
    @endif
</div>
@endsection
