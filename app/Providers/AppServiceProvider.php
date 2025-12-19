<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth; // Tambahan: Untuk cek user login
use App\Models\Cart;    // Tambahan: Pastikan Model Cart sudah ada
use App\Models\Message; // Bawaan kode Anda (biarkan saja jika dipakai fitur lain)

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // LOGIKA UNTUK SHARE DATA KERANJANG KE SEMUA VIEW
        View::composer('*', function ($view) {
            $cartCount = 0;

            // Cek apakah user sedang login
            if (Auth::check()) {
                // Hitung total quantity barang di tabel 'carts' milik user tersebut
                // Contoh: Baju (2) + Celana (1) = Hasilnya 3
                $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
            }

            // Kirim variabel $cartCount ke seluruh halaman (bisa dipanggil di Navbar)
            $view->with('cartCount', $cartCount);
        });
    }
}
