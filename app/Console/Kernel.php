<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            \App\Models\Format::updatePreviousAt();
        //})->daily();
        })->dailyAt('09:00');
        
        // 本日の日付が終了日より後の場合、前回の終了日（previous_end）を更新
        $schedule->call(function () {
            \App\Models\Format::updatePreviousEnd();
        //})->daily();
        })->dailyAt('09:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        
        // SendEmailsCommandを追加
        $this->load(__DIR__.'/Commands/SendEmailsCommand.php');

        require base_path('routes/console.php');
    }
}
