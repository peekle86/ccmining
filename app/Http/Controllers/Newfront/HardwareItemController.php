<?php

namespace App\Http\Controllers\Newfront;

use App\Models\Setting;
use App\Models\Currency;
use App\Models\HardwareItem;
use Illuminate\Http\Request;
use App\Models\ContractPeriod;
use App\Http\Helpers\CartHelper;
use App\Http\Controllers\Controller;

class HardwareItemController extends Controller
{

    protected $setting;

    public function __construct()
    {
        $this->setting = Setting::whereActive(1)->first();
    }
    public function show($vendor, $slug)
    {
        $setting = $this->setting;
        $periods = ContractPeriod::get();
        $hardwareItem = HardwareItem::where('url', '/miners/'.$vendor.'/'.$slug)->where('algoritm_id', '!=', 5)->firstOrFail();

        $hard = [
            'id' => $hardwareItem->id,
            'model' => $hardwareItem->model,
            'hashrate' => $hardwareItem->hashrate,
            'power' => $hardwareItem->power,
            'profitability' => $hardwareItem->profitability,
            'profit' => $hardwareItem->profit,
            'price' => $hardwareItem->price
        ];

        $profit = array(
            'income' => $hardwareItem->profitability,
            'electricity' => $hardwareItem->power * 24 / 1000 * $setting->price_kwt
        );
        $profit['profit'] = $profit['income'] - $profit['electricity'];

        $Farm = new FarmController;
        $currencies = Currency::whereActive(1)->get();

        return view('newfront.hardwareItem', compact('Farm', 'setting', 'currencies', 'hardwareItem', 'hard', 'profit', 'periods'));
    }

    public function my($id)
    {
        $helpers = new CartHelper;
        $setting = $this->setting;
        $contract = auth()->user()->userContracts()->findOrFail($id);
        $hardwareItem = $contract->hardware;

        $profit = array(
            'income' => $helpers->getAmount($hardwareItem, $contract->percent),
            'electricity' => $hardwareItem->power * 24 / 1000 * $setting->price_kwt
        );
        $profit['profit'] = $profit['income'] - $profit['electricity'];

        $chart_data = array(
            "time" => [],
            "amount" => []
        );

        foreach($contract->transactions()->get() as $key => $chart) {
            $chart_data['time'][] = $chart->created_at->format('Y-m-d');
            if( $key > 0 ) {
                $chart_data['amount'][] = $chart->amount + $chart_data['amount'][$key-1];
            } else {
                $chart_data['amount'][] = +$chart->amount;
            }
        }

        return view('newfront.myHardwareItem', compact('hardwareItem', 'profit', 'chart_data'));
    }

    static function money($val)
    {
        return number_format($val, 2);
    }
}
