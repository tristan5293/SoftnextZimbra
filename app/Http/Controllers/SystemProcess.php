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
        $shutdown_date = $request->input('shutdown_date');
        $shutdown_time = $request->input('shutdown_time');

        $file_path = public_path().'/call_php/shutdown_specific_time.php';
        $contents = Storage::get($file_path);
        $data_arr = explode("\n", $contents);
        $index = -1;
        foreach ($data_arr as &$value) {
            $index++;
            if(str_contains($value, '$TIME = ')){
                $data_arr[$index] = '$TIME = "'.$shutdown_time.'";';
                continue;
            }
            if(str_contains($value, '$DATE = ')){
                $data_arr[$index] = '$DATE = "'.$shutdown_date.'";';
                continue;
            }
        }
        Storage::put($file_path, implode("\n", $data_arr));

        $process = new Process('sudo php '.$file_path);
        $process->run();
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        return $process->getOutput();
    }
}
