<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contract;
use App\Models\HardwareItem;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController
{
    public function index()
    {
        $day = Carbon::now()->subDays(1);
        $week = Carbon::now()->subDays(7);

        $count_register = [
            'day' => User::where('created_at', '>', $day)->count(),
            'week' => User::where('created_at', '>', $week)->count()
        ];
        $graph_register = $this->getGraphRegistration(3);

        $count_contract = [
            'day' => Contract::where('created_at', '>', $day)->whereActive(1)->count(),
            'week' => Contract::where('created_at', '>', $week)->whereActive(1)->count()
        ];
        $graph_contract = $this->getGraphСontract(3);

        $sum_deposit = [
            'day' => number_format( Contract::where('created_at', '>', $day)->whereActive(1)->sum('amount'), 2),
            'week' => number_format( Contract::where('created_at', '>', $week)->whereActive(1)->sum('amount'), 2)
        ];
        $graph_deposit = $this->getGraphDeposit(3);

        $sum_earn = [
            'day' => number_format( Transaction::where('created_at', '>', $day)->whereStatus(4)->whereType(3)->sum('in_usd'), 2),
            'week' => number_format( Transaction::where('created_at', '>', $week)->whereStatus(4)->whereType(3)->sum('in_usd'), 2)
        ];
        $graph_earn = $this->getGraphEarn(3);

        $last_parsing_time = HardwareItem::orderByDesc('updated_at')->first('updated_at');

        return view('home', compact('last_parsing_time', 'graph_deposit', 'graph_earn', 'graph_register', 'graph_contract', 'count_register', 'count_contract', 'sum_deposit', 'sum_earn'));
    }

    public function getGraphDeposit($month_count = 1) {
        $graph_tmp = Transaction::whereType(1)->whereStatus(4)
            ->whereBetween('created_at', getBetween($month_count))->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('m-d');
            })->all();
        //ksort($graph_tmp);
        return getGraph($graph_tmp, $month_count, 'in_usd');
    }

    // public function getGraphEarn($month_count = 1) {
    //     $graph_tmp = $this->dataEarn($month_count);
    //     //ksort($graph_tmp);
    //     return getGraph($graph_tmp, $month_count, 'amount');
    // }

    // public function dataEarn($month_count) {
    //     return auth()->user()->userTransactions()->whereStatus(4)->whereType(3)
    //         ->whereBetween('created_at', getBetween($month_count))->get()
    //         ->groupBy(function($date) {
    //             return Carbon::parse($date->created_at)->format('m-d');
    //         })->all();
    // }

    public function getGraphEarn($month_count = 1) {
        $graph_tmp = Transaction::whereStatus(4)->whereType(3)
            ->whereBetween('created_at', getBetween($month_count))->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('m-d');
            })->all();
        //ksort($graph_tmp);
        return getGraph($graph_tmp, $month_count, 'in_usd');
    }

    public function getGraphRegistration($month_count = 1) {
        $graph_tmp = User::select('created_at')
            ->whereBetween('created_at', getBetween($month_count))->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('m-d');
            })->all();
        //ksort($graph_tmp);
        return getGraph($graph_tmp, $month_count);
    }

    public function getGraphСontract($month_count = 1) {
        $graph_tmp = Contract::select('created_at')
            ->whereActive(1)
            ->whereBetween('created_at', getBetween($month_count))->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('m-d');
            })->all();
        //ksort($graph_tmp);
        return getGraph($graph_tmp, $month_count);
    }


}
