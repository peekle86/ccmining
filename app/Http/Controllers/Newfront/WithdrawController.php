<?php

namespace App\Http\Controllers\Newfront;

use App\Models\Currency;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class WithdrawController extends Controller
{
    public function index()
    {
        $balances = auth()->user()->userBalances()->get();
        $currencies = Currency::all();
        return view('newfront.withdraw', compact('balances', 'currencies'));
    }

    public function history()
    {
        $transactions = auth()->user()->userTransactions()->where('type', 4)->orderBy('id', 'desc')->get();

        return view('newfront.withdraw_history', compact('transactions'));
    }

    public function post(Request $request)
    {
        $user = auth()->user();

        $currency = Currency::findOrFail($request->currency);

        $validatedData = $request->validate([
            'amount' => ['required', 'numeric'],
            'address' => ['required'],
            'currency' => ['required', 'numeric'],
        ]);

        if( $currency->min_withdrawal > $validatedData['amount'] ) {
            throw ValidationException::withMessages(
                ['amount' => 'min amount is ' . $currency->min_withdrawal . ' ' . $currency->symbol ]
            );
        }

        $balance = optional(auth()->user()->userBalances())->where('currency_id', $validatedData['currency'])->first();
        if( !$balance || $balance->amount < $validatedData['amount'] ) {
            throw ValidationException::withMessages(['amount' => 'insufficient funds']);
        }

        $user->userTransactions()->create([
            'type' => 4,
            'amount' => $validatedData['amount'],
            'status' => 1,
            'currency_id' => $validatedData['currency'],
            'target' => $validatedData['address']

        ]);

        $balance->decrement('amount', $validatedData['amount']);
        $balance->save();

        return redirect(route('newfront.withdraw.hisory'));
    }

}
