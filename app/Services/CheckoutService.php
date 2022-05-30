<?php


namespace App\Services;


class CheckoutService
{
    public static function getCheckoutItems($items)
    {
        $hard = collect();
        $cloud = collect();
        foreach ($items as $item){
            if ($item->hashrate && $item->power){
                $hard->push($item);
            } else {
                $cloud->push($item);
            }
        }

        return [
            'hard' => $hard,
            'cloud' => $cloud
        ];
    }
}
