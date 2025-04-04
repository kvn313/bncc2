<h2>Faktur Pembelian</h2>

<p><strong>Nomor Invoice:</strong> {{ $faktur->nomor_invoice }}</p>
<p><strong>Alamat Pengiriman:</strong> {{ $faktur->alamat }}</p>
<p><strong>Kode Pos:</strong> {{ $faktur->kode_pos }}</p>

<hr>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Kuantitas</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($faktur->detail as $item)
            <tr>
                <td>{{ $item->nama_barang }}</td>
                <td>{{ $item->kategori_barang }}</td>
                <td>{{ $item->kuantitas }}</td>
                <td>Rp. {{ number_format($item->subtotal) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<hr>

<p><strong>Total Harga:</strong> Rp. {{ number_format($faktur->total_harga) }}</p>

<button onclick="window.print()">Cetak Faktur</button>
