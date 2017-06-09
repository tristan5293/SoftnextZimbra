<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

use App\TimeServerList;
use App\LocalTime;
use Storage;

class DateTimeProcess extends Controller
{
    public function TimeServerList(Request $request){
        $time_server_list_str = $request->input('tmpTimeServerList');
        $time_server_list = TimeServerList::find(1);
        $time_server_list->server_name = $time_server_list_str;
        $time_server_list->save();
        return '設定完成';
    }

    public function ZoneChange(Request $request){
        $zone = $request->input('zone');
        $country = $request->input('country');

        $process1 = new Process('sudo ln -sf /usr/share/zoneinfo/'.$zone.'/'.$country.' /etc/localtime');
        $process1->run();
        if (!$process1->isSuccessful()) {
            throw new ProcessFailedException($process1);
        }

        $process2 = new Process('echo "'.$zone.'/'.$country.'" | sudo tee /etc/timezone');
        $process2->run();
        if (!$process2->isSuccessful()) {
            throw new ProcessFailedException($process2);
        }

        $process3 = new Process('sudo reboot');
        $process3->run();
        if (!$process3->isSuccessful()) {
            throw new ProcessFailedException($process3);
        }
        return $process1->getOutput().'<br/>'.$process2->getOutput().'<br/>'.$process3->getOutput();
    }

    public function LocalTimeNTPdate(Request $request){
        $select_localtime = $request->input('localtime');
        $time_server_list = TimeServerList::find(1);
        $data = explode(",", $time_server_list->server_name);
        $local_time = LocalTime::find(1);
        $local_time->server_name = $data[$select_localtime-1];
        $local_time->save();

        $process = new Process('sudo ntpdate '.$data[$select_localtime-1]);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        Storage::append('/var/log/syslog', trim($process->getOutput()).' [E-Tool]'."\n");
        return $process->getOutput();
    }

    public function LocalTimeData(Request $request){
        $data = array();
        $result = array();
        $time_server_list = TimeServerList::find(1);
        $data = explode(",", $time_server_list->server_name);
        $index = 1;
        //get default index
        $local_time = LocalTime::find(1);
        $default_index = array_search($local_time->server_name, $data) + 1;
        foreach($data as &$value){
            $node = array();
            $node['id'] = $index;
            $node['text'] = $value;
            if($index == $default_index){
                $node['selected'] = true;
            }
            array_push($result, $node);
            $index++;
        }
        return $result;
    }
}
