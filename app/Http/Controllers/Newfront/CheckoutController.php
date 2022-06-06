<?php

namespace App\Http\Controllers\Newfront;

use App\Http\Controllers\Controller;
use App\Http\Helpers\CartHelper;
use App\Http\Requests\PaymentCheckoutRequest;
use App\Models\Contract;
use App\Models\ContractPeriod;
use App\Models\CryproTransaction;
use App\Models\Currency;
use App\Models\Order;
use App\Models\PagePayment;
use App\Models\PaymentSystem;
use App\Models\QiwiTransaction;
use App\Models\Setting;
use App\Models\Wallet;
use App\Models\WalletNetwork;
use App\Services\CartService;
use App\Services\CheckoutService;
use App\Services\QiwiService;
use App\Services\TronService;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

        foreach ($checkouts as $checkout) {
            if (!isset($total[$checkout->id])) {
                $total[$checkout->id] = 0;
            }
            foreach ($checkout->items as $item) {
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

    public function paymentCheckout(PaymentCheckoutRequest $request)
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

        } elseif ($paymentSystemId == PaymentSystem::USDT) {
            $payment_id = PaymentSystem::USDT;
            TronService::setPaymentUnix();

            $wallet = Wallet::where('network_id', WalletNetwork::USDT)->get()->random();

            $qrCode = QrCode::size(150)->generate($wallet->address);

            $paymentHtml = view('newfront.cart.payment_block', [
                'wallet' => $wallet,
                'qrCode' => $qrCode->toHtml(),
                'total' => $total . '$',
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
                         * Збереження корзини
                         */
                        CartService::saveCart();

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


        } elseif ($request->payment_id == PaymentSystem::USDT) {

            $total = \App\Models\User::getUserCheckoutTotal();
            $checkout = auth()->user()->checkouts()->whereStatus(0)->first();
            $wallet = Wallet::find($request->wallet_id);

            $checkTransactions = TronService::checkTransactions($wallet);

            if ($checkTransactions) {

                $transactionStatus = $checkTransactions['transactionStatus'];
                $userTransactionStatus = $checkTransactions['userTransactionStatus'];
                $transactionValue = $checkTransactions['transactionValue'];
                $transactionId = $checkTransactions['transaction_id'];

                if ($transactionStatus && $userTransactionStatus && $transactionValue >= $total) {

                    $user = \App\Models\User::find(Auth::id());

                    $order = new Order;
                    $order->user_id = $user->id;
                    $order->checkout_id = $checkout->id;
                    $order->total = $total;
                    $order->status = Order::FINALIZED;

                    if ($order->save()) {

                        /**
                         * Збереження корзини
                         */
                        CartService::saveCart();

                        $transaction = new CryproTransaction();
                        $transaction->user_id = $user->id;
                        $transaction->order_id = $order->id;
                        $transaction->wallet_id = $wallet->id;
                        $transaction->transaction_hash = $transactionId;
                        $transaction->amount = $transactionValue;
                        $transaction->status = CryproTransaction::CONFIRMED;
                        $transaction->crypto_type = CryproTransaction::USDT;
                        $transaction->created_date = date('Y-m-d H:i:s');
                        $transaction->save();


                        /**
                         * Очищення корзини
                         */

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
