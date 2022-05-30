<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotVerifiedRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if( ! $user->verified ) {
            return redirect()->route('newfront.profile')->with('error', trans('dashboard._your_email_n_verif'));
        }
        return $next($request);
    }
}
