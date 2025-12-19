<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - DelShoope</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/logo.jpg') }}" type="image/x-icon">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* ANIMASI (Konsisten) */
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

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }
    </style>
</head>

<body class="relative bg-slate-100 min-h-screen flex items-center justify-center p-4 overflow-hidden">

    <!-- BACKGROUND ANIMATION -->
    <div class="absolute top-0 left-0 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-2xl opacity-30 blob -translate-x-10 -translate-y-10"></div>
    <div class="absolute bottom-0 right-0 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-2xl opacity-30 blob delay-blob translate-x-10 translate-y-10"></div>

    <!-- MAIN CARD -->
    <div class="relative w-full max-w-lg bg-white/90 backdrop-blur-sm rounded-2xl shadow-2xl border border-white/50 overflow-hidden animate-enter">

        <div class="p-8">

            <!-- HEADER -->
            <div class="flex items-center gap-4 mb-6 border-b border-slate-200/60 pb-5 animate-enter delay-100">
                <div class="group h-16 w-16 flex-shrink-0 bg-white rounded-2xl flex items-center justify-center p-2 shadow-sm border border-slate-100 transition-transform duration-500 hover:rotate-3">
                    <img src="{{ asset('images/logo.jpg') }}"
                        alt="Logo"
                        class="h-full w-full object-contain rounded-xl transition-transform duration-300 group-hover:scale-110">
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Verifikasi Email</h2>
                    <p class="text-sm text-slate-500">Satu langkah lagi untuk memulai</p>
                </div>
            </div>

            <!-- Description Text -->
            <div class="mb-6 text-sm text-slate-600 leading-relaxed animate-enter delay-100">
                <p class="mb-3">Terima kasih telah mendaftar! 👋</p>
                <p>Sebelum memulai, mohon verifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan ke email Anda. Jika Anda tidak menerima email tersebut, kami dengan senang hati akan mengirimkannya lagi.</p>
            </div>

            <!-- Success Message (Jika link dikirim ulang) -->
            @if (session('status') == 'verification-link-sent')
            <div class="mb-6 animate-enter delay-200">
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-xl text-sm shadow-sm flex items-start">
                    <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Tautan verifikasi baru telah dikirim ke alamat email yang Anda gunakan saat pendaftaran.</span>
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex flex-col-reverse md:flex-row items-center justify-between gap-4 pt-2 animate-enter delay-300">

                <!-- Logout Button (Secondary) -->
                <form method="POST" action="{{ route('logout') }}" class="w-full md:w-auto">
                    @csrf
                    <button type="submit" class="w-full md:w-auto text-sm font-semibold text-slate-500 hover:text-red-600 transition-colors py-2 px-4 rounded-lg hover:bg-slate-50">
                        &larr; Keluar / Logout
                    </button>
                </form>

                <!-- Resend Email Button (Primary) -->
                <form method="POST" action="{{ route('verification.send') }}" class="w-full md:w-auto">
                    @csrf
                    <button type="submit" class="w-full md:w-auto px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 transition-all duration-300 transform hover:-translate-y-1 active:scale-95 text-sm">
                        Kirim Ulang Verifikasi
                    </button>
                </form>

            </div>

        </div>
    </div>

</body>

</html>