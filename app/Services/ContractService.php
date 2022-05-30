<?php


namespace App\Services;


class ContractService
{
    public static function getContractStatus($amount)
    {
        if ($amount >= 250 && $amount <= 1000){
            $status = __('farm.contract_status.newbie');
        } elseif ($amount >= 1001 && $amount <= 3000){
            $status = __('farm.contract_status.miner');
        } elseif ($amount >= 3001 && $amount <= 6000){
            $status = __('farm.contract_status.partner');
        } elseif ($amount >= 6001 && $amount <= 12000){
            $status = __('farm.contract_status.businessman');
        } elseif ($amount >= 12001 && $amount <= 25000){
            $status = __('farm.contract_status.crypto_whale');
        }

        return $status;
    }
}
