<?php

namespace App\Http\Controllers\Newfront;

use App\Http\Controllers\Controller;
use App\Models\ContractPeriod;
use Illuminate\Http\Request;
use App\Http\Controllers\Newfront\FarmController;
use App\Http\Helpers\CartHelper;
use App\Models\Cart;
use App\Models\Currency;
use App\Models\Setting;
use App\Models\Wallet;

class CartController extends Controller
{
    public $settings;
    public $currencies;

    public function __construct()
    {
        $this->settings = Setting::whereActive(1)->first(['price_kwt']);
        $this->currencies = Currency::whereActive(1)->get();
    }

    public function index()
    {
        $items = array();
        $cloud = array();
        $hard = array();
        $user = auth()->user();
        $cart = $user->userCart ?? false;
        $checkouts = $user->checkouts()->whereStatus(0)->get();

        $periods = ContractPeriod::get();
        $settings = $this->settings;
        $currencies = $this->currencies;
        $Farm = new FarmController;

        if($cart) {
            $items = $cart->items()->with('algoritm')->get(['id', 'price', 'model', 'hashrate', 'power', 'algoritm_id', 'profitability', 'url']);
            $cloud = $items->where('algoritm_id', 5)->all();
            $hards = $items->where('algoritm_id', '!=', 5)->all();
        }
        return view('newfront.cart', compact('checkouts', 'user', 'cart', 'items', 'cloud', 'hards', 'periods', 'settings', 'Farm', 'currencies'));
    }

    public function firstOrCreateCart()
    {
        return Cart::firstOrCreate([
            'user_id' => auth()->id(),
            'total' => null
        ]);
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'hard_id' => 'required|numeric'
        ]);

        $cart = $this->firstOrCreateCart();

        if( $request->input('period_id') || $request->input('amount') ) {
            $cart->items()->attach($data['hard_id'], [
                'period_id' => $request->input('period_id') ?? 1,
                'percent' => $request->input('percent') ?? 100,
                'amount' => $request->input('amount') ?? ''
            ]);
        } else {
            $cart->items()->attach([$data['hard_id']]);
        }

        return $cart;
    }

    public function del(Request $request)
    {
        $data = $request->validate([
            'hard_id' => 'required|numeric'
        ]);

        return auth()->user()->userCart->items()->detach([$data['hard_id']]);
    }

    public function checkout(Request $request)
    {
        $helpers = new CartHelper;

        if( $request->cart_items ) {

            $user = auth()->user();
            $cart = $user->userCart;
            $items = $cart->items;

            $checkout = $user->checkouts()->whereStatus(0)->whereNull('tx')->first();
            if( $checkout ) {
                $checkout->delete();
            }

            $checkout = $user->checkouts()->create([
                'btc_price' => $this->currencies->where('symbol','BTC')->first()->in_usd
            ]);
            //dd($request->cart_items);
            foreach($items as $key => $item) {
                $checkout->items()->attach($item, [
                    'percent'   => $request->cart_items[$key]['percent'] ?? 100,
                    'period_id' => $request->cart_items[$key]['period_id'],
                    'currency_id'     => $request->cart_items[$key]['currency_id'],
                    'price'     => $request->cart_items[$key]['price']
                ]);
            }

            //$cart->delete();
            $this->getAddress();
        }
    }

    public function checkoutClud(Request $request)
    {
        $helpers = new CartHelper;

        if( $request->cart_items ) {

            $user = auth()->user();
            $cart = $user->userCart;
            $items = $cart->items;

            $checkout = $user->checkouts()->create();

            foreach($items as $item) {
                $checkout->items()->attach($item, [
                    'percent'   => 100,
                    'period_id' => $request->cart_items[$item->id]['period_id'],
                    'currency_id'     => $request->cart_items[$item->id]['currency_id'],
                    'price'     => $request->cart_items[$item->id]['price']
                ]);
            }

            $cart->delete();
            $this->getAddress();
        }
    }

    // public function cancel(Request $request)
    // {
    //     $cart = auth()->user()->userCart->findOrFail($request->cart_id);
    //     $cart->confirmed = 0;
    //     $cart->total = 0;
    //     $cart->save();
    // }

    // public function payed(Request $request)
    // {
    //     $cart = auth()->user()->userCart->where('confirmed', 0)->findOrFail($request->cart_id);
    //     $cart->confirmed = 1;
    //     $cart->save();
    // }

    public function getAddress()
    {
        if( ! isset(auth()->user()->userWallet) ) {
            $wallet = Wallet::whereNull('user_id')->first();
            if( $wallet ) {
                $wallet->user_id = auth()->id();
                $wallet->save();
                echo json_encode($wallet->address);
                return;
            } else {
                echo json_encode('Contact Support');
                return;
            }
        }
        echo json_encode(auth()->user()->userWallet->address);
        return;
    }
}
