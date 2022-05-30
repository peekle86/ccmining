<?php

namespace App\Console\Commands;

use App\Models\Checkout;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RemoveOldCheckout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:checkout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        //$ids = Checkout::whereStatus(0)->pluck('id');
        $ids = Checkout::whereStatus(0)->where('created_at', '<=', Carbon::now()->subDays(1)->toDateTimeString())->pluck('id');
        Checkout::destroy($ids);
        return Command::SUCCESS;
    }
}
