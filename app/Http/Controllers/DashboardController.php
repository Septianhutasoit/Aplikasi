<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        // Total penjualan (jumlah payment yang berhasil)
        $totalSales = Payment::where('status', 'success')->sum('amount');

        // Produk terjual (jumlah order)
        $productsSold = Order::sum('quantity'); // asumsikan kolom quantity di order

        // Pelanggan baru bulan ini
        $newCustomers = User::whereMonth('created_at', now()->month)->count();

        // Data aktivitas terbaru (contoh: 5 order terbaru)
        $recentActivities = Order::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalSales',
            'productsSold',
            'newCustomers',
            'recentActivities'
        ));
    }
}
