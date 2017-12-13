<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class NetworkConfig extends Controller
{
    public function ViewNetwrokConfig(Request $request){
        if(env('APP_OS') == "ubuntu"){
            $request->session()->put('login_time', Carbon::now());
            $file_path = '/etc/network/interfaces';
            $contents = Storage::get($file_path);
            if(str_contains($contents, 'The primary network interface')){
                $msg = '';
                $data_arr = explode("\n", $contents);
                $primary_network_key = false;
                foreach ($data_arr as &$value) {
                    //先找到標題在取得內容
                    if(str_contains($value, 'The primary network interface')){
                        $primary_network_key = true;
                    }
                    if($primary_network_key){
                        if(str_contains($value, 'address')){
                            $tmp = explode(" ", $value);
                            $address = trim($tmp[1]);
                        }
                        if(str_contains($value, 'netmask')){
                            $tmp = explode(" ", $value);
                            $netmask = trim($tmp[1]);
                        }
                        if(str_contains($value, 'gateway')){
                            $tmp = explode(" ", $value);
                            $gateway = trim($tmp[1]);
                        }
                        if(str_contains($value, 'dns-nameservers')){
                            $tmp = explode(" ", $value);
                            $dns1 = $dns2 = '';
                            $index = 0;
                            foreach($tmp as &$val){
                                if($index > 0){
                                    ${"dns".$index} = trim($val);
                                }
                                $index++;
                            }
                        }
                    }
                }
                return view('zimbra.conn_conf', ['address' => $address,
                                                 'netmask' =>$netmask ,
                                                 'gateway' => $gateway,
                                                 'dns1' => $dns1,
                                                 'dns2' => $dns2,
                                                 'msg' => $msg]);
            }else{
                $msg = '尚未設定網路資訊';
                return view('zimbra.conn_conf', ['address' => '',
                                                 'netmask' =>'' ,
                                                 'gateway' => '',
                                                 'dns1' => '',
                                                 'dns2' => '',
                                                 'msg' => $msg]);
            }
        }else{
            $request->session()->put('login_time', Carbon::now());
            $file_path = '/etc/sysconfig/network-scripts/ifcfg-eth0';
            $contents = Storage::get($file_path);
            $data_arr = explode("\n", $contents);
            $msg = '';
            $address = '';
            $netmask = '';
            $gateway = '';
            $dns1 = '';
            $dns2 = '';
            foreach ($data_arr as &$value) {
                if(str_contains($value, 'IPADDR0')){
                    $tmp = explode("=", $value);
                    $address = trim($tmp[1]);
                }
                if(str_contains($value, 'NETMASK0')){
                    $tmp = explode("=", $value);
                    $netmask = trim($tmp[1]);
                }
                if(str_contains($value, 'GATEWAY0')){
                    $tmp = explode("=", $value);
                    $gateway = trim($tmp[1]);
                }
                if(str_contains($value, 'DNS1')){
                    $tmp = explode("=", $value);
                    $dns1 = trim($tmp[1]);
                }
                if(str_contains($value, 'DNS2')){
                    $tmp = explode("=", $value);
                    $dns2 = trim($tmp[1]);
                }
            }
            return view('zimbra.conn_conf', ['address' => $address,
                                             'netmask' =>$netmask ,
                                             'gateway' => $gateway,
                                             'dns1' => $dns1,
                                             'dns2' => $dns2,
                                             'msg' => $msg]);
        }
    }

    public function UpdateNetwrokConfig(Request $request){
        $ip = $request->input('ip');
        $netmask = $request->input('netmask');
        $gateway = $request->input('gateway');
        $master_dns = $request->input('master_dns');
        $slave_dns = $request->input('slave_dns');

        if(env('APP_OS') == "ubuntu"){
            $file_path = '/etc/network/interfaces';
            $contents = Storage::get($file_path);
            if(str_contains($contents, 'The primary network interface')){
                $index = -1;
                $data_arr = explode("\n", $contents);
                $primary_network_key = false;
                foreach ($data_arr as &$value) {
                    $index++;
                    //先找到標題在取得內容
                    if(str_contains($value, 'The primary network interface')){
                        $primary_network_key = true;
                        continue;
                    }
                    if($primary_network_key){
                        if(str_contains($value, 'address')){
                            $get_origin_ip = explode(" ", $data_arr[$index]);
                            $data_arr[$index] = "address ".$ip;
                            continue;
                        }
                        if(str_contains($value, 'netmask')){
                            $data_arr[$index] = "netmask ".$netmask;
                            continue;
                        }
                        if(str_contains($value, 'gateway')){
                            $data_arr[$index] = "gateway ".$gateway;
                            continue;
                        }
                        if(str_contains($value, 'dns-nameservers')){
                            $data_arr[$index] = trim("dns-nameservers ".$master_dns." ".$slave_dns);
                            break;
                        }
                    }
                }
                Storage::put($file_path, implode("\n", $data_arr));
                //$contents = Storage::get($file_path);
                //對/etc/hosts進行修改ip
                $file_path = '/etc/hosts';
                $contents = Storage::get($file_path);
                if(str_contains($contents, $get_origin_ip[1])){
                    $index = -1;
                    $tmp_data = explode("\n", $contents);
                    foreach ($tmp_data as &$value) {
                        $index++;
                        if(str_contains($value, $get_origin_ip[1])){
                            $index_2 = -1;
                            $tmp_arr = explode("\t", $tmp_data[$index]);
                            foreach ($tmp_arr as &$tmp_val) {
                                $index_2++;
                                if(str_contains($tmp_val, $get_origin_ip[1])){
                                    $tmp_arr[$index_2] = $ip;
                                    break;
                                }
                            }
                            $tmp_data[$index] = implode("\t", $tmp_arr);
                            break;
                        }
                    }
                    Storage::put($file_path, implode("\n", $tmp_data));
                }
                //restart network
                //$process = new Process('sudo ip addr flush ens33 && systemctl restart networking.service');
                $process = new Process('sudo reboot');
                $process->run();
                // executes after the command finishes
                if (!$process->isSuccessful()) {
                    throw new ProcessFailedException($process);
                }
                return str_replace("\n","<br/>", $process->getOutput());
            }else{
                //第一次設定網路(當下設定完必，沒有重開是因為TSD還要做其他設定,ex:/etc/hosts)
                Storage::append($file_path, "\n# The primary network interface");
                Storage::append($file_path, "auto eth0");
                Storage::append($file_path, "iface eth0 inet static");
                Storage::append($file_path, "address ".$ip);
                Storage::append($file_path, "netmask ".$netmask);
                Storage::append($file_path, "gateway ".$gateway);
                Storage::append($file_path, trim("dns-nameservers ".$master_dns." ".$slave_dns)."\n");
                return '設定完成';
            }
        }else{
            $file_path = '/etc/sysconfig/network-scripts/ifcfg-eth0';
            $contents = Storage::get($file_path);
            $index = -1;
            $data_arr = explode("\n", $contents);
            foreach ($data_arr as &$value) {
                $index++;
                if(str_contains($value, 'IPADDR0')){
                    $get_origin_ip = explode("=", $data_arr[$index]);
                    $data_arr[$index] = "IPADDR0=".$ip;
                    continue;
                }
                if(str_contains($value, 'NETMASK0')){
                    $data_arr[$index] = "NETMASK0=".$netmask;
                    continue;
                }
                if(str_contains($value, 'GATEWAY0')){
                    $data_arr[$index] = "GATEWAY0=".$gateway;
                    continue;
                }
                if(str_contains($value, 'DNS1')){
                    $data_arr[$index] = "DNS1=".$master_dns;
                    continue;
                }
                if(str_contains($value, 'DNS2')){
                    $data_arr[$index] = "DNS2=".$slave_dns;
                    break;
                }
            }
            Storage::put($file_path, implode("\n", $data_arr));
            //對/etc/hosts進行修改ip, 使用tab去切，不用空白
            $file_path = '/etc/hosts';
            $contents = Storage::get($file_path);
            if(str_contains($contents, $get_origin_ip[1])){
                $index = -1;
                $tmp_data = explode("\n", $contents);
                foreach ($tmp_data as &$value) {
                    $index++;
                    if(str_contains($value, $get_origin_ip[1])){
                        $index_2 = -1;
                        $tmp_arr = explode("\t", $tmp_data[$index]);
                        foreach ($tmp_arr as &$tmp_val) {
                            $index_2++;
                            if(str_contains($tmp_val, $get_origin_ip[1])){
                                $tmp_arr[$index_2] = $ip;
                                break;
                            }
                        }
                        $tmp_data[$index] = implode("\t", $tmp_arr);
                        break;
                    }
                }
                Storage::put($file_path, implode("\n", $tmp_data));
            }
            $process = new Process('sudo reboot');
            $process->run();
            // executes after the command finishes
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
            return str_replace("\n","<br/>", $process->getOutput());
        }
    }
}
