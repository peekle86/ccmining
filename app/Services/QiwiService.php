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

        if (is_float($convertAmount)) {
            $amount = explode('.', $convertAmount);

            if (isset($amount[0])) {
                $link .= "amountInteger=$amount[0]";
            }

            if (isset($amount[1])) {
                $link .= "&amountFraction=$amount[1]";
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
//        $data = '{"data":[{"txnId":25056891439,"personId":79276005996,"date":"2022-05-06T09:12:13+03:00","errorCode":0,"error":null,"status":"SUCCESS","type":"IN","statusText":"Success","trmTxnId":"923369792652","account":"+79323225106","sum":{"amount":4.98,"currency":643},"commission":{"amount":0.00,"currency":643},"total":{"amount":4.98,"currency":643},"provider":{"id":7,"shortName":"QIWI РљРѕС€РµР»РµРє","longName":"QIWI РљРѕС€РµР»РµРє","logoUrl":null,"description":null,"keys":"РјРѕР±РёР»СЊРЅС‹Р№ РєРѕС€РµР»РµРє, РєРѕС€РµР»РµРє, РїРµСЂРµРІРµСЃС‚Рё РґРµРЅСЊРіРё, Р»РёС‡РЅС‹Р№ РєР°Р±РёРЅРµС‚, РѕС‚РїСЂР°РІРёС‚СЊ РґРµРЅСЊРіРё, РїРµСЂРµРІРѕРґ РјРµР¶РґСѓ РїРѕР»СЊР·РѕРІР°С‚РµР»СЏРјРё","siteUrl":null,"extras":[]},"source":{"id":99,"shortName":"РџРµСЂРµРІРѕРґ РЅР° QIWI РљРѕС€РµР»РµРє","longName":null,"logoUrl":"https://static.qiwi.com/img/providers/logoBig/99_l.png","description":null,"keys":"РїРѕРїРѕР»РЅРёС‚СЊ, РїРµСЂРµРІРµСЃС‚Рё, qiwi, РєРѕС€РµР»РµРє, РѕРїР»Р°С‚РёС‚СЊ, РѕРЅР»Р°Р№РЅ, РѕРїР»Р°С‚Р°, СЃС‡РµС‚, СЃРїРѕСЃРѕР±, СѓСЃР»СѓРіР°, РїРµСЂРµРІРѕРґ","siteUrl":"https://www.qiwi.com","extras":[{"key":"seo_description","value":"РџРѕРїРѕР»РЅРµРЅРёРµ QIWI РљРѕС€РµР»СЊРєР° Р±Р°РЅРєРѕРІСЃРєРѕР№ РєР°СЂС‚РѕР№ Р±РµР· РєРѕРјРёСЃСЃРёРё РѕС‚ 2000 СЂСѓР±., СЃРѕ СЃС‡РµС‚Р° РјРѕР±РёР»СЊРЅРѕРіРѕ С‚РµР»РµС„РѕРЅР° РёР»Рё РЅР°Р»РёС‡РЅС‹РјРё С‡РµСЂРµР· QIWI РўРµСЂРјРёРЅР°Р»С‹. РћРїР»Р°С‡РёРІР°С‚СЊ СѓСЃР»СѓРіРё СЃС‚Р°Р»Рѕ РїСЂРѕС‰Рµ."},{"key":"seo_title","value":"РџРѕРїРѕР»РЅРёС‚СЊ QIWI РљРѕС€РµР»РµРє: СЃ Р±Р°РЅРєРѕРІСЃРєРѕР№ РєР°СЂС‚С‹, СЃ Р±Р°Р»Р°РЅСЃР° С‚РµР»РµС„РѕРЅР°, С‡РµСЂРµР· QIWI РљРѕС€РµР»РµРє"}]},"comment":"55667510","currencyRate":1,"paymentExtras":[],"features":{"chequeReady":false,"bankDocumentReady":false,"regularPaymentEnabled":false,"bankDocumentAvailable":false,"repeatPaymentEnabled":false,"favoritePaymentEnabled":false,"chatAvailable":false,"greetingCardAttached":false},"serviceExtras":{},"view":{"title":"QIWI РљРѕС€РµР»РµРє","account":"+79323225106"}},{"txnId":25044993705,"personId":79276005996,"date":"2022-05-04T14:59:18+03:00","errorCode":0,"error":null,"status":"SUCCESS","type":"OUT","statusText":"Success","trmTxnId":"1241446836726","account":"79276005996","sum":{"amount":60,"currency":643},"commission":{"amount":0,"currency":643},"total":{"amount":60,"currency":643},"provider":{"id":37487,"shortName":"РРґРµРЅС‚РёС„РёРєР°С†РёСЏ С‡РµСЂРµР· РњРµРіР°Р¤РѕРЅ","longName":"РљРР’Р Р‘РђРќРљ (РђРћ)","logoUrl":"https://static.qiwi.com/img/providers/logoBig/37487_l.png","description":null,"keys":null,"siteUrl":null,"extras":[{"key":"favorite_payment_disabled","value":"true"},{"key":"regular_payment_disabled","value":"true"}]},"source":{"id":7,"shortName":"QIWI РљРѕС€РµР»РµРє","longName":"QIWI РљРѕС€РµР»РµРє","logoUrl":null,"description":null,"keys":"РјРѕР±РёР»СЊРЅС‹Р№ РєРѕС€РµР»РµРє, РєРѕС€РµР»РµРє, РїРµСЂРµРІРµСЃС‚Рё РґРµРЅСЊРіРё, Р»РёС‡РЅС‹Р№ РєР°Р±РёРЅРµС‚, РѕС‚РїСЂР°РІРёС‚СЊ РґРµРЅСЊРіРё, РїРµСЂРµРІРѕРґ РјРµР¶РґСѓ РїРѕР»СЊР·РѕРІР°С‚РµР»СЏРјРё","siteUrl":null,"extras":[]},"comment":null,"currencyRate":1,"paymentExtras":[],"features":{"chequeReady":true,"bankDocumentReady":false,"regularPaymentEnabled":false,"bankDocumentAvailable":false,"repeatPaymentEnabled":false,"favoritePaymentEnabled":false,"chatAvailable":false,"greetingCardAttached":false},"serviceExtras":{},"view":{"title":"РРґРµРЅС‚РёС„РёРєР°С†РёСЏ С‡РµСЂРµР· РњРµРіР°Р¤РѕРЅ","account":"79276005996"}},{"txnId":25044980890,"personId":79276005996,"date":"2022-05-04T14:57:21+03:00","errorCode":0,"error":null,"status":"SUCCESS","type":"IN","statusText":"Success","trmTxnId":"4216859849","account":"РџР»Р°С‚РµР¶РЅР°СЏ СЃРёСЃС‚РµРјР°","sum":{"amount":60,"currency":643},"commission":{"amount":0,"currency":643},"total":{"amount":60,"currency":643},"provider":{"id":26444,"shortName":"Р Р°РїРёРґР°","longName":"РќРљРћ Р Р°РїРёРґР° (СЂРµР·РёРґРµРЅС‚С‹)","logoUrl":null,"description":null,"keys":null,"siteUrl":null,"extras":[]},"source":{"id":99,"shortName":"РџРµСЂРµРІРѕРґ РЅР° QIWI РљРѕС€РµР»РµРє","longName":null,"logoUrl":"https://static.qiwi.com/img/providers/logoBig/99_l.png","description":null,"keys":"РїРѕРїРѕР»РЅРёС‚СЊ, РїРµСЂРµРІРµСЃС‚Рё, qiwi, РєРѕС€РµР»РµРє, РѕРїР»Р°С‚РёС‚СЊ, РѕРЅР»Р°Р№РЅ, РѕРїР»Р°С‚Р°, СЃС‡РµС‚, СЃРїРѕСЃРѕР±, СѓСЃР»СѓРіР°, РїРµСЂРµРІРѕРґ","siteUrl":"https://www.qiwi.com","extras":[{"key":"seo_description","value":"РџРѕРїРѕР»РЅРµРЅРёРµ QIWI РљРѕС€РµР»СЊРєР° Р±Р°РЅРєРѕРІСЃРєРѕР№ РєР°СЂС‚РѕР№ Р±РµР· РєРѕРјРёСЃСЃРёРё РѕС‚ 2000 СЂСѓР±., СЃРѕ СЃС‡РµС‚Р° РјРѕР±РёР»СЊРЅРѕРіРѕ С‚РµР»РµС„РѕРЅР° РёР»Рё РЅР°Р»РёС‡РЅС‹РјРё С‡РµСЂРµР· QIWI РўРµСЂРјРёРЅР°Р»С‹. РћРїР»Р°С‡РёРІР°С‚СЊ СѓСЃР»СѓРіРё СЃС‚Р°Р»Рѕ РїСЂРѕС‰Рµ."},{"key":"seo_title","value":"РџРѕРїРѕР»РЅРёС‚СЊ QIWI РљРѕС€РµР»РµРє: СЃ Р±Р°РЅРєРѕРІСЃРєРѕР№ РєР°СЂС‚С‹, СЃ Р±Р°Р»Р°РЅСЃР° С‚РµР»РµС„РѕРЅР°, С‡РµСЂРµР· QIWI РљРѕС€РµР»РµРє"}]},"comment":null,"currencyRate":1,"paymentExtras":[],"features":{"chequeReady":false,"bankDocumentReady":false,"regularPaymentEnabled":false,"bankDocumentAvailable":false,"repeatPaymentEnabled":false,"favoritePaymentEnabled":false,"chatAvailable":false,"greetingCardAttached":false},"serviceExtras":{},"view":{"title":"Р Р°РїРёРґР°","account":"РџР»Р°С‚РµР¶РЅР°СЏ СЃРёСЃС‚РµРјР°"}}],"nextTxnId":null,"nextTxnDate":null}';
//        $data2 = '{"data":[{"txnId":25056891439,"personId":79276005996,"date":"2022-05-06T09:12:13+03:00","errorCode":0,"error":null,"status":"SUCCESS","type":"IN","statusText":"Success","trmTxnId":"923369792652","account":"+79323225106","sum":{"amount":23000,"currency":643},"commission":{"amount":0.00,"currency":643},"total":{"amount":23000,"currency":643},"provider":{"id":7,"shortName":"QIWI РљРѕС€РµР»РµРє","longName":"QIWI РљРѕС€РµР»РµРє","logoUrl":null,"description":null,"keys":"РјРѕР±РёР»СЊРЅС‹Р№ РєРѕС€РµР»РµРє, РєРѕС€РµР»РµРє, РїРµСЂРµРІРµСЃС‚Рё РґРµРЅСЊРіРё, Р»РёС‡РЅС‹Р№ РєР°Р±РёРЅРµС‚, РѕС‚РїСЂР°РІРёС‚СЊ РґРµРЅСЊРіРё, РїРµСЂРµРІРѕРґ РјРµР¶РґСѓ РїРѕР»СЊР·РѕРІР°С‚РµР»СЏРјРё","siteUrl":null,"extras":[]},"source":{"id":99,"shortName":"РџРµСЂРµРІРѕРґ РЅР° QIWI РљРѕС€РµР»РµРє","longName":null,"logoUrl":"https://static.qiwi.com/img/providers/logoBig/99_l.png","description":null,"keys":"РїРѕРїРѕР»РЅРёС‚СЊ, РїРµСЂРµРІРµСЃС‚Рё, qiwi, РєРѕС€РµР»РµРє, РѕРїР»Р°С‚РёС‚СЊ, РѕРЅР»Р°Р№РЅ, РѕРїР»Р°С‚Р°, СЃС‡РµС‚, СЃРїРѕСЃРѕР±, СѓСЃР»СѓРіР°, РїРµСЂРµРІРѕРґ","siteUrl":"https://www.qiwi.com","extras":[{"key":"seo_description","value":"РџРѕРїРѕР»РЅРµРЅРёРµ QIWI РљРѕС€РµР»СЊРєР° Р±Р°РЅРєРѕРІСЃРєРѕР№ РєР°СЂС‚РѕР№ Р±РµР· РєРѕРјРёСЃСЃРёРё РѕС‚ 2000 СЂСѓР±., СЃРѕ СЃС‡РµС‚Р° РјРѕР±РёР»СЊРЅРѕРіРѕ С‚РµР»РµС„РѕРЅР° РёР»Рё РЅР°Р»РёС‡РЅС‹РјРё С‡РµСЂРµР· QIWI РўРµСЂРјРёРЅР°Р»С‹. РћРїР»Р°С‡РёРІР°С‚СЊ СѓСЃР»СѓРіРё СЃС‚Р°Р»Рѕ РїСЂРѕС‰Рµ."},{"key":"seo_title","value":"РџРѕРїРѕР»РЅРёС‚СЊ QIWI РљРѕС€РµР»РµРє: СЃ Р±Р°РЅРєРѕРІСЃРєРѕР№ РєР°СЂС‚С‹, СЃ Р±Р°Р»Р°РЅСЃР° С‚РµР»РµС„РѕРЅР°, С‡РµСЂРµР· QIWI РљРѕС€РµР»РµРє"}]},"comment":"26819363","currencyRate":1,"paymentExtras":[],"features":{"chequeReady":false,"bankDocumentReady":false,"regularPaymentEnabled":false,"bankDocumentAvailable":false,"repeatPaymentEnabled":false,"favoritePaymentEnabled":false,"chatAvailable":false,"greetingCardAttached":false},"serviceExtras":{},"view":{"title":"QIWI РљРѕС€РµР»РµРє","account":"+79323225106"}}],"nextTxnId":null,"nextTxnDate":null}';
//        $some = json_decode($data2);
//        return $some;


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
//                    if (26819363 == $item->comment) {
                        /**
                         * TODO:ПОВЕРНУТИ;
                         */
                    if ($note->payment_note == $item->comment) {

                        if (SettingService::convertAmountToUsd($item->total->amount) >= $total && $item->status == 'SUCCESS') {

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
