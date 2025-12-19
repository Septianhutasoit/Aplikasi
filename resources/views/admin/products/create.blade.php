@extends('admin.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">

    <!-- Header dengan Ikon -->
    <div class="flex items-center gap-4 mb-8">
        <div class="p-3 bg-indigo-600 rounded-xl shadow-lg shadow-indigo-200">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
        </div>
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Tambah Produk Baru</h1>
            <p class="text-slate-500 text-sm mt-1">Isi formulir di bawah untuk menambahkan produk ke katalog.</p>
        </div>
    </div>

    <!-- Card Form -->
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-slate-100">
        <!-- Progress Bar Hiasan -->
        <div class="h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf

            <div class="space-y-6">

                <!-- 1. Input Nama -->
                <div>
                    <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Nama Produk</label>
                    <div class="relative">
                        <input type="text" name="name" id="name"
                            class="w-full pl-4 pr-4 py-3 rounded-lg border border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm placeholder-slate-400"
                            placeholder="Contoh: Sepatu Lari Nike" value="{{ old('name') }}" required>
                    </div>
                    @error('name') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <!-- 2. Input Kategori (BARU DITAMBAHKAN) -->
                <div>
                    <label for="category_id" class="block text-sm font-bold text-slate-700 mb-2">Kategori Produk</label>
                    <div class="relative">
                        <select name="category_id" id="category_id"
                            class="w-full px-4 py-3 rounded-lg border border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm appearance-none cursor-pointer" required>
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        <!-- Panah Dropdown Custom -->
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    @error('category_id') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <!-- 3. Input Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Produk</label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full px-4 py-3 rounded-lg border border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm resize-none placeholder-slate-400"
                        placeholder="Jelaskan spesifikasi, bahan, dan keunggulan produk..." required>{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <!-- 4. Grid Harga & Stok -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Input Harga -->
                    <div>
                        <label for="price" class="block text-sm font-bold text-slate-700 mb-2">Harga Satuan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-slate-500 font-bold sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="price" id="price"
                                class="w-full pl-12 pr-4 py-3 rounded-lg border border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm placeholder-slate-400"
                                placeholder="0" value="{{ old('price') }}" required>
                        </div>
                        @error('price') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Input Stok -->
                    <div>
                        <label for="stock" class="block text-sm font-bold text-slate-700 mb-2">Stok Awal</label>
                        <input type="number" name="stock" id="stock"
                            class="w-full px-4 py-3 rounded-lg border border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm placeholder-slate-400"
                            placeholder="Jumlah stok" value="{{ old('stock') }}" required>
                        @error('stock') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- 5. Input Gambar -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Gambar Produk</label>

                    <div class="flex flex-col items-center justify-center w-full">
                        <label for="image-upload" class="flex flex-col items-center justify-center w-full h-44 border-2 border-indigo-200 border-dashed rounded-xl cursor-pointer bg-indigo-50 hover:bg-indigo-100 transition duration-300 group">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4">
                                <div class="bg-white p-3 rounded-full shadow-sm mb-3 group-hover:scale-110 transition-transform">
                                    <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <p class="text-sm text-slate-700 font-medium">Klik untuk upload <span class="text-slate-500 font-normal">atau drag & drop</span></p>
                                <p class="text-xs text-slate-400 mt-1">Bisa pilih banyak file sekaligus (JPG, PNG)</p>
                            </div>
                            <input id="image-upload" name="image[]" type="file" multiple class="hidden" onchange="previewFileNames()" />
                        </label>
                    </div>

                    <!-- Tempat Preview Nama File -->
                    <div id="file-list" class="mt-4 flex flex-wrap gap-2 animate-pulse-once"></div>

                    @error('image') <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p> @enderror
                    @error('image.*') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

            </div>

            <hr class="my-8 border-slate-100">

            <!-- Tombol Aksi -->
            <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-3">
                <a href="{{ route('admin.products.index') }}" class="w-full sm:w-auto px-6 py-3 rounded-lg text-slate-600 font-semibold bg-white border border-slate-300 hover:bg-slate-50 hover:text-slate-800 transition text-center shadow-sm">
                    Batal
                </a>
                <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg shadow-indigo-200 hover:shadow-indigo-300 transition transform hover:-translate-y-0.5 focus:ring-4 focus:ring-indigo-300">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Produk
                    </span>
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    function previewFileNames() {
        const input = document.getElementById('image-upload');
        const output = document.getElementById('file-list');
        const files = input.files;

        output.innerHTML = '';
        output.classList.remove('animate-pulse-once');

        if (files.length > 0) {
            for (let i = 0; i < files.length; i++) {
                let badge = document.createElement('div');
                badge.className = "flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100 shadow-sm";
                badge.innerHTML = `
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    ${files[i].name}
                `;
                output.appendChild(badge);
            }
        }
    }
</script>
@endsection