<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Carbon\Carbon;
use Storage;

class SyncADAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:sync_ad_account';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'AD帳號同步';

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
     * @return mixed
     */
    public function handle()
    {
        //開始同步
        try {
            if(env('APP_OS') == "ubuntu"){
                Storage::append('/var/log/syslog', Carbon::now().' [E-Tool][Sync Account](Manual))'."\n");
            }else{
                Storage::append('/var/log/messages', Carbon::now().' [E-Tool][Sync Account](Manual))'."\n");
            }

            $process1 = new Process('sudo su - zimbra -c "/usr/bin/perl /opt/zimbra/bin/zmexternaldirsync"');
            $process1->run();
            if (!$process1->isSuccessful()) {
                throw new ProcessFailedException($process1);
            }
            $tmp1 = $process1->getOutput();

            //尋找最近一筆紀錄是在第幾行
            $process2 = new Process('sudo su - zimbra -c "grep -n \'Process Started\' /opt/zimbra/log/zmexternaldirsync.log" | awk -F ":" \'{print $1}\' | tail -1');
            $process2->run();
            if (!$process2->isSuccessful()) {
                throw new ProcessFailedException($process2);
            }
            $tmp2 = trim($process2->getOutput());

            //從第幾行開始印，並尋找關鍵字[add_user、del_user]
            $process3 = new Process('sudo su - zimbra -c "tail -n +'.$tmp2.' /opt/zimbra/log/zmexternaldirsync.log" | grep -e \'add_user\' -e \'del_user\'');
            $process3->run();
            if (!$process3->isSuccessful()) {
                throw new ProcessFailedException($process3);
            }
            $this->info($process3->getOutput());
        } catch (ProcessFailedException $e) {
            $this->info($e->getMessage());
        }
    }
}
