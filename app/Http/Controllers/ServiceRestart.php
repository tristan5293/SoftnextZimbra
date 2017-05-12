<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ServiceRestart extends Controller
{
    public function AllSrvRestart(Request $request){
        $tmp = '';
        $process = new Process('sudo su - zimbra -c "/opt/zimbra/bin/zmcontrol restart"');
        $process->start();
        foreach ($process as $type => $data) {
            if ($process::OUT === $type) {
                $tmp .= $data;
            } else { // $process::ERR === $type
                $tmp .= $data;
            }
        }
        return $tmp;
    }
}
