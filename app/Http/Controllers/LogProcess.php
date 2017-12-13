<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Carbon\Carbon;

class LogProcess extends Controller
{
  /*
      規格: 1. 沒有輸入keywork，則查詢結果不吐資料
           2. 針對全部檔案做搜尋
  */
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
            $process = new Process('sudo zgrep -ai "'.$keyword_arr[0].'" /var/log/zimbra.log* '.$grep_str);
            $process->start();
            foreach ($process as $type => $data) {
                if ($process::OUT === $type) {
                    $tmp .= $data;
                } else { // $process::ERR === $type
                    $tmp .= $data;
                }
            }
            if($tmp == ''){
                $tmp = '查無[\''.$keyword.'\']資料';
            }
            return $tmp;
        }
    }

    public function MailLog(Request $request){
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
            $process = new Process('sudo zgrep -ai "'.$keyword_arr[0].'" /opt/zimbra/log/mailbox.log* '.$grep_str);
            $process->start();
            foreach ($process as $type => $data) {
                if ($process::OUT === $type) {
                    $tmp .= $data;
                } else { // $process::ERR === $type
                    $tmp .= $data;
                }
            }
            if($tmp == ''){
                $tmp = '查無[\''.$keyword.'\']資料';
            }
            return $tmp;
        }
    }

    public function AuditLog(Request $request){
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
            $process = new Process('sudo zgrep -ai "'.$keyword_arr[0].'" /opt/zimbra/log/audit.log* '.$grep_str);
            $process->start();
            foreach ($process as $type => $data) {
                if ($process::OUT === $type) {
                    $tmp .= $data;
                } else { // $process::ERR === $type
                    $tmp .= $data;
                }
            }
            if($tmp == ''){
                $tmp = '查無[\''.$keyword.'\']資料';
            }
            return $tmp;
        }
    }

    public function AccessLog(Request $request){
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
            $process = new Process('sudo zgrep -ai "'.$keyword_arr[0].'" /opt/zimbra/log/access_log* '.$grep_str);
            $process->start();
            foreach ($process as $type => $data) {
                if ($process::OUT === $type) {
                    $tmp .= $data;
                } else { // $process::ERR === $type
                    $tmp .= $data;
                }
            }
            if($tmp == ''){
                $tmp = '查無[\''.$keyword.'\']資料';
            }
            return $tmp;
        }
    }

    public function SysLog(Request $request){
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
            if(env('APP_OS') == "ubuntu"){
                $process = new Process('sudo zgrep -ai "'.$keyword_arr[0].'" /var/log/syslog* '.$grep_str);
            }else{
                $process = new Process('sudo zgrep -ai "'.$keyword_arr[0].'" /var/log/messages* '.$grep_str);
            }
            $process->start();
            foreach ($process as $type => $data) {
                if ($process::OUT === $type) {
                    $tmp .= $data;
                } else { // $process::ERR === $type
                    $tmp .= $data;
                }
            }
            if($tmp == ''){
                $tmp = '查無[\''.$keyword.'\']資料';
            }
            return $tmp;
        }
    }
}
