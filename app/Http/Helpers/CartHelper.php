<?php

namespace App\Http\Helpers;

use App\Models\Setting;

class CartHelper {

    // public function getAlgoPrice($algoritm_id, $settings) {
    //     switch ($algoritm_id) {
    //         case 1:
    //             return $settings->price_mh;
    //             break;
    //         case 2:
    //             return $settings->price_gh;
    //             break;
    //         case 3:
    //             return $settings->price_mh_ltc;
    //             break;

    //         default:
    //             break;
    //     }
    // }

    public function getAmount($item, $percent, $format=false) {
        $amount = $item->amount / 100 * $percent;
        if( $format ) return number_format( $amount, $format );
        return $amount;
    }

    public function calcPercent($value, $percent, $format=false) {
        if( $format ) {
            return number_format($value / 100 * $percent, $format);
        }
        return $value / 100 * $percent;
    }

    public function getUnit($value)
    {
        if(! $value) return '-';
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
