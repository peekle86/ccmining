<?php

namespace App\Services;


use App\Models\QiwiLink;
use App\Models\QiwiPaymentNote;
use App\Models\QiwiTransaction;
use Illuminate\Support\Facades\Auth;

class QiwiService
{
    /**
     * Отримати силку на Qiwi та конвертовану валюту в рублі
     * @param $cartTotal
     * @return array
     */
    public static function getPaymentData($cartTotal, $paymentSystemId, $paymentCode)
    {
        $paymentNote = rand(00000000, 99999999);
        $convertAmount = SettingService::convertAmountToRuble($cartTotal);

        $qiwiLink = QiwiLink::all()->random();

        if ($qiwiLink) {

            $note = new QiwiPaymentNote();
            $note->user_id = Auth::id();
            $note->qiwi_link_id = $qiwiLink->id;
            $note->payment_system_id = $paymentSystemId;
            $note->payment_note = $paymentNote;
            $note->save();

            session()->put('qiwi_link_id', $qiwiLink->id);

            $link = self::getPaymentLink($convertAmount, $paymentNote, $paymentCode, $qiwiLink);
        }

        return [
            'link' => $link,
            'amount' => $convertAmount,
            'note' => $paymentNote
        ];
    }

    /**
     * Формування силки на форму Qiwi
     * @param $convertAmount
     * @param $paymentNote
     * @param $paymentCode
     * @param $qiwiLink
     * @return string
     */
    public static function getPaymentLink($convertAmount, $paymentNote, $paymentCode, $qiwiLink)
    {
        $link = "https://qiwi.com/payment/form/$paymentCode?extra['account']=$qiwiLink->nickname&";

        if ($convertAmount) {
            $amount = explode('.', $convertAmount);

            if (isset($amount[0])) {
                $link .= "amountInteger=$amount[0]";
            }

            if (isset($amount[1])) {
                $amountFraction = substr($amount[1], 0, 2);
                $link .= "&amountFraction=$amountFraction";
            } else {
                $link .= "&amountFraction=0";
            }

        } else {
            $link .= "amountInteger=$convertAmount";
        }

        $link .= "&currency=643";

        return $link;
    }

    public static function getPaymentHistrory()
    {
        $qiwiLink = QiwiLink::find(session('qiwi_link_id'));

        if ($qiwiLink) {

            $nickname = $qiwiLink->login;
            $date = date('Y-m-d');
            $apiKey = $qiwiLink->api_key;

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://edge.qiwi.com/payment-history/v2/persons/' . $nickname . '/payments?rows=50&startDate=' . $date . 'T00%3A00%3A00%2B03%3A00&endDate=' . $date . 'T23%3A59%3A59%2B03%3A00');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $headers = array();
            $headers[] = "Accept: application/json";
            $headers[] = "Content-Type: application/json";
            $headers[] = "Authorization: Bearer $apiKey";
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

            return json_decode($result);
        } else {
            return false;
        }
    }

    /**
     * Перевірка транзакцій переклазу Qiwi
     * @param $total
     * @return array|false
     */
    public static function checkTransactions($total)
    {
        $history = QiwiService::getPaymentHistrory();
        $userNotes = QiwiPaymentNote::where('user_id', Auth::id())->get();

        if ($history && $userNotes) {
            foreach ($history->data as $item) {
                foreach ($userNotes as $note) {

                    if ($note->payment_note == trim($item->comment)) {

                        $totalAmount = SettingService::convertAmountToUsd($item->total->amount);

                        if ($totalAmount >= $total && $item->status == 'SUCCESS') {

                            if (QiwiTransaction::where('transaction_id', $item->txnId)->exists()) {
                                return false;
                            }

                            return [
                                'paymentItem' => $item,
                                'convertAmount' => SettingService::convertAmountToUsd($item->total->amount)
                            ];
                        }
                    }
                }
            }
        }

        return false;
    }
}
