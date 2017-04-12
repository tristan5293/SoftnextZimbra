<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class SystemProcess extends Controller
{
    public function ProcessShutdown(Request $request){
        $process = new Process('sudo shutdown -h now');
        $process->run();
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        return $process->getOutput();
    }

    public function ProcessReboot(Request $request){
        $process = new Process('sudo shutdown -r 0');
        $process->run();
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        return $process->getOutput();
    }

    public function CheckLog(Request $request){
        $keyword = $request->input('keyword');
        $keyword_arr = explode(" ", $keyword);
        $grep_str = '';
        foreach ($keyword_arr as &$value) {
            $grep_str .= ' | grep "'.$value.'"';
        }
        $process = new Process('sudo cat /root/php_errors.log'.$grep_str);
        //$process = new Process('df -h | grep ""');
        //$process = new Process('sudo ntpdate tw.pool.ntp.org');
        $process->start();
        foreach ($process as $type => $data) {
          if ($process::OUT === $type) {
              return $data;
          } else { // $process::ERR === $type
              return $data;
          }
        }
    }
}
