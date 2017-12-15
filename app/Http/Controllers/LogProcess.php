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
            $process->setTimeout(600); // 10 minutes
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
            $process->setTimeout(600); // 10 minutes
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
            $process->setTimeout(600); // 10 minutes
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
            $process->setTimeout(600); // 10 minutes
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
        $from = $request->input('send_date_form');
        $to = $request->input('send_date_to');
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
                //計算要搜尋的範圍日期
                $from_arr = explode("-", $from);
                $to_arr = explode("-", $to);
                $dt = Carbon::create($from_arr[0], $from_arr[1], $from_arr[2], 0);
                $dt2 = Carbon::create($to_arr[0], $to_arr[1], $to_arr[2], 0);
                $search_date_range_arr = array();
                $str_messages = '';
                while($dt->gte($dt2)){
                    $search_date_range_arr[] = $dt->year.str_pad($dt->month,2,'0',STR_PAD_LEFT).str_pad($dt->day,2,'0',STR_PAD_LEFT);
                    $dt->subDay();
                }
                if($dt->eq($dt2)){
                    $str_messages = '/var/log/messages';
                }else{
                    foreach ($search_date_range_arr as &$value) {
                        $str_messages .= '/var/log/messages-'.$value.'.gz ';
                    }
                    $str_messages .= '2>/dev/null'; //代表忽略掉错误提示信息。
                }
                $process = new Process('sudo zgrep -ai "'.$keyword_arr[0].'" '.$str_messages.' '.$grep_str);
            }
            $process->setTimeout(600); // 10 minutes
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
