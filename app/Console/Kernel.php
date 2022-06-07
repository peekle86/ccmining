<?php

namespace App\Console;

use App\Console\Commands\CheckDeposit;
use App\Console\Commands\CheckTransactions;
use App\Console\Commands\EarnCommand;
use App\Console\Commands\parseCrypto;
use App\Console\Commands\ParseHardCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ParseHardCommand::class,
        parseCrypto::class,
        EarnCommand::class,
        CheckDeposit::class,
        CheckTransactions::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('parse:hard')->everyMinute();
        $schedule->command('parse:crypto')->everyMinute();
        $schedule->command('earn:profit')->everyMinute();
        $schedule->command('check:deposit')->everyMinute();
        $schedule->command('check:transactions')->everyMinute();
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
