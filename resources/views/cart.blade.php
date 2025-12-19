@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center mb-4">
        <i class="fas fa-shopping-cart fs-4 text-primary me-2"></i>
        <h3 class="fw-bold m-0">Keranjang Belanja</h3>
    </div>

    <!-- Cek apakah variabel $cart ada dan berisi data -->
    @if(isset($cart) && count($cart) > 0)
    <div class="row g-4">

        <!-- Kolom Kiri: Daftar Produk -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="mb-0 fw-bold text-muted">Daftar Item ({{ count($cart) }})</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3" style="width: 40%;">Produk</th>
                                    <th class="py-3">Harga Satuan</th>
                                    <th class="py-3 text-center">Jumlah</th>
                                    <th class="py-3">Subtotal</th>
                                    <th class="pe-4 py-3 text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach($cart as $id => $details)
                                @php
                                $subtotal = $details['price'] * $details['quantity'];
                                $total += $subtotal;
                                @endphp
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="{{ Str::startsWith($details['image'], 'http') ? $details['image'] : asset('storage/' . $details['image']) }}"
                                                    class="rounded-3 border"
                                                    style="width: 64px; height: 64px; object-fit: cover;"
                                                    alt="{{ $details['name'] }}">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0 fw-semibold text-dark">{{ $details['name'] }}</h6>
                                                <small class="text-muted">ID: #{{ $id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-nowrap">Rp {{ number_format($details['price'], 0, ',', '.') }}</td>
                                    <td>
                                        <div class="input-group input-group-sm justify-content-center" style="width: 100px; margin: 0 auto;">
                                            <input type="text" class="form-control text-center bg-white" value="{{ $details['quantity'] }}" readonly>
                                        </div>
                                    </td>
                                    <td class="fw-bold text-primary text-nowrap">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                    <td class="pe-4 text-end">
                                        <form action="{{ route('cart.remove', $id) }}" method="POST" onsubmit="return confirm('Hapus produk ini dari keranjang?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle" data-bs-toggle="tooltip" title="Hapus Item">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Ringkasan Belanja (Sticky) -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 2rem; z-index: 100;">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-4">Ringkasan Pesanan</h5>

                    <div class="d-flex justify-content-between mb-2 text-muted">
                        <span>Total Item</span>
                        <span>{{ count($cart) }} barang</span>
                    </div>

                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold fs-5">Total Bayar</span>
                        <span class="fw-bold fs-5 text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <hr class="my-4">

                    <!-- Tombol Checkout / QRIS -->
                    <!-- Menambahkan ID untuk loading effect -->
                    <a href="{{ route('checkout.index') }}"
                        class="btn btn-primary w-100 py-3 rounded-3 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2"
                        onclick="startLoading(this)">
                        <i class="fas fa-qrcode fs-5"></i>
                        <span>Bayar dengan QRIS</span>
                    </a>

                    <div class="text-center mt-3">
                        <small class="text-muted d-block">
                            <i class="fas fa-shield-alt me-1"></i> Pembayaran Aman & Terenkripsi
                        </small>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @else
    <!-- Tampilan Modern Jika Keranjang Kosong -->
    <div class="row justify-content-center">
        <div class="col-md-6 text-center py-5">
            <div class="mb-4">
                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                    <i class="fas fa-shopping-basket fa-4x text-muted opacity-50"></i>
                </div>
            </div>
            <h4 class="fw-bold mb-3">Wah, keranjangmu kosong!</h4>
            <p class="text-muted mb-4">Sepertinya kamu belum menambahkan produk apapun. Yuk mulai belanja dan temukan barang favoritmu.</p>
            <a href="{{ route('user.dashboard') }}" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm">
                <i class="fas fa-arrow-left me-2"></i> Belanja Sekarang
            </a>
        </div>
    </div>
    @endif
</div>

<!-- Script Tambahan untuk Efek Loading -->
<script>
    function startLoading(element) {
        // Mencegah double click
        element.style.pointerEvents = 'none';
        element.classList.add('disabled');
        // Ubah teks tombol menjadi loading
        element.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Memproses...';
    }
</script>
@endsection