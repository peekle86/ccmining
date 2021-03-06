<?php

namespace App\Console;

use App\Console\Commands\CheckDeposit;
use App\Console\Commands\CheckTransactions;
use App\Console\Commands\EarnCommand;
use App\Console\Commands\parseCrypto;
use App\Console\Commands\ParseHardCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CheckTransactions::class,
        ParseHardCommand::class,
        parseCrypto::class,
        EarnCommand::class,
        CheckDeposit::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('check:transactions')->everyMinute();
        $schedule->command('parse:hard')->everyMinute();
        $schedule->command('parse:crypto')->everyMinute();
        $schedule->command('earn:profit')->everyMinute();
        $schedule->command('check:deposit')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
