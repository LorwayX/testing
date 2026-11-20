<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Check if user is logged in
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // 2. Strict authorization: block any user with role 'siswa', 'student', or anything not 'admin'
        if (!$user || $user->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak. Pengguna dengan peran siswa tidak memiliki izin akses ke dashboard admin.');
        }

        return $next($request);
    }
}
