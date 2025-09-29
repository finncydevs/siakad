<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SyncApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
{
    // Ambil token dari header request
    $token = $request->header('X-Sync-Token');

    // Bandingkan dengan token yang kita simpan (sebaiknya simpan di .env)
    if ($token !== 'lNoD7qFg1LggLIO') {
        // Jika token salah, tolak akses
        abort(403, 'Unauthorized action.');
    }

    return $next($request);
}
}
