<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check of de gebruiker ingelogd is, en of ze de admin rol hebben.
        if(Auth::check() && Auth::user()->role === 1){
            return $next($request);
        }
        // Geen admin? Geen toegang.
        abort(403, 'GEEN TOEGANG!');
    }
}
