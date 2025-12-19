@extends('layouts.app')

@section('content')
<style>
    /* --- CUSTOM CSS THEME BIRU --- */
    :root {
        --main-blue: #0d6efd;
        --hover-blue: #0a58ca;
        --light-blue-bg: #f0f7ff;
    }

    .product-title {
        font-size: 1.6rem;
        color: #212529;
        line-height: 1.3;
    }

    .product-price {
        font-size: 1.8rem;
        color: var(--main-blue);
    }

    /* Thumbnail Gambar */
    .thumb-scroll-wrapper {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 5px;
        /* Scrollbar styling untuk Chrome/Safari/Edge */
        scrollbar-width: thin;
    }

    .thumb-scroll-wrapper::-webkit-scrollbar {
        height: 6px;
    }

    .thumb-scroll-wrapper::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 10px;
    }

    .thumb-img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        cursor: pointer;
        border: 2px solid transparent;
        opacity: 0.7;
        transition: all 0.2s ease-in-out;
        flex-shrink: 0;
        /* Agar gambar tidak mengecil saat banyak */
    }

    .thumb-img:hover,
    .thumb-img.active {
        border-color: var(--main-blue);
        opacity: 1;
        transform: scale(1.05);
    }

    /* Tombol & Input Quantity (Sama seperti sebelumnya) */
    .btn-outline-blue {
        color: var(--main-blue);
        border: 2px solid var(--main-blue);
        background: transparent;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-outline-blue:hover {
        background: var(--light-blue-bg);
        color: var(--hover-blue);
        border-color: var(--hover-blue);
    }

    .btn-blue {
        background-color: var(--main-blue);
        border: 2px solid var(--main-blue);
        color: white;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-blue:hover {
        background-color: var(--hover-blue);
        border-color: var(--hover-blue);
        color: white;
    }

    .btn-disabled {
        background-color: #e9ecef;
        color: #6c757d;
        border: 1px solid #ced4da;
        cursor: not-allowed;
    }

    .quantity-wrapper {
        display: flex;
        align-items: center;
        border: 1px solid #ced4da;
        border-radius: 8px;
        overflow: hidden;
        width: fit-content;
    }

    .quantity-wrapper button {
        background: #f8f9fa;
        border: none;
        padding: 8px 15px;
        font-size: 1.2rem;
        color: #333;
        transition: 0.2s;
    }

    .quantity-wrapper button:hover {
        background: #e2e6ea;
    }

    .input-quantity {
        border: none;
        text-align: center;
        width: 60px;
        font-weight: bold;
        -moz-appearance: textfield;
        background: #fff;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .purchase-card {
        border: 1px solid #e1e4e8;
        border-radius: 12px;
        position: sticky;
        top: 20px;
    }

    /* Star Rating CSS */
    .rate {
        float: left;
        height: 46px;
        padding: 0 10px;
    }

    .rate:not(:checked)>input {
        position: absolute;
        top: -9999px;
    }

    .rate:not(:checked)>label {
        float: right;
        width: 1em;
        overflow: hidden;
        white-space: nowrap;
        cursor: pointer;
        font-size: 30px;
        color: #ccc;
    }

    .rate:not(:checked)>label:before {
        content: '★ ';
    }

    .rate>input:checked~label {
        color: #ffc700;
    }

    .rate:not(:checked)>label:hover,
    .rate:not(:checked)>label:hover~label {
        color: #deb217;
    }

    .rate>input:checked+label:hover,
    .rate>input:checked+label:hover~label,
    .rate>input:checked~label:hover,
    .rate>input:checked~label:hover~label,
    .rate>label:hover~input:checked~label {
        color: #c59b08;
    }
</style>

<div class="container py-5" style="background: #fff;">

    <!-- ALERT JIKA SUKSES -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- TOMBOL KEMBALI -->
    <div class="mb-3">
        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-3 px-3 fw-bold">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
        </a>
    </div>

    <!-- INFO PRODUK (BAGIAN ATAS) -->
    <div class="row">

        <!-- BAGIAN GAMBAR (DIMODIFIKASI) -->
        <div class="col-lg-4 col-md-5 mb-4">
            <!-- Gambar Utama -->
            <div class="mb-3 position-relative">
                @php
                // Asumsi Model sudah cast 'image' => 'array'
                $images = $product->image;
                $mainImage = (is_array($images) && count($images) > 0) ? $images[0] : null;
                @endphp

                @if($mainImage)
                <img id="mainImage"
                    src="{{ asset('storage/' . $mainImage) }}"
                    class="img-fluid rounded-3 shadow-sm w-100"
                    style="object-fit: cover; aspect-ratio: 1/1; background-color: #f8f9fa;">
                @else
                <img id="mainImage"
                    src="https://via.placeholder.com/500?text=No+Image"
                    class="img-fluid rounded-3 shadow-sm w-100">
                @endif

                <!-- Badge Stok Habis -->
                @if($product->stock <= 0)
                    <div class="position-absolute top-50 start-50 translate-middle badge bg-dark fs-5 px-4 py-2 opacity-75">
                    HABIS
            </div>
            @endif
        </div>

        <!-- Thumbnail Gallery -->
        @if(is_array($images) && count($images) > 0)
        <div class="thumb-scroll-wrapper justify-content-center">
            @foreach($images as $key => $img)
            <img src="{{ asset('storage/' . $img) }}"
                class="thumb-img rounded {{ $key == 0 ? 'active' : '' }}"
                onclick="changeImage(this)"
                alt="Thumbnail {{ $key + 1 }}">
            @endforeach
        </div>
        @endif
    </div>
    <!-- END BAGIAN GAMBAR -->

    <!-- DETAIL PRODUK -->
    <div class="col-lg-5 col-md-7 mb-4 ps-lg-4">
        <h1 class="product-title fw-bold mb-3">{{ $product->name }}</h1>

        <div class="d-flex align-items-center mb-3 small">
            {{-- Rata-rata Rating Dinamis, aman walau belum ada review --}}
            @php
            $avgRating = $product->reviews->avg('rating') ?? 0;
            @endphp
            <div class="text-warning me-2">
                <i class="fas fa-star"></i> {{ number_format($avgRating, 1) }}
            </div>

            <span class="text-muted border-end pe-3 me-3">
                ({{ $product->reviews->count() }} Ulasan)
            </span>

            {{-- Pakai accessor sold_count --}}
            <span class="text-muted">
                Terjual {{ $product->sold_count }} pcs
            </span>
        </div>

        <h2 class="product-price fw-bold mb-4">
            Rp {{ number_format($product->price, 0, ',', '.') }}
        </h2>

        <div class="border-top border-bottom py-4 mb-4">
            <h6 class="fw-bold text-dark mb-3">Deskripsi</h6>
            <p class="text-secondary mb-0" style="line-height: 1.6;">
                {{ $product->description ?? 'Deskripsi produk belum tersedia.' }}
            </p>
        </div>

        <!-- Info Toko -->
        <div class="d-flex align-items-center p-3 rounded-3" style="background-color: var(--light-blue-bg);">
            <div class="me-3">
                <div class="bg-white text-primary rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="fas fa-store fa-lg" style="color: var(--main-blue);"></i>
                </div>
            </div>
            <div>
                <h6 class="mb-0 fw-bold">DelShop Official</h6>
                <small class="text-muted">
                    <i class="fas fa-map-marker-alt me-1"></i> Toba, Sumatera Utara
                </small>
            </div>
        </div>
    </div>

    <!-- BOX PEMBELIAN -->
    <div class="col-lg-3 col-md-12">
        <div class="card purchase-card shadow-sm">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">Atur Jumlah</h6>
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="cod_time" value="{{ now()->addDay()->format('Y-m-d H:i') }}">
                    <input type="hidden" name="cod_note" value="COD dari halaman produk">

                    @if($product->stock > 0)
                    <div class="d-flex align-items-center mb-3">
                        <div class="quantity-wrapper me-3">
                            <button type="button" onclick="decrementValue()">−</button>
                            <input
                                type="number"
                                name="quantity"
                                id="quantity"
                                class="input-quantity"
                                value="1"
                                min="1"
                                max="{{ $product->stock }}"
                                readonly>
                            <button type="button" onclick="incrementValue()">+</button>
                        </div>
                        <small class="text-muted">Sisa {{ $product->stock }}</small>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        {{-- 1. Tambah ke keranjang --}}
                        <button type="submit" class="btn btn-outline-blue py-2 rounded-3">
                            + Keranjang
                        </button>

                        {{-- 2. Beli sekarang → QRIS --}}
                        <button
                            type="submit"
                            formaction="{{ route('checkout.process_direct') }}"
                            class="btn btn-blue py-2 rounded-3 shadow-sm">
                            Beli Sekarang
                        </button>

                        {{-- 3. Bayar COD (DIMODIFIKASI) --}}
                        <button
                            type="submit"
                            formaction="{{ route('checkout.cod') }}"
                            class="btn py-2 rounded-3 fw-bold d-flex align-items-center justify-content-center gap-2"
                            style="background-color: #ffc107; color: #000; border: none;">
                            <i class="fas fa-handshake fa-lg"></i>
                            COD
                        </button>
                    </div>
                    @else
                    <div class="alert alert-secondary text-center py-3 mb-3">
                        <span class="fw-bold text-muted">Stok Habis</span>
                    </div>
                    <div class="d-grid">
                        <button type="button" class="btn btn-disabled py-2 rounded-3" disabled>
                            Tidak Tersedia
                        </button>
                    </div>
                    @endif
                </form>

            </div>
        </div>
    </div>
</div>

<!-- ULASAN -->
<div class="row mt-5">
    <div class="col-12 bg-light p-4 rounded-3">
        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
            <h5 class="fw-bold mb-0">Ulasan Pembeli ({{ $product->reviews->count() }})</h5>
        </div>

        <!-- FORM INPUT ULASAN -->
        @auth
        <div class="card mb-5 border-0 shadow-sm">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="fas fa-pen-nib me-2"></i>Tulis Ulasan Anda</h6>
                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label small text-muted">Berikan Rating</label>
                            <div class="rate d-block w-100">
                                <input type="radio" id="star5" name="rating" value="5" required />
                                <label for="star5" title="Sangat Bagus">5 stars</label>
                                <input type="radio" id="star4" name="rating" value="4" />
                                <label for="star4" title="Bagus">4 stars</label>
                                <input type="radio" id="star3" name="rating" value="3" />
                                <label for="star3" title="Cukup">3 stars</label>
                                <input type="radio" id="star2" name="rating" value="2" />
                                <label for="star2" title="Kurang">2 stars</label>
                                <input type="radio" id="star1" name="rating" value="1" />
                                <label for="star1" title="Sangat Kurang">1 star</label>
                            </div>
                        </div>
                        <div class="col-md-8 mb-3">
                            <label class="form-label small text-muted">Komentar Anda</label>
                            <textarea name="comment" class="form-control" rows="3" placeholder="Ceritakan pengalaman Anda..." required></textarea>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-blue px-4 rounded-3 btn-sm">Kirim Ulasan</button>
                    </div>
                </form>
            </div>
        </div>
        @else
        <div class="alert alert-info mb-4">Silakan <a href="{{ route('login') }}" class="fw-bold text-dark">Login</a> untuk menulis ulasan.</div>
        @endauth

        <!-- LIST DAFTAR ULASAN -->
        @forelse($product->reviews as $review)
        <div class="d-flex mt-4 border-bottom pb-4 bg-white p-3 rounded-3 shadow-sm">
            <div class="me-3">
                <div class="bg-light border rounded-circle d-flex align-items-center justify-content-center text-primary fw-bold" style="width: 50px; height: 50px;">
                    {{ substr($review->user->name, 0, 1) }}
                </div>
            </div>
            <div class="w-100">
                <div class="d-flex justify-content-between">
                    <div class="fw-bold text-dark">{{ $review->user->name }}</div>
                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                </div>
                <div class="text-warning small mb-2 mt-1">
                    @for($i=1; $i<=5; $i++)
                        <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                        @endfor
                </div>
                <p class="text-secondary mb-0">{{ $review->comment }}</p>
            </div>
        </div>
        @empty
        <div class="text-center py-5 text-muted">Belum ada ulasan.</div>
        @endforelse
    </div>
</div>
</div>

<!-- SCRIPT JS LOGIC -->
<script>
    // FUNGSI GANTI GAMBAR UTAMA SAAT THUMBNAIL DIKLIK
    function changeImage(element) {
        // Ganti src gambar utama dengan src thumbnail yang diklik
        var mainImg = document.getElementById('mainImage');
        mainImg.src = element.src;

        // Hapus class 'active' dari semua thumbnail
        var thumbnails = document.querySelectorAll('.thumb-img');
        thumbnails.forEach(function(img) {
            img.classList.remove('active');
        });

        // Tambah class 'active' ke thumbnail yang diklik
        element.classList.add('active');
    }

    function incrementValue() {
        var quantityInput = document.getElementById('quantity');
        var value = parseInt(quantityInput.value, 10);
        var maxStock = parseInt(quantityInput.getAttribute('max'), 10);
        value = isNaN(value) ? 0 : value;
        if (value < maxStock) quantityInput.value = value + 1;
    }

    function decrementValue() {
        var quantityInput = document.getElementById('quantity');
        var value = parseInt(quantityInput.value, 10);
        value = isNaN(value) ? 0 : value;
        if (value > 1) quantityInput.value = value - 1;
    }
</script>
@endsection