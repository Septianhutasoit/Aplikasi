<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category; // <--- PENTING: Jangan lupa import model Category
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // MENAMPILKAN DAFTAR PRODUK
    public function index(Request $request)
    {
        // Gunakan with('category') agar query lebih efisien (N+1 problem)
        $query = Product::with('category');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    // FORM TAMBAH PRODUK
    public function create()
    {
        // <--- PERBAIKAN: Ambil data kategori untuk dropdown
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // PROSES SIMPAN PRODUK BARU
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id', // <--- PERBAIKAN: Validasi kategori wajib diisi
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required',
            'stock' => 'required|integer',
            'image' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $cleanPrice = (int) str_replace(['Rp', '.', ',', ' '], '', $request->price);

        $imagePaths = [];
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $imagePaths[] = $file->store('products', 'public');
            }
        }

        Product::create([
            'category_id' => $request->category_id, // <--- Data kategori disimpan
            'name' => $request->name,
            'description' => $request->description,
            'price' => $cleanPrice,
            'stock' => $request->stock,
            'image' => $imagePaths,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // FORM EDIT PRODUK
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        // <--- PERBAIKAN: Kita butuh data kategori juga saat mode Edit
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    // PERBAIKAN LOGIKA UPDATE
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id', // <--- PERBAIKAN: Validasi kategori saat update
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required',
            'stock' => 'required|integer',
            'image.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // 2. Ambil gambar lama
        $currentImages = $product->image ?? [];
        if (!is_array($currentImages)) {
            $currentImages = $currentImages ? [$currentImages] : [];
        }

        // 3. LOGIKA HAPUS GAMBAR TERTENTU
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageToDelete) {
                if (Storage::disk('public')->exists($imageToDelete)) {
                    Storage::disk('public')->delete($imageToDelete);
                }
                if (($key = array_search($imageToDelete, $currentImages)) !== false) {
                    unset($currentImages[$key]);
                }
            }
            $currentImages = array_values($currentImages);
        }

        // 4. LOGIKA TAMBAH GAMBAR BARU
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $path = $file->store('products', 'public');
                $currentImages[] = $path;
            }
        }

        // 5. Bersihkan Harga
        $cleanPrice = (int) str_replace(['Rp', '.', ',', ' '], '', $request->price);

        // 6. Update Database
        $product->update([
            'category_id' => $request->category_id, // <--- PERBAIKAN: Update kategori
            'name' => $request->name,
            'description' => $request->description,
            'price' => $cleanPrice,
            'stock' => $request->stock,
            'image' => $currentImages,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // DELETE PRODUK
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $images = $product->image;

        if ($images) {
            if (is_array($images)) {
                foreach ($images as $img) {
                    if (Storage::disk('public')->exists($img)) {
                        Storage::disk('public')->delete($img);
                    }
                }
            } elseif (is_string($images)) {
                if (Storage::disk('public')->exists($images)) {
                    Storage::disk('public')->delete($images);
                }
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }

    public function show($id)
    {
        $product = Product::with(['reviews.user', 'category'])->findOrFail($id);
        return view('product.show', compact('product'));
    }
}
