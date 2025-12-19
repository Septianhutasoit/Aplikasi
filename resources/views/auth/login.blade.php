<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DelShoope</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/logo.jpg') }}" type="image/x-icon">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* 1. ANIMASI BACKGROUND BERGERAK */
        @keyframes float {
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
            animation: float 7s infinite ease-in-out;
        }

        .delay-blob {
            animation-delay: 2s;
        }

        /* 2. ANIMASI FORM MUNCUL */
        @keyframes slideUpFade {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-enter {
            animation: slideUpFade 0.6s ease-out forwards;
            opacity: 0;
        }

        /* Delay untuk efek bertingkat */
        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }

        .delay-400 {
            animation-delay: 0.4s;
        }
    </style>
</head>

<body class="relative bg-slate-100 min-h-screen flex items-center justify-center p-4 overflow-hidden">

    <!-- BACKGROUND ANIMATION (Sama dengan Register) -->
    <div class="absolute top-0 left-0 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-2xl opacity-30 blob -translate-x-10 -translate-y-10"></div>
    <div class="absolute bottom-0 right-0 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-2xl opacity-30 blob delay-blob translate-x-10 translate-y-10"></div>

    <!-- MAIN CARD -->
    <!-- Lebar max-w-lg agar konsisten dengan halaman Daftar -->
    <div class="relative w-full max-w-lg bg-white/90 backdrop-blur-sm rounded-2xl shadow-2xl border border-white/50 overflow-hidden animate-enter">

        <div class="p-8">

            <!-- HEADER COMPACT -->
            <div class="flex items-center gap-4 mb-6 border-b border-slate-200/60 pb-5 animate-enter delay-100">
                <div class="group h-16 w-16 flex-shrink-0 bg-white rounded-2xl flex items-center justify-center p-2 shadow-sm border border-slate-100 transition-transform duration-500 hover:rotate-3">
                    <img src="{{ asset('images/logo.jpg') }}"
                        alt="Logo"
                        class="h-full w-full object-contain rounded-xl transition-transform duration-300 group-hover:scale-110">
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Selamat Datang</h2>
                    <p class="text-sm text-slate-500">Masuk untuk melanjutkan belanja</p>
                </div>
            </div>

            <!-- Error Message -->
            @if ($errors->any())
            <div class="mb-5 animate-enter delay-200">
                <div class="bg-red-50 border-l-4 border-red-500 text-red-600 px-4 py-3 rounded-xl text-sm flex items-start shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 mt-0.5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <span class="font-bold">Login Gagal:</span> Periksa kembali email & password Anda.
                    </div>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5 animate-enter delay-200">
                @csrf

                <!-- Email -->
                <div class="group">
                    <label class="block text-xs font-bold text-slate-500 mb-1 ml-1 uppercase tracking-wider transition-colors group-focus-within:text-blue-600">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-5 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 placeholder-slate-400
                               focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 
                               outline-none transition-all duration-300 transform focus:scale-[1.01]"
                        placeholder="Masukkan email Anda">
                </div>

                <!-- Password -->
                <div class="group">
                    <div class="flex justify-between items-center mb-1 ml-1">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider transition-colors group-focus-within:text-blue-600">Password</label>
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs font-bold text-blue-600 hover:text-indigo-600 transition-colors">
                            Lupa Password?
                        </a>
                        @endif
                    </div>
                    <input type="password" name="password" required
                        class="w-full px-5 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 placeholder-slate-400
                               focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 
                               outline-none transition-all duration-300 transform focus:scale-[1.01]"
                        placeholder="••••••••">
                </div>

                <!-- Checkbox Remember Me -->
                <div class="flex items-center">
                    <label class="inline-flex items-center cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 bg-gray-50 transition-colors">
                        <span class="ml-2 text-sm text-slate-600 group-hover:text-slate-800 transition-colors">Ingat saya di perangkat ini</span>
                    </label>
                </div>

                <!-- Button -->
                <div class="pt-2 animate-enter delay-300">
                    <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 transition-all duration-300 transform hover:-translate-y-1 active:scale-95">
                        Masuk Sekarang
                    </button>
                </div>
            </form>

            <!-- Footer Links -->
            <div class="mt-8 flex items-center justify-between text-sm animate-enter delay-400 border-t border-slate-100 pt-5">
                <a href="{{ route('home') }}" class="group flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                    <span class="mr-1 transition-transform duration-300 group-hover:-translate-x-1">&larr;</span>
                    Beranda
                </a>
                <p class="text-slate-500">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-indigo-600 transition-colors underline decoration-2 decoration-transparent hover:decoration-indigo-600">
                        Daftar
                    </a>
                </p>
            </div>

        </div>
    </div>

    <!-- Hak Cipta di luar card -->
    <p class="absolute bottom-4 text-xs text-slate-400 opacity-80 animate-enter delay-400">&copy; {{ date('Y') }} DelShoope. All rights reserved.</p>

</body>

</html>