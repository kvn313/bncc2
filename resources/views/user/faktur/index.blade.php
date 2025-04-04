@extends('layouts.app')

@section('content')
    <h1>Cetak Faktur</h1>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach ($keranjang as $item)
                @php $subtotal = $item['harga'] * $item['qty']; @endphp
                <tr>
                    <td>{{ $item['nama'] }}</td>
                    <td>{{ $item['kategori'] }}</td>
                    <td>Rp. {{ number_format($item['harga']) }}</td>
                    <td>{{ $item['qty'] }}</td>
                    <td>Rp. {{ number_format($subtotal) }}</td>
                </tr>
                @php $total += $subtotal; @endphp
            @endforeach
            <tr>
                <td colspan="4"><strong>Total</strong></td>
                <td><strong>Rp. {{ number_format($total) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <form action="{{ route('user.faktur.simpan') }}" method="POST" style="margin-top:20px;">
        @csrf
        <label>Alamat Pengiriman:</label><br>
        <textarea name="alamat" required minlength="10" maxlength="100"></textarea><br>

        <label>Kode Pos:</label><br>
        <input type="text" name="kode_pos" required pattern="\d{5}"><br><br>

        <button type="submit">Cetak Faktur</button>
    </form>
@endsection
