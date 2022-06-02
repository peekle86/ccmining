<?php


namespace App\Services;


use App\Models\Setting;

class SettingService
{
    /**
     * Конвертування суми в рублі
     * @param $amount
     * @return float|int
     */
    public static function convertAmountToRuble($amount)
    {
        $ruble = Setting::pluck('ruble_course')->first();

        return $amount * $ruble;
    }
}