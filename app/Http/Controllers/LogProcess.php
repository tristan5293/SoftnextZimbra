<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Carbon\Carbon;

class LogProcess extends Controller
{
    public function ZimbraLog(Request $request){
        $keyword = $request->input('keyword');
        $keyword_arr = explode(" ", $keyword);
        $grep_str = '';
        $index = 0;
        foreach ($keyword_arr as &$value) {
            if($index == 0){
                $index++;
                continue;
            }else{
                $grep_str .= ' | grep "'.$value.'"';
            }
            $index++;
        }
        if($keyword_arr[0] != ''){
            $tmp = '';
            $process = new Process('sudo zgrep "'.$keyword_arr[0].'" /var/log/zimbra.log* '.$grep_str);
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

    public function MailLog(Request $request){
        $keyword = $request->input('keyword');
        $keyword_arr = explode(" ", $keyword);
        $grep_str = '';
        foreach ($keyword_arr as &$value) {
            $grep_str .= ' | grep "'.$value.'"';
        }
        $process = new Process('sudo cat /opt/zimbra/log/mailbox.log'.$grep_str);
        $process->start();
        foreach ($process as $type => $data) {
          if ($process::OUT === $type) {
              return $data;
          } else { // $process::ERR === $type
              return $data;
          }
        }
    }

    public function AuditLog(Request $request){
        $keyword = $request->input('keyword');
        $keyword_arr = explode(" ", $keyword);
        $grep_str = '';
        foreach ($keyword_arr as &$value) {
            $grep_str .= ' | grep "'.$value.'"';
        }
        $process = new Process('sudo cat /opt/zimbra/log/audit.log'.$grep_str);
        $process->start();
        foreach ($process as $type => $data) {
          if ($process::OUT === $type) {
              return $data;
          } else { // $process::ERR === $type
              return $data;
          }
        }
    }

    public function AccessLog(Request $request){
        $date_str = Carbon::today()->toDateString();
        $keyword = $request->input('keyword');
        $keyword_arr = explode(" ", $keyword);
        $grep_str = '';
        foreach ($keyword_arr as &$value) {
            $grep_str .= ' | grep "'.$value.'"';
        }
        $process = new Process('sudo cat /opt/zimbra/log/access_log.'.$date_str.$grep_str);
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
