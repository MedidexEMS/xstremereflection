<?php

namespace Vanguard\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Vanguard\Plugins\Vanguard;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'Vanguard\Console\Commands\JobReschedule',
        'Vanguard\Console\Commands\ServiceReminder',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        //$schedule->command('workorder:completed')->everyMinute();

        $schedule->command('job:reschedule')->dailyAt('8:00');

        $schedule->command('service:reminder')->dailyAt('8:10');
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
