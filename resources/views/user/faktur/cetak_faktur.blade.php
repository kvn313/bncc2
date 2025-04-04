<!DOCTYPE html>
<html>
<head>
    <title>Faktur Pembelian</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .invoice-box {
            max-width: 800px;
            border: 1px solid #eee;
            padding: 30px;
        }
        .title { font-size: 24px; font-weight: bold; margin-bottom: 20px; }
        table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }
        table td, table th {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="title">FAKTUR PEMBELIAN</div>

        <p><strong>Nomor Invoice:</strong> {{ $faktur->nomor_invoice }}</p>
        <p><strong>Tanggal:</strong> {{ $faktur->created_at->format('d M Y') }}</p>
        <p><strong>Alamat Pengiriman:</strong> {{ $faktur->alamat }}</p>
        <p><strong>Kode Pos:</strong> {{ $faktur->kode_pos }}</p>

        <br>

        <table>
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Kuantitas</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($faktur->details as $item)
                <tr>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->kategori_barang }}</td>
                    <td>{{ $item->kuantitas }}</td>
                    <td>Rp. {{ number_format($item->subtotal) }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="total">Total</td>
                    <td class="total">Rp. {{ number_format($faktur->total_harga) }}</td>
                </tr>
            </tbody>
        </table>

        <br>
        <p>Terima kasih telah berbelanja di perpustakaan kami!</p>
    </div>
</body>
</html>
