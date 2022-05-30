<?php

namespace App\Http\Middleware;

use Closure;

class IsOperator
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
        if (!auth()->user()->is_operator && !auth()->user()->is_admin) {
            abort(403);
        }

        // dd($request->method() == 'GET' && $request->pathInfo != '/operator/');
        // if( $request->method() == 'GET' && $request->path() != 'operator' ) {
        //     return redirect('/operator/');
        // }

        return $next($request);
    }
}
