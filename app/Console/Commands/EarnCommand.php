<?php

namespace App\Console\Commands;

use App\Models\Balance;
use Carbon\Carbon;
use App\Models\Contract;
use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class EarnCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'earn:profit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Earn profit';

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
        for ($i=0; $i < 100; $i++) {
            $contracts = Contract::whereActive(1)->where('last_earn', '<=', Carbon::now()->subHours(1)->toDateTimeString())->get();
            //dd($contracts);
            if( $contracts->count() ) {
                foreach($contracts as $contract) {
                    if( $contract->last_earn->addHours(1) < $contract->ended_at ) {

                        $profit = $this->getHourProfit($contract);
                        $this->addTransaction($contract, 3, $profit); // Earn

                        if( $contract->hardware->algoritm_id != 5 ) {
                            $electr = $this->getHourElectr($contract);
                            $this->addTransaction($contract, 6, $electr); // Electr
                        }
                        $contract->last_earn = $contract->last_earn->addHours(1);

                    } else {
                        $contract->active = 0;
                        $this->addTransaction($contract, 7, $contract->amount); // Return
                    }
                    $contract->save();
                }
            }
        }
        // $contracts = Contract::whereActive(1)->where('last_earn', '<=', Carbon::now()->subHours(1)->toDateTimeString())->get();
        // if( $contracts->count() ) {
        //     foreach($contracts as $contract) {
        //         if( $contract->last_earn->addHours(1) < $contract->ended_at ) {
        //             $profit = $this->getHourProfit($contract);
        //             $electr = $this->getHourElectr($contract);
        //             $this->addTransaction($contract, 3, $profit); // Earn
        //             $this->addTransaction($contract, 6, $electr); // Electr
        //         } else {
        //             $contract->active = 0;
        //         }
        //         $contract->save();
        //     }
        // }
        $setting = Setting::first();
        $setting->updated_at = Carbon::now()->addHours(3);
        $setting->update();

        Log::info(Carbon::now()->addHours(3) . '_' . 'Cron Start'. "\n");
        return Command::SUCCESS;
    }

    public function getHourProfit( $contract )
    {
        if( $contract->hardware->algoritm_id == 5 ) {
            return floatval($contract->hardware->profitability / 360 / 24 * $contract->amount / 100);
        } else {
            $profit = floatval($contract->hardware->profitability);
            return floatval($profit / 24 / 100 * $contract->percent);
        }

    }

    public function getHourElectr( $contract )
    {
        $price_kwt = Setting::whereActive(1)->first()->price_kwt;
        return $contract->hardware->power / 1000 / 100 * $contract->percent * $price_kwt;
    }

    public function convertCurrency($contract, $in_usd)
    {
        return [
            'currency_id' => $contract->currency->id,
            'amount' => $in_usd / $contract->currency->in_usd,
        ];
    }

    public function addTransaction($contract, $type_id, $amount)
    {
        $convAmount = $this->convertCurrency( $contract, $amount );
        $contract->transactions()->create([
            'created_at' => $contract->last_earn,
            'user_id' => $contract->user_id,
            'type' => $type_id,
            'amount' => $convAmount['amount'],
            'in_usd' => $amount,
            'status' => 4,
            'currency_id' => $convAmount['currency_id']
        ]);
        $this->changeBalance($contract, $type_id, $convAmount);
    }

    public function changeBalance($contract, $type_id, $convAmount)
    {
        $balance = Balance::firstOrCreate([
            'currency_id' => $convAmount['currency_id'],
            'user_id' => $contract->user->id
        ], [
            'amount' => 0
        ]);

        if( $type_id == 6 ) {
            $balance->decrement('amount', $convAmount['amount']);
        } else {
            $balance->increment('amount', $convAmount['amount']);
        }
        $balance->save();
    }
}
