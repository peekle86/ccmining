<?php

namespace App\Http\Middleware;

use App\Models\RefStat;
use Closure;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StoreReferralCode
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
        $response = $next($request);
        if ($request->get('ref')){

            if( !session('ref_code') ) {
                session()->put('ref_code', $request->get('ref'));

                $stat = RefStat::where('code', session('ref_code'))->whereDate('created_at', Carbon::today())->first();

                if( !$stat ) {
                    $stat = RefStat::create([
                        'code' =>  session('ref_code'),
                        'count' => 0
                    ]);
                }

                $stat->increment('count');
            }

            $referral = User::whereRef($request->get('ref'))->first();
            if( $referral ) {
                $response->cookie('ref', $referral->id, (7 * 24 * 60));
            }

        }

        return $response;
    }
}
