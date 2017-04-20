<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class MountCheckProcess extends Controller
{
    public function ZimbraMount(Request $request){
        $process = new Process('sudo su - zimbra -c "df -h | grep zimbra"');
        $process->start();
        foreach ($process as $type => $data) {
            if ($process::OUT === $type) {
                return $data;
            } else {
                return $data;
            }
        }
    }
}
