<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'today');

        // 1. Tentukan range waktu (buat filter selain 'today')
        switch ($filter) {
            case 'week':
                $start = Carbon::now()->startOfWeek();
                $end   = Carbon::now()->endOfWeek();
                break;

            case 'month':
                $start = Carbon::now()->startOfMonth();
                $end   = Carbon::now()->endOfMonth();
                break;

            case 'year':
                $start = Carbon::now()->startOfYear();
                $end   = Carbon::now()->endOfYear();
                break;

            case 'today':
            default:
                $start  = Carbon::today();
                $end    = Carbon::today()->endOfDay();
                $filter = 'today';
                break;
        }

        // Base query: relasi & eager loading
        $baseQuery = Order::with(['items.product', 'user', 'payment']);

        if ($filter === 'today') {
            // 🔥 HARI INI:
            // pakai TANGGAL DI TABEL PAYMENTS -> created_at
            // bukan created_at di orders
            $orders = $baseQuery
                ->whereHas('payment', function ($q) {
                    $q->where('status', 'success')
                        ->whereDate('created_at', Carbon::today());  // << DI SINI
                })
                ->get();
        } else {
            // Filter lain: pakai tanggal di orders + payment sukses (ini tadi sudah jalan)
            $orders = $baseQuery
                ->whereBetween('created_at', [$start, $end])
                ->whereHas('payment', function ($q) {
                    $q->where('status', 'success');
                })
                ->get();
        }

        // Ringkasan global
        $total_orders  = $orders->count();
        $total_income  = $orders->sum('total_price');
        $products_sold = $orders->sum(function ($order) {
            return $order->items->sum('qty'); // kolom qty di order_items
        });

        // Kelompokkan berdasarkan metode pembayaran
        $qrisOrders = $orders->filter(function ($order) {
            $method = strtolower(
                optional($order->payment)->payment_method
                    ?? $order->payment_method
                    ?? ''
            );
            return $method === 'qris' || str_contains($method, 'qris');
        });

        $codOrders = $orders->filter(function ($order) {
            $method = strtolower(
                optional($order->payment)->payment_method
                    ?? $order->payment_method
                    ?? ''
            );
            return $method === 'cod';
        });

        $by_method = [
            'qris' => [
                'label'         => 'QRIS',
                'orders'        => $qrisOrders->count(),
                'income'        => $qrisOrders->sum('total_price'),
                'products_sold' => $qrisOrders->sum(
                    fn($o) => $o->items->sum('qty')
                ),
            ],
            'cod'  => [
                'label'         => 'COD',
                'orders'        => $codOrders->count(),
                'income'        => $codOrders->sum('total_price'),
                'products_sold' => $codOrders->sum(
                    fn($o) => $o->items->sum('qty')
                ),
            ],
        ];

        return view('admin.reports.index', [
            'filter'        => $filter,
            'total_orders'  => $total_orders,
            'total_income'  => $total_income,
            'products_sold' => $products_sold,
            'orders_list'   => $orders,
            'by_method'     => $by_method,
        ]);
    }
}
