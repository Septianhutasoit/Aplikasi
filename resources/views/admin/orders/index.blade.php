@extends('admin.app')

@section('title', '🛒Daftar Pesanan')

@section('content')
<div class="p-6">
    {{-- Filter --}}
    <div class="bg-white p-4 rounded-lg shadow mb-5">
        <form class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input
                type="text"
                name="search"
                placeholder="Cari nama pelanggan..."
                class="p-2 border rounded w-full">

            <select name="status" class="p-2 border rounded w-full">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="process">Diproses</option>
                <option value="done">Selesai</option>
                <option value="cancel">Dibatalkan</option>
            </select>

            <input
                type="date"
                name="date"
                class="p-2 border rounded w-full">

            <button class="bg-blue-600 text-white px-4 rounded hover:bg-blue-700">
                Filter
            </button>
        </form>
    </div>

    {{-- Tabel Pesanan --}}
    <div class="bg-white p-4 rounded-lg shadow">
        <table class="min-w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3 border-b">#</th>
                    <th class="p-3 border-b">Nama Pelanggan</th>
                    <th class="p-3 border-b">Produk</th>
                    <th class="p-3 border-b">Total</th>
                    <th class="p-3 border-b">Status</th>
                    <th class="p-3 border-b">Tanggal</th>
                    <th class="p-3 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td class="p-3 border-b">{{ $loop->iteration }}</td>

                    {{-- Perbaikan 1: Sesuaikan dengan relasi di controller (user) --}}
                    <td class="p-3 border-b">{{ $order->user->name ?? 'Guest' }}</td>

                    {{-- Opsional: Menampilkan jumlah item karena di index biasanya tidak menampilkan detail 1 produk --}}
                    <td class="p-3 border-b">{{ $order->items_count ?? $order->items->count() }} Item</td>

                    {{-- Perbaikan 2: Pastikan nama kolom total harga sesuai database (cek apakah total atau total_price) --}}
                    <td class="p-3 border-b">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>

                    <td class="p-3 border-b">
                        <span class="px-2 py-1 rounded 
                @if($order->order_status == 'pending') bg-yellow-200 text-yellow-800
                @elseif($order->order_status == 'process') bg-blue-200 text-blue-800
                @elseif($order->order_status == 'done') bg-green-200 text-green-800
                @else bg-red-200 text-red-800
                @endif
            ">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </td>
                    <td class="p-3 border-b">{{ $order->created_at->format('Y-m-d') }}</td>

                    <td class="p-3 border-b text-center">
                        {{-- PERBAIKAN UTAMA: Route Name --}}
                        {{-- Jika error 'Route not defined', coba ganti 'orders.show' menjadi 'admin.orders.show' --}}
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 hover:underline">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-3 text-center text-gray-500">Belum ada pesanan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection