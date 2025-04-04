<h2>Keranjang</h2>

@if (session('error'))
    <div style="color:red">{{ session('error') }}</div>
@endif
@if (session('success'))
    <div style="color:green">{{ session('success') }}</div>
@endif

<table>
    <tr>
        <th>Nama</th>
        <th>Kategori</th>
        <th>Jumlah</th>
        <th>Subtotal</th>
    </tr>
    @php $total = 0; @endphp
    @foreach (session('keranjang', []) as $item)
        <tr>
            <td>{{ $item['nama'] }}</td>
            <td>{{ $item['kategori'] }}</td>
            <td>{{ $item['jumlah'] }}</td>
            <td>Rp. {{ number_format($item['jumlah'] * $item['harga']) }}</td>
        </tr>
        @php $total += $item['jumlah'] * $item['harga']; @endphp
    @endforeach
</table>

<p><strong>Total: Rp. {{ number_format($total) }}</strong></p>

<form action="{{ route('checkout') }}" method="POST">
    @csrf
    <label>Alamat Pengiriman:</label><br>
    <textarea name="alamat" required minlength="10" maxlength="100"></textarea><br>
    <label>Kode Pos (5 digit):</label><br>
    <input type="text" name="kode_pos" required pattern="[0-9]{5}" /><br><br>
    <button type="submit">Checkout & Cetak Faktur</button>
</form>
