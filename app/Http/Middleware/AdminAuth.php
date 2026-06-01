<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah session admin_login ada
        if (!session('admin_login')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        return $next($request);
    }
}