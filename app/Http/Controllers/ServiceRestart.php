<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

use App\Events\ReceiveProcessMessageEvent;

class ServiceRestart extends Controller
{
    public function AllSrvRestart(Request $request){
        $process = new Process('sudo su - zimbra -c "/opt/zimbra/bin/zmcontrol restart"');
        $process->setTimeout(600); // 10 minutes
        $process->start();
        foreach ($process as $type => $data) {
            if ($process::OUT === $type) {
                event(new ReceiveProcessMessageEvent(trim($data)));
            } else { // $process::ERR === $type
                event(new ReceiveProcessMessageEvent(trim($data)));
            }
        }
        return '重啟完成';
    }

    public function MtaSrvRestart(Request $request){
        $process = new Process('su - zimbra -c "/opt/zimbra/bin/zmmtactl restart"');
        $process->setTimeout(300); // 5 minutes
        $process->start();
        foreach ($process as $type => $data) {
            if ($process::OUT === $type) {
                event(new ReceiveProcessMessageEvent(trim($data)));
            } else { // $process::ERR === $type
                event(new ReceiveProcessMessageEvent(trim($data)));
            }
        }
        return '重啟完成';
    }
}
