<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category; // <--- 1. TAMBAHKAN INI (Wajib Import Model)

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // --- TAMBAHAN BARU: AMBIL DATA KATEGORI ---
        // Ini wajib agar menu ikon kategori di dashboard tidak error
        $categories = Category::all();
        // ------------------------------------------

        // 1. Inisialisasi Query Produk
        $query = Product::with('reviews');

        // 2. Logika Pencarian
        if ($request->has('search') && $request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%');
            });
        }

        // 3. Logika Pagination
        $products = $query->latest()->paginate(20);

        // 4. Return ke View
        // Perhatikan: kita menambahkan 'categories' ke dalam compact
        return view('user.dashboard', compact('products', 'categories'));
    }
}
