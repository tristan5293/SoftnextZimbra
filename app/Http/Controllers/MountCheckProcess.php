<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class MountCheckProcess extends Controller
{
    public function ZimbraMount(Request $request){
        $process1 = new Process('sudo su - zimbra -c "df -h | head -n1"');
        $process1->run();
        if (!$process1->isSuccessful()) {
            throw new ProcessFailedException($process1);
        }
        $tmp1 = $process1->getOutput();

        $process2 = new Process('sudo su - zimbra -c "df -h | grep mapper"');
        $process2->start();
        foreach ($process2 as $type => $data) {
            if ($process2::OUT === $type) {
                return $tmp1.$data;
            } else {
                return $tmp1.$data;
            }
        }
    }
}
