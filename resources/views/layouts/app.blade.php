<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'DelShoope') }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --tokopedia-green: #03AC0E;
            --tokopedia-gray: #6C757D;
            --bg-body: #F0F3F7;
            --delshoope-blue: #0d6efd;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            background-color: var(--bg-body);
            color: #212529;
            scroll-behavior: smooth;
        }

        /* --- NAVBAR STYLE --- */
        .navbar {
            background-color: #fff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .search-container .input-group:focus-within {
            border-color: var(--delshoope-blue);
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
        }

        /* --- ICON MENU & CART (NAVBAR) --- */
        .nav-icon-btn {
            color: #5d5d5d;
            font-size: 1.2rem;
            padding: 8px;
            border-radius: 8px;
            transition: 0.2s;
        }

        .nav-icon-btn:hover {
            background-color: #f3f4f5;
            color: var(--delshoope-blue);
        }

        /* --- CUSTOM FOOTER STYLE --- */
        .footer-custom {
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
            color: #5e666e;
            font-size: 0.9rem;
        }

        .footer-logo {
            height: 45px;
            width: auto;
            border-radius: 6px;
            object-fit: contain;
        }

        .brand-text {
            color: var(--delshoope-blue);
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
        }

        .footer-link {
            color: #6c757d;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
            margin-bottom: 8px;
        }

        .footer-link:hover {
            color: var(--delshoope-blue);
            transform: translateX(5px);
        }

        .social-icon {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: #fff;
            color: #6c757d;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            background-color: var(--delshoope-blue);
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
        }

        /* --- FLOATING CART BUTTON (TOMBOL MELAYANG) --- */
        .btn-floating-cart {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background-color: var(--delshoope-blue);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.4);
            z-index: 1050;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-decoration: none;
            border: 2px solid #fff;
            cursor: pointer;
        }

        .btn-floating-cart:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 8px 25px rgba(13, 110, 253, 0.6);
            color: white;
        }

        .badge-cart {
            position: absolute;
            top: 0;
            right: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 20px;
            height: 16px;
            padding: 0 4px;
            background-color: #dc3545;
            color: white;
            border-radius: 50rem;
            font-size: 9px;
            font-weight: 800;
            transform: translate(30%, -30%);
            z-index: 10;
        }
    </style>

    @stack('styles')
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg sticky-top" id="top-header">
        <div class="container gap-lg-4">

            <!-- LOGO -->
            <a class="navbar-brand d-flex align-items-center gap-2 me-0" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.jpg') }}" height="40" style="object-fit: contain;">
                <link rel="shortcut icon" href="{{ asset('images/logo.jpg') }}" type="image/x-icon">
                <span class="fw-bold" style="color: #0d6efd; font-size: 24px; letter-spacing: -0.5px;">
                    DelShoope
                </span>
            </a>

            <!-- MOBILE TOGGLER -->
            <button class="navbar-toggler border-0 p-0 ms-auto me-3 d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- SEARCH BAR -->
            <form action="{{ route('user.dashboard') }}" method="GET" class="flex-grow-1 d-flex my-2 my-lg-0 search-container">
                <div class="input-group w-100">
                    <span class="input-group-text bg-white border-0 ps-3 text-muted"><i class="fas fa-search"></i></span>
                    <input type="search" class="form-control shadow-none border-0" placeholder="Cari di DelShoope" name="search" value="{{ request('search') }}">
                </div>
            </form>

            <!-- MENU KANAN -->
            <div class="collapse navbar-collapse flex-grow-0" id="navbarContent">
                <ul class="navbar-nav align-items-lg-center gap-lg-2 ms-auto">

                    <!-- KERANJANG BELANJA -->
                    <li class="nav-item">
                        <a href="{{ route('cart.index') }}" class="nav-link nav-icon-btn position-relative">
                            <i class="fas fa-shopping-cart"></i>

                            @auth
                            @if(isset($cartCount) && $cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light" style="font-size: 0.6rem;">
                                {{ $cartCount }}
                                <span class="visually-hidden">item di keranjang</span>
                            </span>
                            @endif
                            @endauth
                        </a>
                    </li>

                    @auth
                    <!-- IKON CHAT NAVBAR -->
                    <li class="nav-item">
                        <a href="{{ route('user.messages.index') }}"
                            class="nav-link nav-icon-btn position-relative"
                            title="Pesan">
                            <i class="fas fa-comments"></i>

                            @if(isset($unreadMessagesCount) && $unreadMessagesCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light" style="font-size: 0.6rem;">
                                {{ $unreadMessagesCount }}
                                <span class="visually-hidden">pesan belum dibaca</span>
                            </span>
                            @endif
                        </a>
                    </li>
                    @endauth

                    <li class="nav-item d-lg-none">
                        <hr class="my-2">
                    </li>

                    @auth
                    <!-- LOGIN USER -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                            <img src="{{ Auth::user()->avatar_url }}?v={{ Auth::user()->updated_at->timestamp }}"
                                class="rounded-circle border border-2 border-light shadow-sm"
                                width="32" height="32"
                                style="object-fit: cover;"
                                alt="{{ Auth::user()->name }}">
                            <span class="fw-bold text-dark small">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                            <li><a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger fw-bold">Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                    <!-- GUEST -->
                    <div class="d-flex gap-2 ms-lg-2 mt-3 mt-lg-0">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary fw-bold btn-sm px-3">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-primary fw-bold btn-sm px-3 text-white">Daftar</a>
                    </div>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT WRAPPER -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="footer-custom pt-5 pb-4 mt-auto">
        <div class="container">
            <div class="row">
                <!-- Kolom 1: Brand & Logo -->
                <div class="col-lg-4 mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <img src="images/logo.jpg" alt="DelShoope Logo" class="footer-logo">
                        <h4 class="brand-text m-0">DelShoope</h4>
                    </div>
                    <p class="small pr-lg-5">
                        Belanja puas harga pas. Platform belanja online terpercaya yang menyediakan berbagai kebutuhan Anda dengan kualitas terbaik.
                    </p>
                </div>

                <!-- Kolom 2: Bantuan -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3 text-dark">Bantuan</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="#" class="footer-link">Cara Belanja</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Metode Pembayaran</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Syarat & Ketentuan</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Kebijakan Privasi</a></li>
                    </ul>
                </div>

                <!-- Kolom 3: Tentang Kami -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3 text-dark">Tentang Kami</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('tentang') }}" class="footer-link">Tentang DelShoope</a></li>
                        <li class="mb-2"><a href="{{ route('softwaredeveloper') }}" class="footer-link">Software Developer</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Blog</a></li>
                    </ul>
                </div>

                <!-- Kolom 4: Social Media -->
                <div class="col-lg-4 mb-4">
                    <h6 class="fw-bold mb-3 text-dark">Ikuti Kami</h6>
                    <p class="small mb-3">Dapatkan info promo terbaru dan update menarik dari Kami.</p>
                    <div class="d-flex gap-2">
                        <a href="https://www.instagram.com/tianhts_/" class="social-icon" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.linkedin.com/in/septian-a-hutasoit/" class="social-icon" target="_blank">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="https://github.com/Septianhutasoit" class="social-icon" target="_blank">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="https://www.youtube.com/channel/UCeCs1ahm1GDgNl1rBLTIqyQ" class="social-icon" target="_blank">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>

            <hr class="my-4" style="opacity: 0.1;">

            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                    <p class="small text-muted mb-0">
                        &copy; {{ date('Y') }} <span class="fw-bold text-primary">DelShoope</span>. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="small text-muted mb-0">Made with <i class="fas fa-heart text-danger"></i> in Indonesia</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- TOMBOL FLOATING CART -->
    <a href="{{ route('cart.index') }}" class="btn-floating-cart" title="Lihat Keranjang">
        <i class="fas fa-shopping-cart"></i>

        @auth
        @if(isset($cartCount) && $cartCount > 0)
        <span class="badge-cart">
            {{ $cartCount }}
        </span>
        @endif
        @endauth
    </a>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script Custom untuk Scroll ke Atas -->
    <script>
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    </script>
</body>

</html>