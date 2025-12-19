<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class KategoriController extends Controller
{
    public function index($slug)
    {
        // 1. Ambil kategori berdasarkan slug
        $kategori = Category::where('slug', $slug)->firstOrFail();

        // 2. Ambil produk di kategori ini + eager load relasi
        $products = Product::with([
            'orderItems.order',   // buat hitung sold_count tanpa N+1
            'category',           // kalau di view butuh nama kategori
        ])
            ->where('category_id', $kategori->id)
            ->orderBy('created_at', 'desc')   // urut terbaru dulu, bebas kalau mau diubah
            ->get();

        // 3. Ambil semua kategori (buat menu/icon di atas)
        $categories = Category::orderBy('name')->get();

        // 4. Kirim ke view
        return view('user.kategori', [
            'kategori'   => $kategori,
            'products'   => $products,
            'categories' => $categories,
        ]);
    }
}
