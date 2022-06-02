<?php

namespace App\Http\Controllers\Newfront;

use App\Http\Controllers\Controller;
use App\Http\Helpers\CartHelper;
use App\Models\ContractPeriod;
use App\Models\Currency;
use App\Models\PaymentSystem;
use App\Models\Setting;
use App\Services\CheckoutService;
use App\Services\QiwiService;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    public function index()
    {
        $total = array();
        $helpers = new CartHelper;
        $currencies = Currency::whereActive(1)->get();
        $settings = Setting::whereActive('1')->first();
        $periods = ContractPeriod::get();
        $checkouts = auth()->user()->checkouts()->orderByDesc('id')->with('items.algoritm')->simplePaginate();

        foreach($checkouts as $checkout) {
            if( !isset($total[$checkout->id]) ) {
                $total[$checkout->id] = 0;
            }
            foreach($checkout->items as $item) {
                $total[$checkout->id] += $item->pivot->price;
            }
        }

        $data = CheckoutService::getCheckoutItems($checkout->items);
        $hards = $data['hard'];
        $cloud = $data['cloud'];

        $Farm = new FarmController;
        return view('newfront.checkout', compact(
            'currencies',
            'total',
            'checkouts',
            'Farm',
            'settings',
            'periods',
            'hards',
            'cloud'
        ));
    }

    public function paymentCheckout(Request $request)
    {
        $paymentSystemId = $request->payment;

        $total = \App\Models\User::getUserCheckoutTotal();

        if ($paymentSystemId == PaymentSystem::QIWI ||
            $paymentSystemId == PaymentSystem::VISA ||
            $paymentSystemId == PaymentSystem::MASTER_CARD ||
            $paymentSystemId == PaymentSystem::MIR
        ) {

            $payment_id = PaymentSystem::QIWI;
            $cartTotal = $total;
            $paymentCode = '99999';

            $data = QiwiService::getPaymentData($cartTotal, $payment_id, $paymentCode);

            $paymentHtml = view('newfront.cart.qiwi_payment_block', [
                'link' => $data['link'],
                'total' => $data['amount'] . '₽',
                'note' => $data['note'],
                'payment_id' => $payment_id,
            ])->render();

            return response()->json([
                'payment_html' => $paymentHtml
            ]);

        }
    }
}
