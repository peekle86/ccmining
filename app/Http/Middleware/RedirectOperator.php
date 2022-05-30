<?php

namespace App\Http\Middleware;

use Closure;

class RedirectOperator
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( auth()->user()->is_admin || auth()->user()->is_operator) {
            return redirect('/operator');
        }

        return $next($request);
    }
}
