<?php

namespace LaraCar\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use LaraCar\Automotive;
use LaraCar\Console\Commands\ReactiveAutoCron;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ReactiveAutoCron::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $automotives = Automotive::sale()->unavailable()->get();
        foreach ($automotives as $auto) {
            if ($auto->user()->first()->ads_limit > 0) {
                $auto->active_date = date('Y-m-d');
                $auto->save();
                $auto->ownerObject()->reduceAdsLimit();
            }
        }
        $schedule->command('reactive:cron')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
