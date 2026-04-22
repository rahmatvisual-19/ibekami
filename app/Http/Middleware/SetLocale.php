<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Prioritas: locale dari session (user pilih manual)
        if (session()->has('locale')) {
            app()->setLocale(session('locale'));
        }
        // 2. Fallback: deteksi otomatis dari Accept-Language header
        else {
            $preferred = $request->getPreferredLanguage(['id', 'en']);
            $locale = $preferred ?? config('app.fallback_locale', 'id');
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
