<?php

namespace App\Http\Controllers\Newfront;

use App\Models\Currency;
use Carbon\Carbon;
use App\Models\Setting;

class HomeController
{
    public function index()
    {
        $pending = array();
        $earning = array();
        $ref_earning = array();

        $earn_usd = 0;
        $pend_usd = 0;

        $setting = Setting::first();
        $currencies = Currency::where('id', '!=', 4)->get();
        $user = auth()->user();
        $total_usd = 0;
        $balances = $user->userBalances()->get();
        foreach($balances as $balance) {
            $total_usd += $balance->amount * $balance->currency->in_usd;
        }
        $balance['btc'] = $user->userBalances()->where('currency_id', '=', 1)->first();
        $balance['eth'] = $user->userBalances()->where('currency_id', '=', 2)->first();
        $balance['ltc'] = $user->userBalances()->where('currency_id', '=', 3)->first();
        $balance['usdt'] = $user->userBalances()->where('currency_id', '=', 4)->first();

        $pends = $user->userTransactions()->where('type', 4)->whereIn('status', [1,2])->get();
        foreach( $pends as $pend ) {
            if( !isset($pending[$pend->currency->id]) ) {
                $pending[$pend->currency->id] = 0;
            }
            $pending[$pend->currency->id] += $pend->amount;
            $pend_usd += $pend->amount * $pend->currency->in_usd;
        }

        $earns = $user->userTransactions()->where('type', 3)->where('status', 4)->get();
        //dd($earns);

        // $tmp = $user->userTransactions()->whereIn('type', [3])->where('status', 4)->selectRaw('date(created_at) as date, sum(in_usd) as sum_amount')
        //     ->groupBy('date')
        //     ->orderByRaw('min(created_at) asc')
        //     ->get();

        //dd($tmp);
        foreach( $earns as $earn ) {
            if( !isset($earning[$earn->currency->id]) ) {
                $earning[$earn->currency->id] = 0;
            }
            $earning[$earn->currency->id] += $earn->amount;
            $earn_usd += $earn->currency->in_usd * $earn->amount;
        }

        $ref_earns = $user->userTransactions()->where('type', '5')->where('status', 3)->get();
        foreach( $ref_earns as $earn ) {

            if( !isset($ref_earning[$earn->currency->id]) ) {
                $ref_earning[$earn->currency->id] = 0;
            }
            $ref_earning[$earn->currency->id] += $earn->amount * $earn->currency->in_usd;
        }

        $graph_earn = $this->getGraphEarn(3);
        //dd($graph_earn);

        // $chart_data = array(
        //     "time" => [],
        //     "amount" => []
        // );

        // foreach($tmp as $key => $chart) {
        //     $chart_data['time'][] = $chart->date;
        //     if( $key > 0 ) {
        //         $chart_data['amount'][] = $chart->sum_amount + $chart_data['amount'][$key-1];
        //     } else {
        //         $chart_data['amount'][] = $chart->sum_amount;
        //     }

        // }

        // foreach($earns as $key => $chart) {
        //     $chart_data['time'][] = $chart->created_at->format('Y-m-d');
        //     if( $key > 0 ) {
        //         $chart_data['amount'][] = $chart->amount + $chart_data['amount'][$key-1];
        //     } else {
        //         $chart_data['amount'][] = $chart->amount;
        //     }

        // }

        return view('newfront.dashboard', compact('currencies', 'total_usd', 'earn_usd', 'pend_usd', 'balances', 'balance', 'pending', 'earning', 'user', 'ref_earning', 'setting', 'graph_earn'));
    }
    public function getGraphEarn($month_count = 1) {
        $graph_tmp = auth()->user()->userTransactions()->whereStatus(4)->whereType(3)
        ->whereBetween('created_at', getBetween(auth()->user()->created_at))->get()
        ->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('m-d');
        })->all();
        //ksort($graph_tmp);
        return getGraph($graph_tmp, auth()->user()->created_at, 'in_usd');
    }
}
