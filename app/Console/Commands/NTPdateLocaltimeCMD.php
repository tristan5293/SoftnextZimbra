<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

use App\LocalTime;
use Storage;

class NTPdateLocaltimeCMD extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:ntpdate_localtime';

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
     * @return mixed
     */
    public function handle()
    {
        $local_time = LocalTime::find(1);
        $process = new Process('sudo ntpdate '.$local_time->server_name);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        //$this->info($process->getOutput());
        Storage::append('/var/log/syslog', trim($process->getOutput()).' [E-Tool]'."\n");
    }
}
