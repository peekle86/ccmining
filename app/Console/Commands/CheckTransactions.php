<?php

namespace App\Console\Commands;

use App\Models\CryproTransaction;
use App\Models\Order;
use App\Models\UserTransaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CheckTransactions extends Command
{
    protected $signature = 'check:transactions';


    protected $description = 'Check Transactions';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $transactions = CryproTransaction::where('status', CryproTransaction::UNCONFIRMED)
            ->where('crypto_type', CryproTransaction::BTC)
            ->get();

        foreach ($transactions as $transaction) {

            $txn = file_get_contents("https://blockchain.info/rawtx/$transaction->transaction_hash");
            if ($txn) {
                $txn = json_decode($txn, true);

                File::append('transactions.txt', date('Y-m-d H:i:s') . " 1. Отримано транзакцію id:$transaction->id hash: $transaction->transaction_hash \n");

                if ($txn['block_index'] && $txn['block_height']) {
                    $transaction->status = CryproTransaction::CONFIRMED;
                    $transaction->update();

                    File::append('transactions.txt', date('Y-m-d H:i:s') . " 2. Змінено статус транзакції на " . CryproTransaction::CONFIRMED . "\n");
                }

                if ($transaction->status == CryproTransaction::CONFIRMED) {

                    if ($transaction->order_id) {
                        $order = Order::find($transaction->order_id);

                        if ($order) {
                            $order->status = Order::FINALIZED;
                            if ($order->update()) {

                                $contracts = $order->contracts;
                                if ($contracts) {
                                    foreach ($contracts as $contract) {
                                        $contract->active = 1;
                                        $contract->update();
                                    }
                                }
                                File::append('transactions.txt', date('Y-m-d H:i:s') . " 3.1 Змінено статус заявки order_id: $order->id на " . Order::FINALIZED . ', (Оплата)' . "\n\n");
                            }
                        }
                    }

                }

            }


        }

        return true;
    }
}
