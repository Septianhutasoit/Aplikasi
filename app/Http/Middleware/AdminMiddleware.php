<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan cek is_admin, bukan role
        if (Auth::check() && Auth::user()->is_admin == 1) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
