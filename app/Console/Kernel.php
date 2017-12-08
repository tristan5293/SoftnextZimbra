<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon;
use Storage;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\NTPdateLocaltimeCMD::class,
        \App\Console\Commands\SyncADAccount::class,
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
        //每日校時
        $schedule->command('sms:ntpdate_localtime')->daily();
        //每日2點自動帳號同步
        $schedule->command('sms:sync_ad_account')
                 ->withoutOverlapping()
                 //->everyMinute()
                 ->cron('0 2 * * *')
                 ->after(function () {
                     if(env('APP_OS') == "ubuntu"){
                         Storage::append('/var/log/syslog', Carbon::now().' [E-Tool][Sync Account](Auto))'."\n");
                     }else{
                         Storage::append('/var/log/messages', Carbon::now().' [E-Tool][Sync Account](Auto))'."\n");
                     }
                 });
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
