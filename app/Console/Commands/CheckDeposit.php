<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Carbon\Carbon;
use App\Models\Checkout;
use App\Models\Contract;
use App\Models\ContractPeriod;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

class CheckDeposit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:deposit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check deposits on blockexplorer';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $checkouts = Checkout::whereStatus(0)->get();

        foreach($checkouts as $checkout) {
            $this->checkExplorer($checkout);
        }

        $setting = Setting::first();
        $setting->updated_at = Carbon::now()->addHours(3);
        $setting->update();

        Log::info(Carbon::now()->addHours(3) . '_' . 'Cron Start'. "\n");
        return Command::SUCCESS;
    }

    public function aprove($checkout)
    {
        $total = 0;

        $periods = ContractPeriod::get();
        $items = $checkout->items()->get();

        foreach($checkout->items as $item) {
            $total += $item->pivot->price;
        }

        $checkout->user->userTransactions()->create([
            'type' => 1,
            'amount' => $total / $checkout->btc_price,
            'in_usd' => $total,
            'status' => 4,
            'currency_id' => 1,
        ]);

        foreach($items as $item) {
            Contract::create([
                'user_id' => $checkout->user->id,
                'hardware_id' => $item->id,
                'period_id' => $item->pivot->period_id,
                'currency_id' => $item->pivot->currency_id,
                'ended_at' => Carbon::now()->addDays( $periods->find( $item->pivot->period_id )->period ),
                'active' => 1,
                'percent' => $item->pivot->percent,
                'amount' => $item->pivot->price,
                'last_earn' => Carbon::now()
            ]);
        }

        $checkout->status = 1;
        $checkout->save();
    }

    protected function checkExplorer($checkout)
    {
        $amount = 0;

        if ($checkout->user->userWallet) {

            $address = $checkout->user->userWallet->address;

            $time_start = $checkout->created_at->timestamp;
            $time_end = $checkout->created_at->addHours(1)->timestamp;

            foreach ($checkout->items as $item) {
                $amount += $item->pivot->price;
            }

            $btc = number_format($amount / $checkout->btc_price, 8);
            $satoshi = intval(($btc) * (pow(10, 8)));

            try {
                $response = Http::get("https://www.blockchain.com/btc/address/{$address}");
                $crawler = new Crawler($response->body());
                $data = json_decode($crawler->filter('script#__NEXT_DATA__')->text())->props->initialProps->pageProps;

                if ($data->addressTransactions) {
                    foreach ($data->addressTransactions as $transaction) {

                        $trans = array_filter($transaction->outputs, function ($out) use ($address, $time_start, $time_end, $satoshi, $transaction) {
                            return $out->address == $address
                                && $transaction->time >= $time_start
                                && $transaction->time <= $time_end
                                && $out->value == $satoshi;
                        });

                        if ($trans) {

                            if (!$checkout->tx && !Checkout::where('tx', $transaction->txid)->first()) {
                                $checkout->tx = $transaction->txid;
                                if ($checkout->user->userCart) {
                                    $checkout->user->userCart->delete();
                                }

                                $checkout->save();
                            }

                            if ($checkout->tx && isset($transaction->block->height)) {
                                $this->aprove($checkout);
                                break;
                            }
                        } else {
                            if ($checkout->created_at->addHours(1)->timestamp < Carbon::now()->timestamp) {
                                $checkout->delete();
                            }
                        }
                    }
                } else {
                    if ($checkout->created_at->addHours(1)->timestamp < Carbon::now()->timestamp) {
                        $checkout->delete();
                    }
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    }
}
