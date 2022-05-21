<?php

/**
 * Configuação no cron: 0 0 * * * /usr/local/bin/php /home/megafeir/mega/artisan schedule:run 1>> /dev/null 2>&1
 * em desenvolvimento: php artisan schedule:work
 */

namespace LaraCar\Console\Commands;

use Illuminate\Console\Command;
use LaraCar\Automotive;

class ReactiveAutoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reactive:cron';

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
        $automotives = Automotive::sale()->unavailable()->get();
        foreach ($automotives as $auto) {
            if ($auto->ownerObject()->first()->ads_limit > 0) {
                $auto->active_date = date('Y-m-d');
                $auto->save();
                $auto->ownerObject()->reduceAdsLimit();
            }
        }
        return Command::SUCCESS;
    }
}
