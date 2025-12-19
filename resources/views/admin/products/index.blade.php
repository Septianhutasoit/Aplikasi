@extends('admin.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl min-h-screen">

    <!-- Header & Action -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">📦 Daftar Produk</h1>
            <p class="text-slate-500 mt-1 text-sm">Manajemen inventaris, stok, dan harga produk.</p>
        </div>

        <a href="{{ route('admin.products.create') }}"
            class="group bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 px-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2 transform hover:-translate-y-0.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Produk</span>
        </a>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <div class="bg-emerald-100 p-2 rounded-full">
                <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <p class="font-medium text-sm">{{ session('success') }}</p>
        </div>
        <button @click="show = false" class="text-emerald-400 hover:text-emerald-700 transition">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    @endif

    <!-- Main Content Card -->
    <div class="bg-white border border-slate-200 shadow-xl shadow-slate-200/60 rounded-2xl overflow-hidden">

        <!-- Toolbar: Search & Filter -->
        <div class="p-5 border-b border-slate-100 bg-slate-50/30 flex flex-col sm:flex-row justify-between items-center gap-4">

            <!-- SEARCH BAR YANG DIPERBAIKI -->
            <form action="{{ route('admin.products.index') }}" method="GET" class="w-full sm:w-96 relative group">
                <div class="relative">
                    <!-- Ikon Pencarian -->
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    <!-- Input Field -->
                    <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="block w-full pl-10 pr-10 py-2.5 border border-slate-300 rounded-xl leading-5 bg-white placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150 ease-in-out sm:text-sm shadow-sm"
                        placeholder="Cari produk berdasarkan nama, SKU...">

                    <!-- Tombol Reset (Muncul jika ada pencarian) -->
                    @if(request('search'))
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <a href="{{ route('admin.products.index') }}" class="text-slate-400 hover:text-red-500 transition-colors" title="Hapus pencarian">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                    </div>
                    @endif
                </div>
            </form>

            <!-- Total Data Badge -->
            <div class="flex items-center gap-2 text-sm text-slate-600 bg-white px-3 py-1.5 rounded-lg border border-slate-200 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                </svg>
                <span>Total: <span class="font-bold text-slate-800">{{ $products->total() ?? count($products) }}</span> Item</span>
            </div>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Produk</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider hidden md:table-cell">Detail</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Harga</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Stok</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($products as $product)
                    <tr class="hover:bg-slate-50/80 transition duration-150 ease-in-out group">

                        <!-- Info Produk & Gambar -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-14 w-14 relative overflow-hidden rounded-xl border border-slate-200 shadow-sm group-hover:shadow-md transition-all">
                                    @if(is_array($product->image) && count($product->image) > 0)
                                    <img class="h-full w-full object-cover transform group-hover:scale-110 transition-transform duration-500" src="{{ asset('storage/' . $product->image[0]) }}" alt="{{ $product->name }}">
                                    @elseif(is_string($product->image) && $product->image != '')
                                    <img class="h-full w-full object-cover transform group-hover:scale-110 transition-transform duration-500" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                    @else
                                    <div class="h-full w-full bg-slate-50 flex items-center justify-center text-slate-300">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">{{ $product->name }}</div>
                                    <div class="text-xs text-slate-500 mt-0.5 font-mono">ID: #{{ $product->id }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Deskripsi (Hidden on Mobile) -->
                        <td class="px-6 py-4 hidden md:table-cell align-middle">
                            <div class="text-sm text-slate-500 max-w-xs truncate">
                                {{ Str::limit($product->description, 50) ?? '-' }}
                            </div>
                        </td>

                        <!-- Harga -->
                        <td class="px-6 py-4 whitespace-nowrap align-middle">
                            <div class="text-sm font-semibold text-slate-700">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                        </td>

                        <!-- Stok Badge -->
                        <td class="px-6 py-4 whitespace-nowrap text-center align-middle">
                            @if($product->stock == 0)
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-600 border border-red-200">
                                Habis
                            </span>
                            @elseif($product->stock < 10)
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-amber-100 text-amber-600 border border-amber-200">
                                Sisa {{ $product->stock }}
                                </span>
                                @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-emerald-100 text-emerald-600 border border-emerald-200">
                                    {{ $product->stock }} Unit
                                </span>
                                @endif
                        </td>

                        <!-- Aksi Buttons -->
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium align-middle">
                            <div class="flex items-center justify-end gap-2 opacity-80 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                    class="p-2 bg-white text-indigo-600 rounded-lg hover:bg-indigo-50 border border-slate-200 hover:border-indigo-200 transition-all shadow-sm"
                                    title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="p-2 bg-white text-rose-600 rounded-lg hover:bg-rose-50 border border-slate-200 hover:border-rose-200 transition-all shadow-sm"
                                        onclick="return confirm('Hapus produk {{ $product->name }}?')"
                                        title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <!-- Empty State Modern -->
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="bg-slate-50 p-4 rounded-full mb-3">
                                    <svg class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-slate-900 font-medium text-lg">Data tidak ditemukan</h3>
                                <p class="text-slate-500 text-sm mt-1 max-w-xs mx-auto">
                                    @if(request('search'))
                                    Tidak ada produk yang cocok dengan pencarian "<span class="font-bold text-slate-800">{{ request('search') }}</span>".
                                    @else
                                    Belum ada data produk yang ditambahkan ke sistem.
                                    @endif
                                </p>
                                @if(request('search'))
                                <a href="{{ route('admin.products.index') }}" class="mt-4 px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 text-sm hover:bg-slate-50 hover:text-indigo-600 transition font-medium">
                                    Reset Pencarian
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer / Pagination -->
        @if(method_exists($products, 'links') && $products->hasPages())
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
            {{ $products->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection