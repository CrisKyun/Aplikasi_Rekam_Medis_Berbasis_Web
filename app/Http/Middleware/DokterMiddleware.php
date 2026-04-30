<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DokterMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('user_id')) {
            return redirect('/dokter/login');
        }

        if (session('user_role') != 1) {
            return redirect('/')->with('error', 'Akses ditolak.');
        }

        return $next($request);
    }
}
