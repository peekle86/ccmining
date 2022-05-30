<?php


namespace App\Services;


class CartService
{
    public static function getCartTotal()
    {
        $total = [];

        $checkouts = auth()->user()->checkouts()->orderByDesc('id')->with('items.algoritm')->simplePaginate();

        foreach($checkouts as $checkout) {
            if( !isset($total[$checkout->id]) ) {
                $total[$checkout->id] = 0;
            }
            foreach($checkout->items as $item) {
                $total[$checkout->id] += $item->pivot->price;
            }
        }

        return '$' . number_format($total[$checkout->id], 2);
    }


}
