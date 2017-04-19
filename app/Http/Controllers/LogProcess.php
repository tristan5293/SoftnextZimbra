<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class LogProcess extends Controller
{
    public function ZimbraLog(Request $request){
        $keyword = $request->input('keyword');
        $keyword_arr = explode(" ", $keyword);
        $grep_str = '';
        foreach ($keyword_arr as &$value) {
            $grep_str .= ' | grep "'.$value.'"';
        }
        $process = new Process('sudo cat /var/log/zimbra.log'.$grep_str);
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
