<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; // Pastikan Model Order diimport

class AdminOrderController extends Controller
{
    /**
     * Menampilkan Daftar Pesanan (Filter & Search)
     */
    public function index(Request $request)
    {
        // 1. Mulai Query Order + Relasi User
        // with('user') agar tidak berat (N+1 Problem) saat ambil nama user
        // withCount('items') untuk menghitung jumlah barang tanpa ambil detailnya dulu
        $query = Order::with('user')->withCount('items')->latest();

        // 2. Filter Pencarian Nama User
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->whereHas('user', function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%");
            });
        }

        // 3. Filter Status Order
        if ($request->has('status') && $request->status != '') {
            $query->where('order_status', $request->status);
        }

        // 4. Filter Tanggal
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('created_at', $request->date);
        }

        // 5. Ambil data dengan Pagination (10 per halaman)
        $orders = $query->paginate(10);

        // 6. Tampilkan View
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Menampilkan Detail Pesanan
     */
    public function show($id)
    {
        // Ambil order berdasarkan ID
        // Muat relasi 'user', 'items', dan 'items.product' (untuk nama produk)
        $order = Order::with(['user', 'items.product'])->findOrFail($id);

        // Tampilkan View Detail (Pastikan Anda nanti membuat file view ini)
        return view('admin.orders.show', compact('order'));
    }
}
