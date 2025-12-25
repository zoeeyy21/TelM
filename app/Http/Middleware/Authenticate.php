<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle($request, Closure $next)
    {
        // Izinkan akses ke halaman login, register, dan home tanpa autentikasi
        if ($request->routeIs('login') || 
        $request->routeIs('register') || 
        $request->is('/')) {
            return $next($request);
        }

        // Jika belum login, redirect ke login dengan flash message
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melanjutkan!');
        }

        return $next($request);
    }
}
