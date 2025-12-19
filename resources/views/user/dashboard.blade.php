@extends('layouts.app')

@push('styles')
<style>
    /* CSS Khusus Halaman Dashboard */
    .hero-banner img {
        border-radius: 12px;
        object-fit: cover;
    }

    /* Kategori Icon Box */
    .cat-icon-box {
        width: 60px;
        height: 60px;
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 8px;
        transition: transform 0.2s;
    }

    .cat-item:hover .cat-icon-box {
        border-color: var(--tokopedia-green);
        transform: translateY(-3px);
    }

    .cat-text {
        font-size: 0.8rem;
        color: #555;
        text-align: center;
    }

    /* --- PRODUCT CARD STYLE (MODIFIKASI) --- */
    .card-product {
        border: none;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
        overflow: hidden;
        transform: translateZ(0);
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .card-product:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    /* Wrapper Gambar agar ukurannya seragam */
    .card-product .img-wrapper {
        height: 180px;
        /* Tinggi gambar tetap */
        width: 100%;
        overflow: hidden;
        position: relative;
        background-color: #f8f9fa;
        /* Warna background jika gambar loading/transparan */
    }

    /* Mengunci ukuran gambar agar seragam */
    .custom-banner-img {
        height: 400px;
        /* Tinggi dikunci (sesuai request awal 400px) */
        width: 100%;
        /* Lebar mengikuti layar */
        object-fit: cover;
        /* PENTING: Agar gambar dipotong rapi, bukan ditarik paksa */
        object-position: center;
        /* Fokus gambar di tengah */
    }

    /* Opsional: Agar responsif di HP, tingginya bisa diperkecil */
    @media (max-width: 768px) {
        .custom-banner-img {
            height: 250px;
        }
    }

    .card-product img {
        height: 100%;
        width: 100%;
        object-fit: cover;
        /* Agar gambar tidak gepeng */
        transition: transform 0.5s ease;
    }

    .card-product:hover img {
        transform: scale(1.05);
    }

    .product-title {
        font-size: 0.95rem;
        line-height: 1.4;
        height: 2.8em;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        margin-bottom: 4px;
        color: #333;
    }

    .product-price {
        font-weight: 800;
        font-size: 1.1rem;
        color: #212529;
        margin-bottom: 4px;
    }

    /* Style Khusus Tombol COD */
    .btn-cod {
        background-color: #ffc107;
        color: #000;
        border: none;
        font-weight: bold;
    }

    .btn-cod:hover {
        background-color: #e0a800;
    }
</style>
@endpush

@section('content')

<!-- 1. SLIDER & KATEGORI LEBAR GBR  -->
@if(!request('search'))
<div class="container-fluid px-5 mt-4">
    <!-- Banner Carousel -->
    <div id="heroCarousel" class="carousel slide shadow-sm rounded-4 overflow-hidden mb-4" data-bs-ride="carousel">

        <!-- Indikator Slide (Titik-titik di bawah) -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
        </div>

        <!-- Area Gambar -->
        <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="carousel-item active">
                <img src="images/home.png" class="d-block w-100 custom-banner-img" alt="Slide 1">
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item">
                <img src="images/all.png" class="d-block w-100 custom-banner-img" alt="Slide 2">
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item">
                <!-- Pastikan nama file gambarnya sesuai -->
                <img src="images/jpt.jpeg" class="d-block w-100 custom-banner-img" alt="Slide 3">
            </div>

            <!-- Slide 4 -->
            <div class="carousel-item">
                <!-- Pastikan nama file gambarnya sesuai -->
                <img src="images/berandaa.jpeg" class="d-block w-100 custom-banner-img" alt="Slide 4">
            </div>
        </div>

        <!-- Tombol Panah Kiri (Previous) -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <!-- Menggunakan span bg-dark agar panah terlihat jelas jika background gambar terang -->
            <span class="carousel-control-prev-icon bg-dark rounded-circle p-3 bg-opacity-50" aria-hidden="true" style="background-size: 50%;"></span>
            <span class="visually-hidden">Previous</span>
        </button>

        <!-- Tombol Panah Kanan (Next) -->
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon bg-dark rounded-circle p-3 bg-opacity-50" aria-hidden="true" style="background-size: 50%;"></span>
            <span class="visually-hidden">Next</span>
        </button>

    </div>
</div>

<!-- Kategori Pilihan -->
<div class="bg-white p-3 rounded-3 shadow-sm border mb-4">
    <h5 class="fw-bold mb-3">Kategori Pilihan</h5>
    <div class="d-flex justify-content-between text-center overflow-auto pb-2 gap-3">

        <!-- Kopi -->
        <a href="{{ url('/kategori/kopi') }}" class="text-decoration-none cat-item">
            <div class="cat-icon-box"><i class="fas fa-mug-hot text-danger fs-3"></i></div>
            <span class="cat-text">Kopi</span>
        </a>

        <!-- Baju -->
        <a href="{{ url('/kategori/baju') }}" class="text-decoration-none cat-item">
            <div class="cat-icon-box"><i class="fas fa-tshirt text-primary fs-3"></i></div>
            <span class="cat-text">Baju</span>
        </a>

        <!-- Celana -->
        <a href="{{ url('/kategori/celana') }}" class="text-decoration-none cat-item">
            <div class="cat-icon-box"><i class="fas fa-person-hiking text-success fs-3"></i></div>
            <span class="cat-text">Celana</span>
        </a>

        <!-- Topi (Perbaikan: ubah 'Topi' jadi 'topi') -->
        <a href="{{ url('/kategori/topi') }}" class="text-decoration-none cat-item">
            <div class="cat-icon-box"><i class="fas fa-hat-cowboy-side text-warning fs-3"></i></div>
            <span class="cat-text">Topi</span>
        </a>

        <!-- Jaket (Perbaikan: ubah 'Jaket' jadi 'jaket') -->
        <a href="{{ url('/kategori/jaket') }}" class="text-decoration-none cat-item">
            <div class="cat-icon-box"><i class="fas fa-vest text-secondary fs-3"></i></div>
            <span class="cat-text">Jaket</span>
        </a>
    </div>
</div>
@endif

<!-- 2. PRODUK SECTION -->
<div class="container mt-3">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil!</strong> {{ session('success') }}
        <a href="{{ url('/cart') }}" class="fw-bold text-decoration-none text-success">Lihat Keranjang</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
</div>

<div class="container mt-4 mb-5">
    <!-- Header Section -->
    <div class="d-flex align-items-center mb-3">
        @if(request('search'))
        <h4 class="flex-grow-1 fw-bold">Hasil pencarian: "{{ request('search') }}"</h4>
        <a href="{{ route('user.dashboard') }}" class="btn btn-sm btn-outline-danger">Reset</a>
        @else
        <h4 class="flex-grow-1 fw-bold">Rekomendasi Untukmu</h4>
        <a href="#" class="text-decoration-none fw-bold" style="color: var(--tokopedia-green);">Lihat Semua</a>
        @endif
    </div>

    <!-- GRID PRODUK DINAMIS -->
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-3">
        @forelse($products as $item)
        <div class="col">
            <div class="card card-product h-100 border-0 shadow-sm">

                <!-- LINK KE DETAIL -->
                <a href="{{ route('product.show', $item->id) }}" class="text-decoration-none text-dark flex-grow-1">

                    <!-- BAGIAN GAMBAR YANG SUDAH DIPERBAIKI -->
                    <div class="img-wrapper">
                        @if(is_array($item->image) && count($item->image) > 0)
                        {{-- Jika Array (Multiple Images), ambil index ke-0 --}}
                        <img src="{{ asset('storage/' . $item->image[0]) }}" alt="{{ $item->name }}">
                        @elseif(is_string($item->image) && $item->image != '')
                        {{-- Jika String (Data Lama) --}}
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                        @else
                        {{-- Jika Tidak Ada Gambar --}}
                        <img src="https://via.placeholder.com/300?text=No+Image" alt="No Image">
                        @endif
                    </div>

                    <div class="card-body p-2">
                        <div class="product-title fw-bold">
                            {{ $item->name }}
                        </div>
                        <div class="product-price text-primary">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </div>
                        <div class="small text-muted mt-1">
                            <i class="fas fa-star text-warning"></i>
                            {{ number_format($item->reviews->avg('rating') ?? 0, 1) }} |
                            Terjual {{ $item->sold_count }}
                        </div>
                    </div>
                </a>

                <!-- TOMBOL AKSI -->
                <div class="card-footer bg-white border-0 p-2 pt-0">
                    <div class="d-flex flex-column gap-2">

                        <!-- Baris 1: Tombol QRIS & COD -->
                        <div class="d-flex gap-2 w-100">
                            <!-- Tombol QRIS -->
                            <!-- GANTI BAGIAN INI DI DASHBOARD -->
                            <form action="{{ route('checkout.process_direct') }}" method="POST" class="flex-fill d-flex">
                                @csrf
                                <!-- Kirim Data Produk -->
                                <input type="hidden" name="product_id" value="{{ $item->id }}">
                                <input type="hidden" name="quantity" value="1">

                                <!-- Tombol Submit (Tampilan sama persis dengan tombol sebelumnya) -->
                                <button type="submit"
                                    class="btn btn-success btn-sm flex-fill fw-bold shadow-sm d-flex align-items-center justify-content-center"
                                    style="background: linear-gradient(45deg, #198754, #20c997); border: none; font-size: 0.75rem;">
                                    <i class="fas fa-qrcode me-1"></i> QRIS
                                </button>
                            </form>

                            <!-- Tombol COD (Pemicu Modal) -->
                            <button type="button"
                                class="btn btn-cod btn-sm flex-fill shadow-sm d-flex align-items-center justify-content-center"
                                style="font-size: 0.75rem;"
                                onclick="openCodModal('{{ $item->id }}', '{{ $item->name }}', '{{ $item->price }}')">
                                <i class="fas fa-handshake me-1"></i> COD
                            </button>
                        </div>

                        <!-- Baris 2: Tombol Keranjang -->
                        <form action="{{ route('cart.add', $item->id) }}" method="POST" class="w-100">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary btn-sm shadow-sm w-100 fw-bold" title="Tambah ke Keranjang">
                                <i class="fas fa-cart-plus me-1"></i> + Keranjang
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <img src="https://via.placeholder.com/150?text=Kosong" alt="Empty" class="mb-3" width="100">
            <p class="text-muted">Produk tidak ditemukan.</p>
        </div>
        @endforelse
    </div>

</div>

<!-- PAGINATION -->
<div class="d-flex justify-content-center mt-5 mb-5">
    {{ $products->appends(request()->query())->links() }}
</div>

<!-- ================= MODAL PEMBAYARAN COD ================= -->
<div class="modal fade" id="modalCOD" tabindex="-1" aria-labelledby="modalCODLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header bg-warning bg-opacity-10">
                <h5 class="modal-title fw-bold text-dark" id="modalCODLabel">
                    <i class="fas fa-motorcycle text-warning me-2"></i>Pesan via COD
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('checkout.cod') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <!-- Data Produk (Hidden) -->
                    <input type="hidden" name="product_id" id="cod_product_id">

                    <!-- Info Produk -->
                    <div class="d-flex align-items-center mb-4 p-3 bg-light rounded-3 border">
                        <div class="flex-grow-1">
                            <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Produk</small>
                            <div id="cod_product_name" class="fw-bold text-dark text-truncate" style="max-width: 200px;">Nama Produk</div>
                        </div>
                        <div class="text-end">
                            <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Harga</small>
                            <div id="cod_product_price" class="text-success fw-bold">Rp 0</div>
                        </div>
                    </div>

                    <!-- Input Jam COD -->
                    <div class="mb-3">
                        <label for="cod_time" class="form-label fw-bold small text-uppercase">Jam Pertemuan (Wajib)</label>
                        <input type="time" class="form-control form-control-lg bg-light border-0" id="cod_time" name="cod_time" required>
                        <div class="form-text text-muted small"><i class="far fa-clock me-1"></i> Masukkan jam berapa Anda ingin bertemu kurir.</div>
                    </div>

                    <!-- Input Catatan/Lokasi -->
                    <div class="mb-3">
                        <label for="cod_note" class="form-label fw-bold small text-uppercase">Lokasi / Catatan (Opsional)</label>
                        <textarea class="form-control bg-light border-0" id="cod_note" name="cod_note" rows="2" placeholder="Contoh: Depan Indomaret Simpang 5, pakai baju merah..."></textarea>
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0 px-4 pb-4">
                    <button type="button" class="btn btn-light fw-bold rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning fw-bold rounded-pill px-4 flex-grow-1 shadow-sm">
                        Buat Pesanan <i class="fas fa-arrow-right ms-1"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script untuk Modal COD -->
<script>
    function openCodModal(id, name, price) {
        document.getElementById('cod_product_id').value = id;
        document.getElementById('cod_product_name').innerText = name;

        let formattedPrice = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(price);
        document.getElementById('cod_product_price').innerText = formattedPrice;

        var myModal = new bootstrap.Modal(document.getElementById('modalCOD'));
        myModal.show();
    }
</script>

@endsection