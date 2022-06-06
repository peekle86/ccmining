<?php


namespace App\Services;


use App\Models\CryproTransaction;
use App\Models\UserCryptoAddress;
use App\Models\UserTransaction;
use App\Models\UserWallet;
use Carbon\Carbon;
use GuzzleHttp\Client;
use IEXBase\TronAPI\Exception\TronException;
use IEXBase\TronAPI\Provider\HttpProvider;
use IEXBase\TronAPI\Tron;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class TronService
{
    /**
     * Конфігурація Tron
     * @return Tron
     */
    public static function getTronNetConfig()
    {
        $fullNode = new HttpProvider('https://api.trongrid.io');
        $solidityNode = new HttpProvider('https://api.trongrid.io');
        $eventServer = new HttpProvider('https://api.trongrid.io');

        try {
            $tron = new Tron($fullNode, $solidityNode, $eventServer);
        } catch (TronException $e) {
            exit($e->getMessage());
        }

        return $tron;
    }

    /**
     * Становлення Unix часу оплати або поповнення.
     */
    public static function setPaymentUnix()
    {
        /**
         * Для локального тестування
         *  $unix = strtotime('2022-03-23 18:00:12');
         *
         */
        $unix = strtotime('2022-03-23 18:00:12');
//        $unix = Carbon::now()->timestamp;
        Log::info("unix: " . $unix);
        Log::info("unix_date: " . date('Y-m-d H:i:s', $unix));
        $timestamp = $unix + 3600;
        Session::put('payment_timestamp', $timestamp . '000');
    }

    /**
     * Статус транзакці
     * @param $transaction_id
     * @return bool
     * @throws TronException
     */
    public static function getTransactionStatus($transaction_id)
    {
        $tron = self::getTronNetConfig();

        try {

            $transactionStatus = $tron->getTransaction($transaction_id);

            if ($transactionStatus["ret"][0]["contractRet"]) {
                $status = $transactionStatus["ret"][0]["contractRet"] == 'SUCCESS';
            } else {
                $status = false;
            }

            return $status;

        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Перевірка чи збережена така транзакція в бд
     * @param $transaction_id
     * @return bool
     */
    public static function checkUserTransaction($transaction_id)
    {
        $transaction = CryproTransaction::where('transaction_hash', $transaction_id)->exists();

        if ($transaction) {
            return false;
        }

        return true;
    }

    /**
     * Ціна переказу транзакції
     * @param $value
     * @return float|int
     */
    public static function getTransactionValue($value)
    {
        try {
            return $value / 1000000;
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Перевірка всіх транзакцій по кошельку користувача
     * @param $wallet
     * @return array|false
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function checkTransactions($wallet)
    {
        try {
            $client = new Client();
            $min_timestamp = session('payment_timestamp');
            $request = $client->get("https://api.trongrid.io/v1/accounts/$wallet->address/transactions/trc20?min_timestamp=$min_timestamp");
            $transactions = json_decode($request->getBody()->getContents());

            foreach ($transactions->data as $transaction) {

                if ($transaction->transaction_id && $transaction->value) {
                    $checkTransactionStatus = self::getTransactionStatus($transaction->transaction_id);
                    $checkUserTransaction = self::checkUserTransaction($transaction->transaction_id);
                    $checkTransactionValue = self::getTransactionValue($transaction->value);

                    if ($checkTransactionStatus && $checkUserTransaction) {
                        return [
                            'transactionStatus' => $checkTransactionStatus,
                            'userTransactionStatus' => $checkUserTransaction,
                            'transactionValue' => $checkTransactionValue,
                            'transaction_id' => $transaction->transaction_id
                        ];
                    }
                }
            }

            return false;

        } catch (\Exception $e) {
            return false;
        }
    }


}
