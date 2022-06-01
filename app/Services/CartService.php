<?php


namespace App\Services;


class CartService
{
    public static function getCartTotal()
    {
        $total = 0;

        $cartItems = auth()->user()->userCart()->orderByDesc('id')->with('items.algoritm')->simplePaginate();

        foreach($cartItems as $item) {
            foreach($item->items as $hardItem) {
                $total += $hardItem->pivot->amount;
            }
        }

        return '$' . number_format($total, 2);
    }


}
