<?php

namespace App\Http\Controllers\Newfront;

use App\Models\Role;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Models\RefStat;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class AffiliateController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $users = $user->referrals()->get();

        $registrations_graph = $this->getGraphRegistration();
        $clicks_graph = $this->getGraphClick();
        $earns_graph = $this->getGraphEarn();

        $clicks = RefStat::where('code', auth()->user()->ref)->sum('count');
        $registrations = $users->count();
        $earns = $user->userTransactions()->where('type', 5)->whereStatus(4)->get()->sum('amount'); //$users->sum();
        //dd($earns);
        $ref_earning = array();

        $setting = Setting::first();




        $ref_earns = $user->userTransactions()->where('type', '5')->where('status', 3)->get();
        foreach ($ref_earns as $earn) {

            if (!isset($ref_earning[$earn->currency->id])) {
                $ref_earning[$earn->currency->id] = 0;
            }
            $ref_earning[$earn->currency->id] += $earn->amount * $earn->currency->in_usd;
        }

        return view('newfront.affiliate2', compact('clicks', 'registrations', 'earns', 'clicks_graph', 'registrations_graph', 'earns_graph', 'users', 'ref_earning', 'user', 'setting'));
    }

    public function getGraphClick() {
        $graph_tmp = RefStat::where('code', auth()->user()->ref)->select('created_at','count')
            ->whereBetween('created_at', getBetween(auth()->user()->created_at))->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d');
            })->all();
        //ksort($graph_tmp);

        return getGraph($graph_tmp, auth()->user()->created_at);
    }

    public function getGraphRegistration() {
        $graph_tmp = User::where('parent_id', auth()->id())->select('created_at')
            ->whereBetween('created_at', getBetween(auth()->user()->created_at))->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d');
            })->all();
        //ksort($graph_tmp);
        return getGraph($graph_tmp, auth()->user()->created_at);
    }

    public function getGraphEarn() {
        $graph_tmp = $this->dataEarn();
        //ksort($graph_tmp);
        return getGraph($graph_tmp, auth()->user()->created_at, 'amount');
    }

    public function dataEarn() {
        return auth()->user()->userTransactions()->whereStatus(4)->whereType(5)
            ->whereBetween('created_at', getBetween(auth()->user()->created_at))->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d');
            })->all();
    }



    // public function getGraphEarn($month_count = 1) {
    //     $graph_tmp = Transaction::whereStatus(4)->whereType(3)
    //         ->whereBetween('created_at', getBetween($month_count))->get()
    //         ->groupBy(function($date) {
    //             return Carbon::parse($date->created_at)->format('m-d');
    //         })->all();
    //     //ksort($graph_tmp);
    //     return getGraph($graph_tmp, $month_count, 'amount');
    // }
}
