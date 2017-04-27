<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class SystemProcess extends Controller
{
    public function ProcessShutdown(Request $request){
        $process = new Process('sudo poweroff');
        $process->run();
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        return $process->getOutput();
    }

    public function ProcessReboot(Request $request){
        $process = new Process('sudo reboot');
        $process->run();
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        return $process->getOutput();
    }

    public function ShutdownSpecific(Request $request){
        $TIME = $request->input('shutdown_time');
        $DATE = $request->input('shutdown_date');
        $tmpFile = "/tmp/autohalt.tmp";
        $AutoHalt = "sync; sync; sync; halt -p";
        if(file_exists($tmpFile)){
            unlink($tmpFile);
        }
        $fs = fopen($tmpFile, "w");
        fwrite($fs, $AutoHalt);
        fclose($fs);
        $result_str = '';
        $process = new Process("sudo at $TIME $DATE < $tmpFile");
        $process->start();
        foreach ($process as $type => $data) {
            if ($process::OUT === $type) {
                $result_str .= $data;
            } else {
                $result_str .= $data;
            }
        }
        unlink($tmpFile);
        return $result_str;
    }
}
