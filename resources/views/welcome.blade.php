<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- FAVICON (Agar logo muncul di Tab Browser) -->
    <link rel="shortcut icon" href="{{ asset('images/logo.jpg') }}" type="image/x-icon">

    <title>DelShoope - Belanja Cerdas, Hidup Berkualitas</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* 1. ANIMASI FLOATING (UNTUK GAMBAR KERANJANG) */
        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-float-delayed {
            animation: float 5s ease-in-out infinite 1s;
            /* Delay sedikit agar tidak barengan */
        }

        /* 2. ANIMASI BACKGROUND BLOBS */
        @keyframes moveBlob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .blob {
            animation: moveBlob 10s infinite ease-in-out;
        }

        /* 3. ANIMASI TEKS MUNCUL */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
            opacity: 0;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.3s;
        }

        .delay-300 {
            animation-delay: 0.5s;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 overflow-x-hidden selection:bg-blue-200">

    <!-- BACKGROUND ANIMATION (Hiasan Latar) -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 blob"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 blob animate-float-delayed"></div>
    </div>

    <!-- NAVBAR (Glassmorphism) -->
    <nav class="fixed w-full z-50 top-0 transition-all duration-300 bg-white/80 backdrop-blur-md border-b border-white/20 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">

                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-3 cursor-pointer group">
                    <div class="h-10 w-10 bg-blue-50 rounded-lg flex items-center justify-center border border-blue-100 group-hover:rotate-6 transition-transform">
                        <img src="{{ asset('images/logo.jpg') }}" alt="DelShoope" class="h-full w-full object-contain rounded-md">
                    </div>
                    <span class="font-bold text-2xl bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">DelShoope</span>
                </div>

                <!-- Menu Login/Register -->
                <div class="flex items-center space-x-3 sm:space-x-4">
                    @if (Route::has('login'))
                    @auth
                    <!-- Tombol Dashboard jika sudah login -->
                    @if(Auth::user()->is_admin == 1)
                    <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 rounded-full bg-blue-50 text-blue-600 font-semibold text-sm hover:bg-blue-100 transition-all">Dashboard Admin</a>
                    @else
                    <a href="{{ route('user.dashboard') }}" class="px-5 py-2.5 rounded-full bg-blue-50 text-blue-600 font-semibold text-sm hover:bg-blue-100 transition-all">Dashboard</a>
                    @endif
                    @else
                    <!-- Tombol Login & Register -->
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors px-3 py-2">Masuk</a>

                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="hidden sm:inline-flex px-6 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-full shadow-lg shadow-blue-500/30 hover:bg-blue-700 hover:-translate-y-0.5 transition-all">
                        Daftar Sekarang
                    </a>
                    @endif
                    @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <main class="relative pt-32 pb-16 sm:pt-40 sm:pb-24 lg:pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            <div class="lg:grid lg:grid-cols-12 lg:gap-16 items-center">

                <!-- KOLOM KIRI: TEKS (Tipografi Responsif) -->
                <div class="lg:col-span-6 text-center lg:text-left mb-12 lg:mb-0">

                    <!-- Badge Kecil -->
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-50 border border-blue-100 text-blue-600 font-semibold text-xs uppercase tracking-wide mb-6 fade-in-up">
                        <span class="w-2 h-2 bg-blue-500 rounded-full mr-2 animate-pulse"></span>
                        Platform Belanja No.1 di IT Del
                    </div>

                    <!-- Judul Besar -->
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 leading-tight mb-6 fade-in-up delay-100">
                        Belanja Cerdas <br>
                        <span class="bg-gradient-to-r from-blue-600 to-indigo-500 bg-clip-text text-transparent">Hidup Berkualitas</span>
                    </h1>

                    <!-- Teks Ajakan (Request Anda) -->
                    <p class="text-lg sm:text-xl text-slate-600 mb-8 leading-relaxed fade-in-up delay-200">
                        "Ayo berbelanja di <span class="font-bold text-blue-600">DelShoope</span> dengan produk menarik, harga mahasiswa, dan kemudahan transaksi dalam satu genggaman."
                    </p>

                    <!-- Tombol Call to Action -->
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 fade-in-up delay-300">
                        @auth
                        <a href="{{ Auth::user()->is_admin == 1 ? route('admin.dashboard') : route('user.dashboard') }}"
                            class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl shadow-xl shadow-blue-500/30 hover:shadow-2xl hover:-translate-y-1 transition-all flex items-center justify-center gap-2 group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Mulai Belanja
                        </a>
                        @else
                        <a href="{{ route('register') }}"
                            class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl shadow-xl shadow-blue-500/30 hover:shadow-2xl hover:-translate-y-1 transition-all flex items-center justify-center gap-2">
                            Daftar Gratis
                        </a>
                        <a href="{{ route('login') }}"
                            class="w-full sm:w-auto px-8 py-4 bg-white text-slate-700 font-bold rounded-xl shadow-md hover:shadow-lg border border-slate-100 hover:-translate-y-1 transition-all">
                            Masuk Akun
                        </a>
                        @endauth
                    </div>
                </div>
                <!-- KOLOM KANAN: ILUSTRASI DENGAN IKON LEBIH KECIL (Refined) -->
                <div class="lg:col-span-6 relative fade-in-up delay-300 mt-12 lg:mt-0">

                    <!-- Lingkaran Cahaya Latar -->
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[280px] h-[280px] sm:w-[450px] sm:h-[450px] bg-gradient-to-tr from-blue-100 to-purple-100 rounded-full opacity-60 blur-2xl animate-pulse -z-10"></div>

                    <!-- CONTAINER UTAMA -->
                    <div class="relative z-10 w-full max-w-[320px] sm:max-w-[450px] mx-auto aspect-square flex items-center justify-center">

                        <!-- GAMBAR UTAMA -->
                        <img src="https://cdni.iconscout.com/illustration/premium/thumb/online-shopping-illustration-download-in-svg-png-gif-file-formats--ecommerce-trolley-cart-apps-marketplace-pack-e-commerce-illustrations-3696884.png"
                            alt="Shopping Illustration"
                            class="relative z-10 w-[85%] h-[85%] object-contain drop-shadow-2xl animate-float">

                        <!-- ==== IKON-IKON MELAYANG (Versi Lebih Kecil) ==== -->

                        <!-- 1. TOPI (Kiri Atas) -->
                        <div class="absolute -top-2 left-0 sm:top-2 sm:-left-4 z-20 animate-float-reverse">
                            <!-- Ukuran: HP w-9 (36px), Laptop w-14 (56px) -->
                            <div class="w-9 h-9 sm:w-14 sm:h-14 bg-white rounded-xl shadow-lg border border-slate-100 flex items-center justify-center transform -rotate-6 hover:scale-110 transition-transform duration-300">
                                <span class="text-lg sm:text-2xl">🧢</span>
                            </div>
                        </div>

                        <!-- 2. BAJU (Kanan Atas) -->
                        <div class="absolute -top-4 right-4 sm:-top-6 sm:right-2 z-20 animate-float-slow">
                            <!-- Ukuran: HP w-10 (40px), Laptop w-16 (64px) -->
                            <div class="w-10 h-10 sm:w-16 sm:h-16 bg-white rounded-xl shadow-lg border border-slate-100 flex items-center justify-center transform rotate-6 hover:scale-110 transition-transform duration-300">
                                <span class="text-xl sm:text-3xl">👕</span>
                            </div>
                        </div>

                        <!-- 3. KERANJANG BELANJA (Kanan Tengah - Highlight) -->
                        <!-- Dibuat sedikit lebih besar dari topi/baju, tapi tetap ringkas -->
                        <div class="absolute top-1/2 -right-3 sm:-right-8 -translate-y-1/2 z-30 animate-wiggle">
                            <div class="w-12 h-12 sm:w-20 sm:h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-lg shadow-blue-500/30 border-2 sm:border-4 border-white flex items-center justify-center transform rotate-3 hover:scale-110 transition-transform duration-300">
                                <span class="text-xl sm:text-4xl drop-shadow-md">🛒</span>
                            </div>
                        </div>

                        <!-- 4. DASI (Kiri Bawah) -->
                        <div class="absolute bottom-10 -left-1 sm:bottom-12 sm:-left-6 z-20 animate-float">
                            <!-- Ukuran: HP w-9 (36px), Laptop w-14 (56px) -->
                            <div class="w-9 h-9 sm:w-14 sm:h-14 bg-white rounded-xl shadow-lg border border-slate-100 flex items-center justify-center transform -rotate-12 hover:scale-110 transition-transform duration-300">
                                <span class="text-lg sm:text-2xl">👔</span>
                            </div>
                        </div>

                        <!-- 5. SEPATU (Kanan Bawah) -->
                        <div class="absolute bottom-0 right-6 sm:bottom-2 sm:right-2 z-20 animate-float-reverse">
                            <!-- Ukuran: HP w-9 (36px), Laptop w-14 (56px) -->
                            <div class="w-9 h-9 sm:w-14 sm:h-14 bg-white rounded-xl shadow-lg border border-slate-100 flex items-center justify-center transform rotate-12 hover:scale-110 transition-transform duration-300">
                                <span class="text-lg sm:text-2xl">👟</span>
                            </div>
                        </div>

                        <!-- Bayangan Bawah -->
                        <div class="absolute bottom-4 sm:bottom-0 left-1/2 -translate-x-1/2 w-24 sm:w-40 h-3 bg-black/10 blur-lg rounded-[100%] animate-pulse -z-10"></div>
                    </div>
                </div>
            </div>
        </div>

        </div>
        </div>
    </main>

    <!-- FOOTER SIMPLE -->
    <footer class="bg-white border-t border-slate-100 py-8 relative z-10">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-slate-500 text-sm">
                &copy; {{ date('Y') }} <span class="font-bold text-blue-600">DelShoope</span>. Institut Teknologi Del.
                <br class="sm:hidden"> All rights reserved.
            </p>
        </div>
    </footer>

</body>

</html>