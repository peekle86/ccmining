<?php

namespace App\Http\Controllers\Newfront;

use App\Models\Setting;
use App\Models\HardwareItem;
use App\Models\HardwareType;
use Illuminate\Http\Request;
use App\Models\ContractPeriod;
use App\Http\Controllers\Controller;

class FarmController extends Controller
{
    public function index()
    {
        $cart_items = array();
        $user = auth()->user();
        if( $user->userCart ) {
            $cart_items = $user->userCart->items()->get();
        }

        $hardware_available = array();
        $hardware_my = array();
        $hardware_types = HardwareType::where('id', '!=', 4)->orderByDesc('id')->get();

        $hard_av = HardwareItem::whereAvailable(1)->with('algoritm')->orderByRaw('CAST(profitability AS DECIMAL)'. "desc")->get();
        foreach( $hard_av as $hard ) {
            $hardware_available[$hard->algoritm->id][] = $hard;
        }

        $hard_my = $user->userContracts()->whereActive(1)->with('hardware')->get();
        foreach( $hard_my as $hard ) {
            $hardware_my[$hard->hardware->algoritm->id][] = $hard;
        }

        $Farm = new FarmController;
        $setting = Setting::whereActive(1)->first();
        $periods = ContractPeriod::get();


        return view('newfront.farm', compact('periods', 'setting', 'hardware_types', 'hardware_available', 'hardware_my', 'Farm', 'cart_items'));
    }

    static function getColor($profitability)
    {
        if( $profitability >= 20 ):
            return 'bg-green-400 text-green-900 ';
        elseif ( $profitability >= 15 ):
            return 'bg-green-200 text-green-900 ';
        elseif ( $profitability >= 10 ):
            return 'bg-green-50 text-green-900 ';
        elseif ( $profitability >= 5 ):
            return 'bg-yellow-100 text-yellow-900 ';
        elseif ( $profitability >= 0 ):
            return 'bg-yellow-400 text-yellow-900 ';
        else:
            return 'bg-red-200 text-red-900 ';
        endif;
    }

    static function getUnit($value)
    {
        switch ($value) {
            case ($value / 1000000) >= 1:
                return $value / 1000000 . '<small class="text-gray-500 ml-0.5">Th/s</small>';
                break;

            case ($value / 1000) >= 1:
                return $value / 1000 . '<small class="text-gray-500 ml-0.5">Gh/s</small>';
                break;

            default:
                return $value . '<small class="text-gray-500 ml-0.5">Mh/s</small>';
                break;
        }
    }
}
