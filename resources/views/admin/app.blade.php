<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Delshoop</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpeg"> <!-- Ganti type jika format lain -->

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        /* Custom Styling for active link */
        .nav-link.active {
            background-color: #4f46e5;
            color: white;
        }

        .nav-link:hover {
            background-color: #362fabff;
            color: white;
        }

        /* High Contrast Mode */
        .high-contrast {
            background-color: #0d47a1 !important;
            color: #fff !important;
        }

        .high-contrast .bg-white {
            background-color: #1e88e5 !important;
        }

        .high-contrast .text-gray-700 {
            color: #bbdefb !important;
        }

        .high-contrast .text-gray-600 {
            color: #90caf9 !important;
        }

        .high-contrast .border-b {
            border-bottom-color: #1565c0 !important;
        }

        .high-contrast .border-t {
            border-top-color: #1565c0 !important;
        }

        .high-contrast .shadow-lg {
            box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.2), 0 1px 3px -1px rgba(0, 0, 0, 0.12) !important;
        }

        .high-contrast .hover\:bg-indigo-600:hover {
            background-color: #1565c0 !important;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans antialiased" id="app-body">

    <div class="flex h-screen">

        {{-- Sidebar --}}
        <aside class="w-64 bg-white shadow-lg flex flex-col">
            <div class="p-6 border-b flex items-center justify-center">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="mr-3 h-12">
                <h1 class="text-xl font-semibold text-indigo-600">DellShoop</h1>
            </div>
            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-2 rounded-lg font-medium transition-colors duration-200
                {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-md' : 'text-gray-700 hover:bg-indigo-100 hover:text-indigo-700' }}">
                    <i class="fas fa-tachometer-alt mr-3 text-lg"></i>
                    Dashboard
                </a>

                <a href="{{ route('admin.products.index') }}"
                    class="flex items-center px-4 py-2 rounded-lg font-medium transition-colors duration-200
                {{ request()->is('admin/products*') ? 'bg-indigo-600 text-white shadow-md' : 'text-gray-700 hover:bg-indigo-100 hover:text-indigo-700' }}">
                    <i class="fas fa-box-open mr-3 text-lg"></i>
                    Produk
                </a>

                <a href="{{ route('admin.orders.index') }}"
                    class="flex items-center px-4 py-2 rounded-lg font-medium transition-colors duration-200
                text-gray-700 hover:bg-indigo-100 hover:text-indigo-700">
                    <i class="fas fa-shopping-cart mr-3 text-lg"></i> <!-- Ikon Keranjang Belanja -->
                    Pesanan
                </a>


                {{-- Menu Pembayaran --}}
                <a href="{{ route('admin.payments.index') }}"
                    class="flex items-center px-4 py-2 rounded-lg font-medium transition-colors duration-200
           {{ request()->is('admin/payments*') ? 'bg-indigo-600 text-white shadow-md' : 'text-gray-700 hover:bg-indigo-100 hover:text-indigo-700' }}">
                    <i class="fas fa-money-bill-wave mr-3 text-lg"></i>
                    Pembayaran
                    @php
                    // Hitung pembayaran pending untuk notif
                    $pendingPayments = \App\Models\Payment::where('status','pending')->count();
                    @endphp
                    @if($pendingPayments > 0)
                    <span class="ml-auto bg-red-600 text-white text-xs px-2 py-0.5 rounded-full animate-pulse shadow-md">
                        {{ $pendingPayments }}
                    </span>
                    @endif
                </a>

                <a href="{{ route('admin.reports.index') }}"
                    class="flex items-center px-4 py-2 rounded-lg font-medium transition-colors duration-200
                text-gray-700 hover:bg-indigo-100 hover:text-indigo-700">
                    <i class="fas fa-chart-line mr-3 text-lg"></i> <!-- Ikon Grafik Garis (Laporan) -->
                    Laporan
                </a>
                <a href="{{ route('admin.messages.index') }}"
                    class="flex items-center px-4 py-2 rounded-lg font-medium transition-colors duration-200
                {{ request()->is('admin/messages*') ? 'bg-indigo-600 text-white shadow-md' : 'text-gray-700 hover:bg-indigo-100 hover:text-indigo-700' }}">
                    <i class="fas fa-envelope mr-3 text-lg"></i>
                    Pesan
                    @if(isset($newMessages) && $newMessages > 0)
                    <span class="ml-auto bg-red-600 text-white text-xs px-2 py-0.5 rounded-full animate-pulse shadow-md">
                        {{ $newMessages }}
                    </span>
                    @endif
                </a>
                <a href="{{ route('admin.reviews.index') }}"
                    class="flex items-center px-4 py-2 rounded-lg font-medium transition-colors duration-200
          text-gray-700 hover:bg-indigo-100 hover:text-indigo-700">
                    <!-- Ikon Bintang (Lebih cocok untuk Ulasan) -->
                    <i class="fas fa-star mr-3 text-lg"></i>
                    Ulasan Produk
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center px-4 py-2 rounded-lg font-medium transition-colors duration-200 
             {{ request()->routeIs('admin.users.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-indigo-100 hover:text-indigo-700' }}">
                    <!-- Ikon User (Pengguna) -->
                    <i class="fas fa-users mr-3 text-lg"></i>
                    Data Pengguna
                </a>
            </nav>

            <div class="p-4 border-t">
                <!-- Logout Button (Sidebar) -->
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="flex items-center text-red-600 hover:text-red-800 mt-auto p-4 transition-colors duration-200">

                    <!-- Icon Logout -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>

                    <span class="font-medium">Logout</span>
                </a>

                <!-- Form Hidden untuk proses Logout -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </aside>

        {{-- Konten utama --}}
        <main class="flex-1 p-6 overflow-y-auto">
            <header class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800">@yield('title', 'Dashboard/Delshoope')</h2>
                    <p class="text-gray-500 text-sm">Selamat Datang di Sistem Informasi Penjualan DelShoope</p>
                </div>

                <div class="flex items-center space-x-4">

                    <!-- High Contrast Mode Toggle -->
                    <div class="flex items-center">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer" id="highContrastToggle">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                            </div>
                            <span
                                class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">High Contrast</span>
                        </label>
                    </div>

                    <!-- ============================================== -->
                    <!-- BAGIAN PROFIL ADMIN (YANG DIPERBAIKI) -->
                    <!-- ============================================== -->
                    <div class="relative">
                        <!-- Tombol Trigger (Foto & Nama) -->
                        <button id="profile-menu-btn" class="flex items-center focus:outline-none hover:bg-gray-100 p-2 rounded-lg transition-colors">
                            <!-- Nama (Dinamis) -->
                            <span class="text-gray-700 font-semibold mr-3 text-sm">
                                {{ Auth::user()->name }}
                            </span>

                            <!-- Foto Profil -->
                            <img src="{{ asset('images/Jopet.jpg') }}" alt="Admin Foto"
                                class="w-10 h-10 rounded-full object-cover border border-gray-300 shadow-sm">

                            <!-- Panah Kecil -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Menu Dropdown (Tersembunyi Awalnya) -->
                        <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 ring-1 ring-black ring-opacity-5">
                            <!-- Info User -->
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-xs text-gray-500">Login sebagai</p>
                                <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <!-- Tombol Logout Dropdown -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    <!-- ============================================== -->

                </div>
            </header>

            <div>
                @yield('content')
            </div>
        </main>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // 1. LOGIKA HIGH CONTRAST
                const toggle = document.getElementById('highContrastToggle');
                const body = document.getElementById('app-body');

                function toggleHighContrast() {
                    if (body) {
                        body.classList.toggle('high-contrast');
                        localStorage.setItem('highContrast', body.classList.contains('high-contrast'));
                    }
                }

                if (localStorage.getItem('highContrast') === 'true' && body) {
                    body.classList.add('high-contrast');
                    if (toggle) toggle.checked = true;
                }

                if (toggle) {
                    toggle.addEventListener('change', toggleHighContrast);
                }

                // 2. LOGIKA DROPDOWN PROFIL (BARU)
                const profileBtn = document.getElementById('profile-menu-btn');
                const profileDropdown = document.getElementById('profile-dropdown');

                if (profileBtn && profileDropdown) {
                    // Klik tombol buat buka/tutup
                    profileBtn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        profileDropdown.classList.toggle('hidden');
                    });

                    // Klik di luar buat nutup
                    document.addEventListener('click', function(e) {
                        if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
                            profileDropdown.classList.add('hidden');
                        }
                    });
                }
            });
        </script>
</body>

</html>