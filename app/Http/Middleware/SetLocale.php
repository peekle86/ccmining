<?php

namespace App\Http\Middleware;

use Closure;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        if (request('language')) {
            session()->put('language', request('language'));
            $language = request('language');
        } elseif (session('language')) {
            $language = session('language');
        } elseif (config('panel.primary_language')) {
            $language = config('panel.primary_language');
        }

        if (isset($language)) {
            app()->setLocale($language);

            if(auth()->user()) {
                auth()->user()->lang = $language;
                auth()->user()->save();
            }
        }

        return $next($request);
    }
}
