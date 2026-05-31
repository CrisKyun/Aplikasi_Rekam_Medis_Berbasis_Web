<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperadminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('user_id') || session('user_role') != 1) {
            return redirect('/dokter/dashboard')->with('error', 'Akses hanya untuk superadmin.');
        }

        return $next($request);
    }
}
