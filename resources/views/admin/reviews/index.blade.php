@extends('admin.app') {{-- Pastikan layout admin Anda sudah benar --}}

@section('content')
<div class="container mx-auto px-4 py-8">

    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Ulasan Masuk</h1>
            <p class="text-gray-500 mt-1">Pantau feedback dan kepuasan pelanggan Anda.</p>
        </div>
        <div class="mt-4 md:mt-0 bg-blue-600 text-white px-6 py-2 rounded-full shadow-lg flex items-center gap-2">
            <i class="fas fa-star"></i>
            <span class="font-semibold">Total: {{ $reviews->total() }} Ulasan</span>
        </div>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm flex justify-between items-center" role="alert">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2 text-xl"></i>
            <span>{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    {{-- Main Content Card --}}
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">

        {{-- Card Header --}}
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex items-center">
            <div class="bg-amber-100 text-amber-600 p-2 rounded-lg mr-3">
                <i class="fas fa-comments text-lg"></i>
            </div>
            <h2 class="text-lg font-bold text-gray-700">Daftar Ulasan Terbaru</h2>
        </div>

        {{-- Table Wrapper --}}
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Produk</th>
                        <th class="py-3 px-6 text-left">Pelanggan</th>
                        <th class="py-3 px-6 text-left">Rating</th>
                        <th class="py-3 px-6 text-left">Komentar</th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @forelse($reviews as $item)
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-200">

                        {{-- Kolom Produk --}}
                        <td class="py-4 px-6">
                            <div class="flex items-center">
                                <div class="mr-3 relative">
                                    {{-- LOGIKA PERBAIKAN: Cek tipe data gambar --}}
                                    @php
                                    $productImage = optional($item->product)->image;
                                    $finalImage = null;

                                    if ($productImage) {
                                    // Jika datanya Array (banyak gambar), ambil yang pertama [0]
                                    if (is_array($productImage)) {
                                    $finalImage = $productImage[0] ?? null;
                                    }
                                    // Jika datanya String (gambar tunggal/format lama), pakai langsung
                                    else {
                                    $finalImage = $productImage;
                                    }
                                    }
                                    @endphp
                                    <img class="w-12 h-12 rounded-lg object-cover shadow-sm border border-gray-200"
                                        src="{{ $finalImage ? asset('storage/' . $finalImage) : 'https://via.placeholder.com/150' }}"
                                        alt="Produk">
                                </div>
                                <div>
                                    <span class="font-bold text-gray-800 block">{{ Str::limit(optional($item->product)->name ?? 'Produk Dihapus', 25) }}</span>
                                    <span class="text-xs text-gray-500">ID: #{{ $item->product_id }}</span>
                                </div>
                            </div>
                        </td>

                        {{-- Kolom User --}}
                        <td class="py-4 px-6">
                            <div class="flex items-center">
                                <div class="bg-indigo-100 text-indigo-600 w-10 h-10 rounded-full flex items-center justify-center mr-3 font-bold shadow-sm">
                                    {{-- Safe substring logic --}}
                                    {{ substr(optional($item->user)->name ?? 'G', 0, 1) }}
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700 block">{{ optional($item->user)->name ?? 'User Dihapus' }}</span>
                                    <span class="text-xs text-gray-400">{{ $item->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </td>

                        {{-- Kolom Rating --}}
                        <td class="py-4 px-6">
                            <div class="flex items-center bg-yellow-50 w-fit px-3 py-1 rounded-full border border-yellow-100">
                                <div class="flex text-amber-400 text-sm shadow-sm">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <=$item->rating)
                                        <i class="fas fa-star drop-shadow-sm"></i>
                                        @else
                                        <i class="far fa-star text-gray-300"></i>
                                        @endif
                                        @endfor
                                </div>
                                <span class="ml-2 font-bold text-gray-600 text-xs">({{ $item->rating }}.0)</span>
                            </div>
                        </td>

                        {{-- Kolom Komentar --}}
                        <td class="py-4 px-6">
                            <div class="bg-gray-50 p-3 rounded-xl border border-gray-100 text-gray-600 italic relative max-w-xs whitespace-normal">
                                <i class="fas fa-quote-left absolute -top-2 -left-2 text-gray-300 text-xs"></i>
                                "{{ Str::limit($item->comment, 80) }}"
                            </div>
                        </td>

                        {{-- Kolom Aksi --}}
                        <td class="py-4 px-6 text-center">
                            <form action="{{ route('admin.reviews.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="group bg-red-50 hover:bg-red-500 text-red-500 hover:text-white w-10 h-10 rounded-lg transition-all duration-300 flex items-center justify-center mx-auto shadow-sm" title="Hapus Ulasan">
                                    <i class="fas fa-trash-alt group-hover:scale-110 transition-transform"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <div class="bg-gray-100 p-4 rounded-full mb-3">
                                    <i class="far fa-comment-dots text-4xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-600">Belum ada ulasan</h3>
                                <p class="text-sm">Pelanggan belum memberikan rating pada produk.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer / Pagination --}}
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $reviews->links() }}
        </div>
    </div>
</div>
@endsection