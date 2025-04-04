@foreach ($barangs as $barang)
    <div class="card">
        <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama }}">
        <h3>{{ $barang->nama }}</h3>
        <p>Kategori: {{ $barang->kategori->nama }}</p>
        <p>Harga: Rp. {{ number_format($barang->harga, 0, ',', '.') }}</p>
        <p>Stok: {{ $barang->jumlah }}</p>

        @if ($barang->jumlah > 0)
            <form action="{{ route('faktur.tambah', $barang->id) }}" method="POST">
                @csrf
                <button type="submit">Masukkan ke Faktur</button>
            </form>
        @else
            <button disabled>Barang sudah habis</button>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

    </div>
@endforeach
