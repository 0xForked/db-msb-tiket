<?php

namespace App\Console;

use App\Console\Commands\DatabaseCreateCommand;
use App\Console\Commands\ExportExcelCommand;
use App\Console\Commands\MigrateDevelopmentCommand;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        DatabaseCreateCommand::class,
        MigrateDevelopmentCommand::class,
        ExportExcelCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
    }
}
