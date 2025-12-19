@extends('admin.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-5xl">
    <!-- Header Page -->
    <div class="flex flex-col md:flex-row items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit Produk</h1>
            <p class="text-gray-600 mt-1 text-sm">Perbarui detail produk dan kelola gambar galeri.</p>
        </div>
        <a href="{{ route('admin.products.index') }}"
            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
            &larr; Kembali
        </a>
    </div>

    <!-- Form Container -->
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-200">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="p-6 md:p-8 space-y-8">

                <!-- 1. Informasi Produk -->
                <div class="border-b border-gray-200 pb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Dasar</h2>

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Nama Produk -->
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Produk</label>
                            <input type="text" name="name" id="name"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-gray-50 text-gray-900 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm"
                                value="{{ old('name', $product->name) }}" placeholder="Masukkan nama produk..." required>
                            @error('name') <p class="text-red-600 text-sm mt-1 font-medium">* {{ $message }}</p> @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                            <textarea name="description" id="description" rows="5"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-gray-50 text-gray-900 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm resize-none"
                                placeholder="Jelaskan detail produk..." required>{{ old('description', $product->description) }}</textarea>
                            @error('description') <p class="text-red-600 text-sm mt-1 font-medium">* {{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- 2. Harga & Stok -->
                <div class="border-b border-gray-200 pb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Inventaris</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Harga -->
                        <div>
                            <label for="price" class="block text-sm font-bold text-gray-700 mb-2">Harga (Rupiah)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-gray-500 font-bold">Rp</span>
                                </div>
                                <input type="number" name="price" id="price"
                                    class="w-full pl-12 pr-4 py-3 rounded-lg border border-gray-300 bg-gray-50 text-gray-900 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm"
                                    value="{{ old('price', $product->price) }}" required>
                            </div>
                            @error('price') <p class="text-red-600 text-sm mt-1 font-medium">* {{ $message }}</p> @enderror
                        </div>

                        <!-- Stok -->
                        <div>
                            <label for="stock" class="block text-sm font-bold text-gray-700 mb-2">Stok Tersedia</label>
                            <input type="number" name="stock" id="stock"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-gray-50 text-gray-900 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm"
                                value="{{ old('stock', $product->stock) }}" required>
                            @error('stock') <p class="text-red-600 text-sm mt-1 font-medium">* {{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- 3. Galeri Gambar -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Manajemen Gambar</h2>

                    <!-- A. Gambar Lama -->
                    <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 mb-6">
                        <p class="text-sm text-gray-600 mb-4 font-medium flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Gambar Saat Ini (Centang kotak <span class="text-red-600 font-bold">"Hapus"</span> untuk membuang gambar)
                        </p>

                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            @if(is_array($product->image) && count($product->image) > 0)
                            @foreach($product->image as $key => $img)
                            <div class="relative group rounded-lg overflow-hidden bg-white shadow-sm border border-gray-200 transition-all duration-300" id="card-{{ $key }}">
                                <!-- Gambar Thumbnail -->
                                <div class="aspect-square w-full relative">
                                    <img src="{{ asset('storage/' . $img) }}"
                                        class="object-cover w-full h-full transition-all duration-300"
                                        id="img-{{ $key }}" alt="Produk Image">

                                    <!-- Overlay saat akan dihapus -->
                                    <div id="overlay-{{ $key }}" class="hidden absolute inset-0 bg-red-500/80 items-center justify-center flex-col text-white z-10 transition-opacity">
                                        <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        <span class="font-bold text-sm tracking-wider uppercase">Akan Dihapus</span>
                                    </div>
                                </div>

                                <!-- Footer Card (Checkbox) -->
                                <div class="p-3 bg-white border-t border-gray-100">
                                    <label class="flex items-center justify-center w-full cursor-pointer select-none space-x-2">
                                        <input type="checkbox"
                                            name="delete_images[]"
                                            value="{{ $img }}"
                                            id="delete_{{ $key }}"
                                            class="w-5 h-5 text-red-600 border-gray-300 rounded focus:ring-red-500 cursor-pointer"
                                            onchange="toggleImageState({{ $key }})">
                                        <span class="text-sm font-semibold text-gray-600 group-hover:text-red-600 transition">Hapus</span>
                                    </label>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="col-span-full py-6 text-center text-gray-400 italic bg-white rounded-lg border border-dashed border-gray-300">
                                Belum ada gambar yang diupload.
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- B. Upload Baru -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tambah Gambar Baru</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-40 border-2 border-indigo-200 border-dashed rounded-xl cursor-pointer bg-indigo-50 hover:bg-indigo-100 transition duration-300 group">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <div class="p-3 bg-white rounded-full shadow-sm mb-3 group-hover:scale-110 transition-transform">
                                        <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                    </div>
                                    <p class="text-sm text-gray-700 font-medium">Klik untuk upload <span class="text-gray-500 font-normal">atau drag & drop file</span></p>
                                    <p class="text-xs text-gray-400 mt-1">PNG, JPG, JPEG (Max 2MB)</p>
                                </div>
                                <input id="dropzone-file" name="image[]" type="file" multiple class="hidden" onchange="showFileCount(this)" />
                            </label>
                        </div>
                        <p id="file-count-feedback" class="text-sm text-indigo-600 mt-2 font-medium hidden"></p>
                    </div>
                </div>

            </div>

            <!-- Tombol Aksi -->
            <div class="bg-gray-50 px-6 py-5 border-t border-gray-200 flex items-center justify-end gap-3">
                <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 rounded-lg text-gray-700 font-medium bg-white border border-gray-300 hover:bg-gray-100 transition shadow-sm">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5 focus:ring-4 focus:ring-indigo-300">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Script -->
<script>
    // Fungsi untuk mengubah tampilan saat gambar dihapus
    function toggleImageState(id) {
        const checkbox = document.getElementById('delete_' + id);
        const card = document.getElementById('card-' + id);
        const overlay = document.getElementById('overlay-' + id);

        if (checkbox.checked) {
            // Jika dicentang: Tampilkan overlay merah dan border merah
            card.classList.add('ring-2', 'ring-red-500', 'border-red-500');
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
        } else {
            // Jika tidak dicentang: Kembalikan seperti semula
            card.classList.remove('ring-2', 'ring-red-500', 'border-red-500');
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
        }
    }

    // Fungsi untuk menampilkan berapa file yang dipilih
    function showFileCount(input) {
        const feedback = document.getElementById('file-count-feedback');
        if (input.files && input.files.length > 0) {
            feedback.textContent = input.files.length + " file baru dipilih.";
            feedback.classList.remove('hidden');
        } else {
            feedback.classList.add('hidden');
        }
    }
</script>
@endsection