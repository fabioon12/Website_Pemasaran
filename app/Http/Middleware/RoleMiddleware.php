<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'Silakan login terlebih dahulu.']);
        }

        // Cek apakah user punya salah satu role yang diizinkan
        if (!$user->hasAnyRole($roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        return $next($request);
    }
}
