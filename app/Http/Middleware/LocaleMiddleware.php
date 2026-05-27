<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale')
            ?? $request->cookie('user_locale')
            ?? config('app.locale');

        if (in_array($locale, ['en'])) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
