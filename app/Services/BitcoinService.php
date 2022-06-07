<?php


namespace App\Services;


use AmrShawky\Currency;
use App\Models\PaymentSystem;
use App\Models\UserCryptoAddress;
use App\Models\UserTransaction;
use Carbon\Carbon;
use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class BitcoinService
{
    public static function getBalance($address)
    {
        return file_get_contents('https://blockchain.info/q/addressbalance/' . $address);
    }

    public static function setBtcPaymentUnix()
    {
        /**
         * Для локального тестування
         *  $unix = strtotime('2022-04-08 17:00:00');
         *
         */
        $unix = strtotime('2022-04-08 17:00:00');
//        $unix = Carbon::now()->timestamp;
        Log::info("unix: " . $unix);
        Log::info("unix_date: " . date('Y-m-d H:i:s', $unix));
        Session::put('payment_btc_timestamp', $unix);
    }

    public static function getBtcCourse()
    {
        $url = 'https://bitpay.com/api/rates';
        $json = json_decode(file_get_contents($url));
        $btc = 0;

        foreach ($json as $obj) {
            if ($obj->code == 'USD') $btc = $obj->rate;
        }

        return $btc;
    }

    public static function checkTransactions($price, $wallet)
    {
        $min_timestamp = session('payment_btc_timestamp');
        $btc = self::getBtcCourse();

        $transaction_list = [];
        $satoshi = 100000000;
        $txnlist = file_get_contents("https://blockchain.info/rawaddr/" . $wallet->address);
        if ($txnlist) {
            $txnlist = json_decode($txnlist, true);
            if ($txnlist && isset($txnlist['txs']) && $txnlist['txs']) {
                $txns = $txnlist['txs'];
                foreach ($txns as $txn) {

                    $amount = $txn['result'] / $satoshi;
                    $time = $txn['time'];
                    $hash = $txn['hash'];
                    $status = $txn['ver'];
                    $transaction_list[] = array(
                        'amount' => $amount,
                        'hash' => $hash,
                        'time' => $time,
                        'status' => $status
                    );
                }
            }
            $data['address'] = $txnlist['address'];
            $data['total_txn'] = $txnlist['n_tx'];
            $data['total_received'] = $txnlist['total_received'] / $satoshi;
            $data['total_sent'] = $txnlist['total_sent'] / $satoshi;
            $data['final_balance'] = $txnlist['final_balance'] / $satoshi;
            $data['transaction_list'] = $transaction_list;
        }

        foreach ($transaction_list as $transaction) {

            if ($transaction['time'] >= $min_timestamp && TronService::checkUserTransaction($transaction['hash']) && $btc * $transaction['amount'] >= $price) {
                $transaction['amount_usdt'] = $btc * $transaction['amount'];
                return $transaction;
            }
        }

        return false;
    }

    /**
     * Конвертування USDT в BTC
     * @return string
     * @throws \Exception
     */
    public static function convertUsdt($usd)
    {
        $amount = Currency::convert()
            ->from('USD')
            ->to('BTC')
            ->amount($usd)
            ->round(7)
            ->get();

        return $amount;
    }

    public static function convertBTC($btc)
    {
        $amount = Currency::convert()
            ->from('BTC')
            ->to('USD')
            ->amount($btc)
            ->round(2)
            ->get();

        return $amount;
    }
}
