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

        // Role 1 (superadmin) dan 2 (staff) boleh akses
        if (!in_array(session('user_role'), [1, 2])) {
            return redirect('/')->with('error', 'Akses ditolak.');
        }

        return $next($request);
    }
}
