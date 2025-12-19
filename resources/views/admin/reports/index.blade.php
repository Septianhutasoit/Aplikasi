@extends('admin.app')

@php
use Illuminate\Support\Str;
@endphp

@section('content')

<!-- Animasi CSS -->
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeIn .5s ease-in-out;
    }
</style>

<div class="p-6 space-y-8">

    <div class="flex flex-col md:flex-row justify-between items-center animate-fade-in">
        <h1 class="text-3xl font-bold text-gray-800">
            📊 Laporan Penjualan
        </h1>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('admin.reports.index') }}" class="mt-4 md:mt-0">
            <div class="flex items-center space-x-2">
                <label class="text-gray-600 font-medium">Periode:</label>
                <select name="filter"
                    class="border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:outline-none focus:ring focus:ring-blue-300 transition cursor-pointer bg-white"
                    onchange="this.form.submit()">
                    <option value="today" {{ $filter == 'today' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="week" {{ $filter == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                    <option value="month" {{ $filter == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                    <option value="year" {{ $filter == 'year' ? 'selected' : '' }}>Tahun Ini</option>
                </select>
            </div>
        </form>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Total Orders -->
        <div class="bg-white shadow-md rounded-2xl p-6 border border-l-4 border-l-blue-500 hover:shadow-xl transition transform hover:-translate-y-1 animate-fade-in">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 font-medium">Total Transaksi</p>
                    <h2 class="text-4xl font-bold text-gray-800 mt-2">{{ number_format($total_orders) }}</h2>
                </div>
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-400 mt-4">Status: Transaksi dengan pembayaran sukses</p>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white shadow-md rounded-2xl p-6 border border-l-4 border-l-green-500 hover:shadow-xl transition transform hover:-translate-y-1 animate-fade-in" style="animation-delay: 0.1s">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 font-medium">Total Pendapatan</p>
                    <h2 class="text-4xl font-bold text-green-600 mt-2">
                        Rp {{ number_format($total_income, 0, ',', '.') }}
                    </h2>
                </div>
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-400 mt-4">Pemasukan kotor dari pembayaran sukses</p>
        </div>

        <!-- Products Sold -->
        <div class="bg-white shadow-md rounded-2xl p-6 border border-l-4 border-l-purple-500 hover:shadow-xl transition transform hover:-translate-y-1 animate-fade-in" style="animation-delay: 0.2s">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 font-medium">Produk Terjual</p>
                    <h2 class="text-4xl font-bold text-purple-600 mt-2">
                        {{ number_format($products_sold) }} <span class="text-lg text-gray-400 font-normal">Item</span>
                    </h2>
                </div>
                <div class="p-2 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-400 mt-4">Total unit item keluar (berdasarkan order yang terbayar)</p>
        </div>

    </div>

    <!-- Detail Orders Table -->
    <div class="animate-fade-in" style="animation-delay: 0.3s">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">
            🧾 Rincian Transaksi
        </h2>

        <div class="overflow-hidden bg-white border border-gray-200 rounded-xl shadow-md">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-100 text-gray-600 uppercase font-medium border-b">
                        <tr>
                            <th class="px-6 py-4">ID Order</th>
                            <th class="px-6 py-4">Pelanggan</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Item</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4">Pembayaran</th>
                            <th class="px-6 py-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($orders_list as $order)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">#{{ $order->id }}</td>

                            <td class="px-6 py-4 text-gray-700">
                                {{ $order->user->name ?? 'Guest' }} <br>
                                <span class="text-xs text-gray-400">{{ $order->user->email ?? '-' }}</span>
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $order->created_at->format('d M Y') }} <br>
                                <span class="text-xs text-gray-400">{{ $order->created_at->format('H:i') }} WIB</span>
                            </td>

                            {{-- ITEM --}}
                            <td class="px-6 py-4 text-gray-600">
                                @forelse($order->items as $item)
                                <div class="flex items-center gap-3 mb-2">
                                    @php
                                    $product = $item->product;
                                    @endphp

                                    @if($product)
                                    <div class="w-12 h-12 rounded overflow-hidden border bg-gray-100 flex-shrink-0">
                                        @php
                                        $img = null;

                                        if (is_array($product->image) && count($product->image) > 0) {
                                        $img = $product->image[0];
                                        } elseif (is_string($product->image) && $product->image !== '') {
                                        $img = $product->image;
                                        }
                                        @endphp

                                        @if($img)
                                        <img src="{{ asset('storage/' . $img) }}"
                                            alt="{{ $product->name }}"
                                            class="w-full h-full object-cover">
                                        @else
                                        <img src="https://via.placeholder.com/80?text=No+Image"
                                            alt="No Image"
                                            class="w-full h-full object-cover">
                                        @endif
                                    </div>

                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold text-gray-800">
                                            {{ $product->name }}
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            Qty: {{ $item->qty }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </span>
                                        @if(!is_null($item->subtotal ?? null))
                                        <span class="text-xs text-gray-500">
                                            Subtotal: Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </span>
                                        @endif
                                    </div>
                                    @else
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold text-gray-800">
                                            Produk tidak ditemukan
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            Qty: {{ $item->qty }}
                                        </span>
                                    </div>
                                    @endif
                                </div>
                                @empty
                                <span class="text-xs text-gray-400">Tidak ada item</span>
                                @endforelse

                                <div class="mt-1 text-xs text-gray-500">
                                    Total item: {{ $order->items->sum('qty') }} pcs
                                </div>
                            </td>

                            {{-- TOTAL --}}
                            <td class="px-6 py-4 font-bold text-blue-600">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>

                            {{-- PEMBAYARAN --}}
                            <td class="px-6 py-4 text-gray-600">
                                @php
                                $payment = $order->payment;
                                $method = strtolower($payment->payment_method ?? $order->payment_method ?? '');
                                @endphp

                                @if($payment)
                                @if($method === 'cod')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold">
                                    COD
                                </span>
                                @elseif($method === 'qris' || Str::contains($method, 'qris'))
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">
                                    QRIS
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-semibold">
                                    {{ strtoupper($payment->payment_method) }}
                                </span>
                                @endif

                                <div class="text-xs text-gray-400 mt-1">
                                    Status: {{ ucfirst($payment->status) }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    ID: {{ $payment->order_id }}
                                </div>
                                @else
                                <span class="text-xs text-gray-400">
                                    Belum ada pembayaran
                                </span>
                                @endif
                            </td>


                            {{-- STATUS ORDER --}}
                            <td class="px-6 py-4 text-center">
                                @php
                                $statusClass = match(strtolower($order->order_status)) {
                                'completed' => 'bg-green-100 text-green-700 border-green-200',
                                'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                                'shipping' => 'bg-blue-100 text-blue-700 border-blue-200',
                                default => 'bg-gray-100 text-gray-700 border-gray-200'
                                };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $statusClass }}">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-gray-500 bg-gray-50">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-lg font-medium">Belum ada transaksi</p>
                                    <p class="text-sm">Pada periode filter ini belum ada penjualan yang selesai.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination kalau nanti orders_list pakai paginate() --}}
            {{-- <div class="p-4 bg-gray-50 border-t">
                {{ $orders_list->withQueryString()->links() }}
        </div> --}}
    </div>
</div>

</div>
@endsection