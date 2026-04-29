<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CacheFullPage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  int  $minutes  Cache duration in minutes (default: 60)
     */
    public function handle(Request $request, Closure $next, int $minutes = 60): Response
    {
        // Hanya cache request GET tanpa query string dan tanpa session flash
        if ($request->method() !== 'GET' || 
            $request->query() || 
            ($request->hasSession() && $request->session()->has('_flash'))) {
            return $next($request);
        }

        // Generate cache key berdasarkan URL dan locale
        $locale = app()->getLocale();
        $cacheKey = 'page.' . $locale . '.' . sha1($request->fullUrl());

        // Cek apakah ada di cache
        if (Cache::has($cacheKey)) {
            $cachedContent = Cache::get($cacheKey);
            
            return response($cachedContent)
                ->header('Content-Type', 'text/html; charset=UTF-8')
                ->header('X-Cache-Status', 'HIT')
                ->header('X-Cache-Key', $cacheKey);
        }

        // Proses request
        $response = $next($request);

        // Simpan ke cache hanya jika response sukses (200)
        if ($response->getStatusCode() === 200 && $response->headers->get('Content-Type', '')->contains('text/html')) {
            Cache::put($cacheKey, $response->getContent(), now()->addMinutes($minutes));
            
            $response->header('X-Cache-Status', 'MISS');
            $response->header('X-Cache-Key', $cacheKey);
        }

        return $response;
    }
}
