<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

use App\ShutdownSpecific;

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
        $NUM = '';
        $process = new Process("sudo at $TIME $DATE < $tmpFile");
        $process->start();
        foreach ($process as $type => $data) {
            if ($process::OUT === $type) {
                $result_str .= $data;
            } else {
                if(str_contains($data, 'job')){
                    $tmp_arr = explode(" ", $data);
                    $NUM = trim($tmp_arr[1]);
                    $result_str .= $data;
                }
            }
        }
        unlink($tmpFile);

        $shut_spec = ShutdownSpecific::find(1);
        if(!empty($shut_spec)){
            $tmp = '';
            $process2 = new Process('sudo atrm '.$shut_spec->jobnumber);
            $process2->start();
            foreach ($process2 as $type => $data) {
                if ($process2::OUT === $type) {
                    $tmp .= $data;
                } else {
                    $tmp .= $data;
                }
            }
        }
        ShutdownSpecific::truncate();
        ShutdownSpecific::create([
            'date' => $DATE,
            'time' => $TIME,
            'jobnumber' => $NUM,
        ]);
        return str_replace("\n", "<br/>", $result_str);
    }
}
