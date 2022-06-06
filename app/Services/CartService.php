<?php


namespace App\Services;


use App\Models\Contract;
use App\Models\ContractPeriod;
use Carbon\Carbon;

class CartService
{
    public static function getCartTotal()
    {
        $total = 0;

        $cartItems = auth()->user()->userCart()->orderByDesc('id')->with('items.algoritm')->simplePaginate();

        foreach($cartItems as $cart) {
            foreach($cart->items as $hardItem) {
                $total += intval($hardItem->pivot->amount);
            }
        }

        return '$' . number_format($total, 2);
    }

    public static function saveCart()
    {
        /**
         * Збереження обладнання та орегди з корзини
         */
        $user = auth()->user();
        $cart = $user->userCart ?? false;
        if ($cart) {
            $items = $cart->items()->with('algoritm')->get(['id', 'price', 'model', 'hashrate', 'power', 'algoritm_id', 'profitability', 'url']);
            $clouds = $items->where('algoritm_id', 5)->all();
            $hards = $items->where('algoritm_id', '!=', 5)->all();
            $periods = ContractPeriod::get();
        }

        if ($hards) {
            foreach ($hards as $hard) {
                Contract::create([
                    'amount' => $hard->pivot->amount,
                    'ended_at' => Carbon::now()->addDays($periods->find($hard->pivot->period_id)->period),
                    'active' => 1,
                    'percent' => $hard->pivot->percent,
                    'user_id' => $user->id,
                    'hardware_id' => $hard->id,
                    'period_id' => $hard->pivot->period_id,
                    'currency_id' => $hard->pivot->currency_id,
                    'last_earn' => Carbon::now()
                ]);
            }
        }

        if ($clouds) {
            foreach ($clouds as $cloud) {
                Contract::create([
                    'amount' => $cloud->pivot->amount,
                    'ended_at' => Carbon::now()->addDays($periods->find($cloud->pivot->period_id)->period),
                    'active' => 1,
                    'percent' => $cloud->pivot->percent,
                    'user_id' => $user->id,
                    'hardware_id' => $cloud->id,
                    'period_id' => $cloud->pivot->period_id,
                    'currency_id' => $cloud->pivot->currency_id,
                    'last_earn' => Carbon::now()
                ]);
            }
        }
    }


}
