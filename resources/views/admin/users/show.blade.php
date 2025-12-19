@extends('admin.app')

@section('content')
<div class="container mx-auto px-4 py-6">

    <!-- Header: Tombol Kembali & Judul -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.users.index') }}"
                class="p-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Detail Pengguna</h2>
                <p class="text-sm text-gray-500">ID: #{{ $user->id }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- KOLOM KIRI: Profil User -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center relative overflow-hidden">

                <!-- 1. Background Hiasan (Ungu untuk Admin, Biru untuk User) -->
                <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-r {{ ($user->role === 'admin' || $user->email === 'admin@mail.com') ? 'from-purple-700 to-indigo-900' : 'from-blue-400 to-cyan-400' }}"></div>

                <!-- 2. Avatar / Logo Admin -->
                <!-- UBAH BAGIAN INI -->
                <div class="relative mt-12 mb-4">
                    <div class="w-24 h-24 mx-auto bg-white rounded-full p-1 shadow-md">

                        {{-- Perbaikan: Sesuaikan email dengan yang ada di screenshot (gmail.com) --}}
                        @if($user->role === 'admin' || $user->email === 'admin@gmail.com')

                        <!-- Pastikan file gambar ada di folder: public/images/saya.jpg -->
                        <img src="{{ asset('images/saya.jpg') }}"
                            alt="Logo Admin"
                            class="w-full h-full object-cover rounded-full"
                            onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=Admin&background=random';"> <!-- Fallback jika gambar tidak ketemu -->

                        @else
                        <!-- KHUSUS USER: Tampilkan Inisial Nama -->
                        <div class="w-full h-full bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-3xl font-bold">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        @endif

                    </div>
                </div>  

                <!-- Info Utama -->
                <h3 class="text-xl font-bold text-gray-800">{{ $user->name }}</h3>
                <p class="text-gray-500 mb-4">{{ $user->email }}</p>

                <!-- 3. Badge Role Dinamis -->
                <div class="mb-6">
                    @if($user->role === 'admin' || $user->email === 'admin@gmail.com')
                    <span class="inline-block px-4 py-1.5 bg-purple-100 text-purple-700 rounded-full text-xs font-bold uppercase tracking-wide border border-purple-200 shadow-sm">
                        FULLSTACK DEVELOPER
                    </span>
                    @else
                    <span class="inline-block px-4 py-1.5 bg-blue-100 text-blue-700 rounded-full text-xs font-bold uppercase tracking-wide border border-blue-200 shadow-sm">
                        CUSTOMER / USER
                    </span>
                    @endif
                </div>

                <!-- Detail Data Diri -->
                <div class="text-left space-y-3 border-t border-gray-100 pt-6">
                    <div class="flex justify-between">
                        <span class="text-gray-500 text-sm">Bergabung</span>
                        <span class="font-medium text-gray-800 text-sm">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 text-sm">Total Order</span>
                        <span class="font-medium text-gray-800 text-sm">{{ $user->orders->count() ?? 0 }} Transaksi</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: Riwayat Pesanan / Aktivitas -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Statistik Mini -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center">
                    <div class="p-3 bg-green-100 text-green-600 rounded-lg mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Pengeluaran</p>
                        <p class="text-lg font-bold text-gray-800">
                            Rp {{ number_format($user->orders->sum('total_price') ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center">
                    <div class="p-3 bg-orange-100 text-orange-600 rounded-lg mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Pesanan Terakhir</p>
                        <!-- Perbaikan Safe Navigation Operator (?->) -->
                        <p class="text-lg font-bold text-gray-800">
                            {{ $user->orders->last()?->created_at?->format('d M Y') ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Tabel Riwayat Pesanan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="font-bold text-gray-700">Riwayat Pesanan Terbaru</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-xs text-gray-500 uppercase border-b border-gray-100">
                                <th class="px-6 py-3">ID Order</th>
                                <th class="px-6 py-3">Tanggal</th>
                                <th class="px-6 py-3">Total</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($user->orders->sortByDesc('created_at')->take(5) as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-mono text-sm text-indigo-600">#{{ $order->id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-sm font-medium">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @if($order->status == 'paid' || $order->status == 'completed' || $order->status == 'success')
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">Lunas</span>
                                    @elseif($order->status == 'pending')
                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-bold">Pending</span>
                                    @else
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-bold">{{ ucfirst($order->status) }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-400 text-xs">-</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                    User ini belum pernah melakukan pemesanan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection