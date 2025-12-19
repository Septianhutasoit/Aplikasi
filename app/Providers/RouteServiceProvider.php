<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        //
    }

    public static function home()
    {
        // Jika admin → arahkan ke dashboard admin lama
        if (auth()->check() && auth()->user()->role === 'admin') {
            return '/admin/dashboard';
        }

        // Jika user biasa → ke dashboard user breeze
        return '/dashboard';
    }
}
