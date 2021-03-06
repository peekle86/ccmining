<?php

namespace App\Console\Commands;

use App\Models\Currency;
use App\Models\Setting;
use App\Models\WalletNetwork;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class parseCrypto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:crypto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse BTC, ETH price';

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
        $coingecko = WalletNetwork::whereNotNull('coingecko')->pluck('coingecko');

        if( $coingecko ) {
            $coingecko_ids = implode(",", $coingecko->toArray());
            $response = Http::get('https://api.coingecko.com/api/v3/simple/price?ids='. $coingecko_ids .'&vs_currencies=usd');

            foreach ($response->json() as $key => $coin) {
                if( $coin['usd'] ) {

                    $wallet = WalletNetwork::where('coingecko', $key)->firstOrFail();
                    $wallet->in_usd = floatval($coin['usd']);
                    $wallet->save();

                    $currency = Currency::findOrFail($wallet->id);
                    $currency->in_usd = floatval($coin['usd']);
                    $currency->save();
                }
            }


        }



        $setting = Setting::first();
        $setting->updated_at = Carbon::now()->addHours(3);
        $setting->update();

        Log::info(Carbon::now()->addHours(3) . '_' . 'Cron Start'. "\n");
        return Command::SUCCESS;
    }
}
