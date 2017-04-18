<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class SyncProcess extends Controller
{
    public function SyncToZimbra(Request $request){
        //開始同步
        $process1 = new Process('sudo su - zimbra -c "/usr/bin/perl /opt/zimbra/bin/zmexternaldirsync"');
        $process1->run();
        if (!$process1->isSuccessful()) {
            throw new ProcessFailedException($process1);
        }
        $tmp1 = $process1->getOutput();

        //尋找最近一筆紀錄是在第幾行
        $process2 = new Process('sudo su - zimbra -c "grep -n 'Process Started' /opt/zimbra/log/zmexternaldirsync.log" | awk -F ":" \'{print $1}\' | tail -1');
        $process2->run();
        if (!$process2->isSuccessful()) {
            throw new ProcessFailedException($process2);
        }
        $tmp2 = $process2->getOutput();

        //從第幾行開始印，並尋找關鍵字[add_user、del_user]
        $process3 = new Process('sudo su - zimbra -c "tail -n +'.$tmp2.' /opt/zimbra/log/zmexternaldirsync.log" | grep -e 'add_user' -e 'del_user'');
        $process3->run();
        if (!$process3->isSuccessful()) {
            throw new ProcessFailedException($process3);
        }
        return $process3->getOutput();
    }
}
