<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('user_id')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Pastikan yang akses halaman pasien adalah role 3 (pasien)
        if (session('user_role') != 3) {
            return redirect('/dokter/dashboard');
        }

        return $next($request);
    }
}
