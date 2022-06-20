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
        $amount = str_replace(",", "", $amount);
        $ruble = Setting::pluck('ruble_course')->first();

        return round($amount * $ruble, 2);
    }

    /**
     * Конвертування сими з долар
     * @param $amount
     * @return float|int
     */
    public static function convertAmountToUsd($amount)
    {
        $amount = str_replace(",", "", $amount);
        $ruble = Setting::pluck('ruble_course')->first();

        return round($amount / $ruble, 2);
    }
}
