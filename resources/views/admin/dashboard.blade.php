@extends('admin.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">🏠 Dashboard Delshoop</h1>

    {{-- Kartu Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        @php
        $cardData = [
        [
        'title' => 'Total Penjualan',
        'value' => 'Rp ' . number_format($totalSales,0,',','.'),
        'description' => 'Total penjualan dari semua produk.',
        'icon' => 'fas fa-money-bill-wave',
        'color' => 'blue',
        'link' => route('admin.orders.index'),
        ],
        [
        'title' => 'Produk Terjual',
        'value' => $productsSold,
        'description' => 'Jumlah total produk yang berhasil dijual.',
        'icon' => 'fas fa-box-open',
        'color' => 'green',
        'link' => route('admin.payments.index'),
        ],
        [
        'title' => 'Pelanggan Baru',
        'value' => $newCustomers,
        'description' => 'Jumlah pelanggan baru bulan ini.',
        'icon' => 'fas fa-user-plus',
        'color' => 'yellow',
        'link' => route('admin.users.index'),
        ],
        ];
        @endphp

        @foreach ($cardData as $card)
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 transition-transform transform hover:scale-105 duration-300 flex flex-col justify-between h-full">
            <div class="p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">{{ $card['title'] }}</h3>
                    <i class="{{ $card['icon'] }} text-3xl text-{{ $card['color'] }}-500"></i>
                </div>
                <p class="text-3xl font-bold text-gray-800">{{ $card['value'] }}</p>
                <p class="mt-2 text-sm text-gray-500">{{ $card['description'] }}</p>
            </div>
            <a href="{{ $card['link'] }}" class="block bg-gray-50 px-5 py-3 border-t border-gray-200 text-sm font-medium text-{{ $card['color'] }}-600 hover:bg-gray-100 hover:text-{{ $card['color'] }}-800 transition-colors duration-200 text-center">
                Lihat Detail <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        @endforeach
    </div>

    {{-- Aktivitas Terbaru --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
        <div class="px-5 py-3 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-700">Aktivitas Terbaru</h3>
        </div>
        <ul class="divide-y divide-gray-200">
            @foreach($recentActivities as $activity)
            <li class="px-5 py-4 hover:bg-gray-50 transition-colors duration-200">
                <div class="flex items-center space-x-3">
                    <div class="rounded-full bg-green-50 p-2">
                        <i class="fas fa-shopping-cart text-green-500"></i>
                    </div>
                    <div>
                        <p class="text-gray-700">
                            <span class="font-medium text-gray-800">Pesanan baru diterima:</span>
                            #{{ $activity->id }}
                        </p>
                        <p class="text-gray-500 text-sm">{{ $activity->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection