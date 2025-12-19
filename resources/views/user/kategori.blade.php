<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $kategori->name }} - Katalog Produk</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        /* Navbar Modern */
        .navbar-blur {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* Banner Style */
        .hero-banner {
            height: 300px;
            position: relative;
            border-radius: 0 0 30px 30px;
            overflow: hidden;
            background-color: #2c3e50;
            /* Fallback color */
        }

        .hero-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Default Gradient jika tidak ada gambar kategori */
        .hero-gradient {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .hero-overlay {
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
            position: absolute;
            inset: 0;
            display: flex;
            align-items: flex-end;
        }

        /* Product Card Style */
        .card-product {
            border: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            background: white;
            overflow: hidden;
        }

        .card-product:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        }

        .img-wrapper {
            height: 220px;
            overflow: hidden;
            position: relative;
            background-color: #f1f5f9;
        }

        .card-img-top {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Agar gambar tidak gepeng */
            transition: transform 0.5s ease;
        }

        .card-product:hover .card-img-top {
            transform: scale(1.1);
        }

        /* Badge Stok */
        .badge-stock {
            position: absolute;
            top: 12px;
            right: 12px;
            font-size: 0.7rem;
            padding: 6px 10px;
            z-index: 2;
            border-radius: 20px;
        }
    </style>
</head>

<body>

    <!-- NAVBAR MODERN -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top navbar-blur">
        <div class="container">
            <a href="{{ url('/') }}" class="btn btn-light border rounded-pill px-3 btn-sm fw-bold">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
            <span class="navbar-brand ms-auto fw-bold fs-6 text-uppercase tracking-wide">{{ $kategori->name }}</span>
        </div>
    </nav>

    <!-- SPACER UNTUK NAVBAR FIXED -->
    <div style="height: 70px;"></div>

    <!-- BAGIAN 1: HEADER KATEGORI (HERO SECTION) -->
    <header class="container-fluid px-0 mb-5">
        <div class="hero-banner shadow">

            <!-- Logic Gambar Header: Cek kolom image, jika null pakai Gradient -->
            @if(!empty($kategori->image))
            <img src="{{ asset('storage/' . $kategori->image) }}" class="hero-img" alt="{{ $kategori->name }}">
            @else
            <div class="hero-gradient"></div>
            @endif

            <div class="hero-overlay p-4 pb-5">
                <div class="container">
                    <span class="badge bg-white text-primary mb-2 px-3 py-2 rounded-pill text-uppercase fw-bold shadow-sm" style="font-size: 0.7rem; letter-spacing: 1px;">
                        Kategori Terpilih
                    </span>
                    <h1 class="display-4 fw-bold text-white mb-1">{{ $kategori->name }}</h1>
                    <p class="text-white-50 fs-5 mb-0" style="max-width: 600px;">
                        {{ $kategori->description ?? 'Temukan koleksi produk terbaik dari kategori ini.' }}
                    </p>
                </div>
            </div>
        </div>
    </header>

    <!-- BAGIAN 2: DAFTAR PRODUK -->
    <div class="container pb-5">

        <!-- Filter & Info Jumlah -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold text-dark mb-0 d-flex align-items-center">
                <i class="fas fa-box-open text-primary me-2"></i> Produk Tersedia
            </h5>
            <span class="badge bg-light text-dark border">{{ $products->count() }} Item</span>
        </div>

        <div class="row g-3 g-md-4">
            <!-- CEK PRODUK KOSONG -->
            @if($products->isEmpty())
            <div class="col-12 text-center py-5">
                <div class="bg-white p-5 rounded-4 shadow-sm d-inline-block border">
                    <i class="fas fa-search fa-3x text-muted mb-3 opacity-25"></i>
                    <h4 class="fw-bold text-dark">Oops, Kosong!</h4>
                    <p class="text-muted mb-0">Belum ada produk untuk kategori <strong>{{ $kategori->name }}</strong> saat ini.</p>
                    <a href="{{ url('/') }}" class="btn btn-primary mt-3 rounded-pill px-4">Cari Kategori Lain</a>
                </div>
            </div>
            @else

            <!-- LOOPING PRODUK -->
            @foreach($products as $produk)

            @php
            // --- LOGIKA GAMBAR ROBUST (ANTI ERROR) ---
            $rawImage = $produk->image;

            // 1. Jika data berupa JSON string (misal: "['img1.jpg']"), decode dulu
            if (is_string($rawImage) && str_starts_with($rawImage, '[')) {
            $decoded = json_decode($rawImage, true);
            $rawImage = is_array($decoded) ? $decoded : $rawImage;
            }

            // 2. Jika data adalah array, ambil item pertama
            $imagePath = is_array($rawImage) ? ($rawImage[0] ?? null) : $rawImage;

            // 3. Tentukan URL final (Cek apakah http/https atau local storage)
            if ($imagePath) {
            $imgUrl = Str::startsWith($imagePath, 'http')
            ? $imagePath
            : asset('storage/' . $imagePath);
            } else {
            $imgUrl = 'https://via.placeholder.com/300x300?text=No+Image';
            }
            @endphp

            <div class="col-6 col-md-4 col-lg-3">
                <div class="card card-product h-100 shadow-sm position-relative">

                    <!-- Badge Stok -->
                    @if($produk->stock > 0)
                    <span class="badge bg-success badge-stock">Tersedia</span>
                    @else
                    <span class="badge bg-secondary badge-stock">Habis</span>
                    @endif

                    <!-- Gambar Produk -->
                    <div class="img-wrapper">
                        <img src="{{ $imgUrl }}" class="card-img-top" alt="{{ $produk->name }}" loading="lazy">
                    </div>

                    <div class="card-body d-flex flex-column p-3">
                        <!-- Kategori Label -->
                        <div class="mb-1">
                            <small class="text-uppercase text-muted fw-bold" style="font-size: 0.65rem;">
                                {{ $kategori->name }}
                            </small>
                        </div>

                        <!-- Judul -->
                        <h6 class="card-title fw-bold text-dark mb-1 text-truncate" title="{{ $produk->name }}">
                            {{ $produk->name }}
                        </h6>

                        <!-- Harga & Button -->
                        <div class="mt-auto pt-3">
                            <h5 class="text-primary fw-bold mb-1">
                                Rp {{ number_format($produk->price, 0, ',', '.') }}
                            </h5>

                            <div class="d-flex justify-content-between align-items-center mb-2 small text-muted">
                                <span>Terjual {{ $produk->sold_count }} pcs</span>
                                <span>Stok {{ $produk->stock }}</span>
                            </div>

                            <a href="{{ route('product.show', $produk->id) }}"
                                class="btn btn-dark w-100 rounded-3 btn-sm py-2 fw-medium shadow-sm">
                                <i class="fas fa-eye me-1"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>

    <!-- Footer Simple -->
    <footer class="text-center py-5 mt-5 bg-white border-top">
        <p class="text-muted small mb-0">&copy; {{ date('Y') }} Toko Online. All rights reserved.</p>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>