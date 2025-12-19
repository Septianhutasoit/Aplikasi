@extends('admin.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="p-6">
    {{-- Tombol Kembali --}}
    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-6">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali ke Daftar
    </a>

    <div class="flex flex-col md:flex-row gap-6">
        {{-- KARTU INFO PESANAN --}}
        <div class="w-full md:w-1/3">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-bold border-b pb-3 mb-4">Info Pesanan</h3>

                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-gray-500 block">No Pesanan</span>
                        <span class="font-mono font-bold text-gray-800">{{ $order->order_number }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Pembeli</span>
                        {{-- Gunakan ?? untuk jaga-jaga jika user dihapus --}}
                        <span class="font-semibold">{{ $order->user->name ?? 'User Tidak Ditemukan' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Tanggal</span>
                        <span>{{ $order->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Status Pesanan</span>
                        <span class="inline-block px-2 py-1 rounded text-xs font-bold mt-1
                            {{ $order->order_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $order->order_status == 'process' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $order->order_status == 'done' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $order->order_status == 'cancel' ? 'bg-red-100 text-red-800' : '' }}
                        ">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABEL PRODUK --}}
        <div class="w-full md:w-2/3">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-4 bg-gray-50 border-b flex justify-between items-center">
                    <h3 class="font-bold text-gray-700">Daftar Produk</h3>
                    <span class="text-sm text-gray-500">{{ $order->items->count() }} Item</span>
                </div>

                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                        <tr>
                            <th class="p-3 border-b">Produk</th>
                            <th class="p-3 border-b text-center">Qty</th>
                            <th class="p-3 border-b text-right">Harga</th>
                            <th class="p-3 border-b text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach($order->items as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border-b">
                                {{-- PERBAIKAN: Cek jika produk ada --}}
                                <div class="font-medium text-gray-800">
                                    {{ $item->product->name ?? 'Produk Telah Dihapus' }}
                                </div>
                            </td>

                            {{-- PERBAIKAN UTAMA: Gunakan 'qty' bukan 'quantity' --}}
                            <td class="p-3 border-b text-center font-mono">
                                {{ $item->qty }}
                            </td>

                            <td class="p-3 border-b text-right">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </td>

                            <td class="p-3 border-b text-right font-bold text-gray-700">
                                Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="p-4 text-right font-bold text-gray-600">TOTAL PEMBAYARAN</td>
                            <td class="p-4 text-right font-bold text-blue-600 text-lg">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection