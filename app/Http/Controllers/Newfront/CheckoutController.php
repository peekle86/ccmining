<?php

namespace App\Http\Controllers\Newfront;

use App\Http\Controllers\Controller;
use App\Http\Helpers\CartHelper;
use App\Models\Checkout;
use App\Models\Contract;
use App\Models\ContractPeriod;
use App\Models\Currency;
use App\Models\Order;
use App\Models\PaymentSystem;
use App\Models\QiwiTransaction;
use App\Models\Setting;
use App\Services\CheckoutService;
use App\Services\QiwiService;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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

    public function transactionVerification(Request $request)
    {
        if ($request->payment_id == PaymentSystem::QIWI ||
            $request->payment_id == PaymentSystem::VISA ||
            $request->payment_id == PaymentSystem::MASTER_CARD ||
            $request->payment_id == PaymentSystem::MIR
        ) {

            $total = \App\Models\User::getUserCheckoutTotal();
            $checkout = auth()->user()->checkouts()->whereStatus(0)->first();
            $checkTransaction = QiwiService::checkTransactions($total);

            if ($checkTransaction && $checkout) {

                $paymentItem = $checkTransaction['paymentItem'];
                $convertAmount = $checkTransaction['convertAmount'];

                if ($convertAmount >= $total) {

                    $user = User::find(Auth::id());

                    $order = new Order;
                    $order->user_id = $user->id;
                    $order->checkout_id = $checkout->id;
                    $order->total = $total;
                    $order->status = Order::FINALIZED;

                    if ($order->save()) {

                        /**
                         * Збереження обладнання з корзини
                         */
                        $user = auth()->user();
                        $cart = $user->userCart ?? false;
                        if($cart) {
                            $items = $cart->items()->with('algoritm')->get(['id', 'price', 'model', 'hashrate', 'power', 'algoritm_id', 'profitability', 'url']);
                            $clouds = $items->where('algoritm_id', 5)->all();
                            $hards = $items->where('algoritm_id', '!=', 5)->all();
                            $periods = ContractPeriod::get();
                        }

                        if ($hards){
                            foreach ($hards as $hard){
                                Contract::create([
                                    'amount' => $hard->pivot->amount,
                                    'ended_at' => Carbon::now()->addDays($periods->find( $hard->pivot->period_id )->period),
                                    'active' => 1,
                                    'percent' => $hard->pivot->percent,
                                    'user_id' => $user->id,
                                    'hardware_id' => $hard->id,
                                    'period_id' => $hard->pivot->period_id,
                                    'currency_id' => $hard->pivot->currency_id,
                                    'last_earn' => Carbon::now()
                                ]);
                            }
                        }

                        if ($clouds){
                            foreach ($clouds as $cloud){
                                Contract::create([
                                    'amount' => $cloud->pivot->amount,
                                    'ended_at' => Carbon::now()->addDays($periods->find( $cloud->pivot->period_id )->period),
                                    'active' => 1,
                                    'percent' => $cloud->pivot->percent,
                                    'user_id' => $user->id,
                                    'hardware_id' => $cloud->id,
                                    'period_id' => $cloud->pivot->period_id,
                                    'currency_id' => $cloud->pivot->currency_id,
                                    'last_earn' => Carbon::now()
                                ]);
                            }
                        }


                        $transaction = new QiwiTransaction();
                        $transaction->user_id = $user->id;
                        $transaction->order_id = $order->id;
                        $transaction->transaction_id = $paymentItem->txnId;
                        $transaction->amount = $total;
                        $transaction->status = QiwiTransaction::CONFIRMED;
                        $transaction->payment_system_id = $request->payment_id;
                        $transaction->created_date = date('Y-m-d H:i:s');
                        $transaction->save();


                        /**
                         * Очищення корзини
                         */
                        $checkout->status = 1;
                        $checkout->update();

                        auth()->user()->userCart->items()->detach();

                    }

                    Session::flash('success', __('controller_message.payment_was_successful'));
                    return response()->json([
                        'route' => route('newfront.farm')
                    ]);

                } else {
                    return response()->json([
                        "errors" => ['transaction' => [__('controller_message.payment_transfer_error_full')]]
                    ], 422);
                }

            } else {
                return response()->json([
                    "errors" => ['transaction' => [__('controller_message.payment_transfer_error')]]
                ], 422);
            }


        }
    }
}
