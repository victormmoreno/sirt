<?php

namespace App\Console;

use App\Console\Commands\DeleteNotifications;
use App\Console\Commands\QueueWorkCronJons;
// use App\Console\Commands\DeleteNotifications;
use App\Console\Commands\CostoAdministrativo\CreateCostoAdministrativoForYear;
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
        DeleteNotifications::class,
        QueueWorkCronJons::class,
        CreateCostoAdministrativoForYear::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('costoadministrativo:create')
                ->yearly()->monthlyOn(1, '01:00');
        // $schedule->command('costoadministrativo:create')
        //             ->everyMinute();
        $schedule->command('task:deletenotifications')->daily();

        $schedule->command('queuework:jobs')->everyMinute();
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

    protected function scheduleTimezone()
    {
        return config('app.timezone');
    }
}
