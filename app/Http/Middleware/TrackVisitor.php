<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Visitor::create([
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent(),
        'visited_at' => now(),
        'country' => geoip($request->ip())->country ?? 'Unknown', // use torann/geoip
    ]);

    return $next($request);
    }
}
