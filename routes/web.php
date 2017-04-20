<?php
use Carbon\Carbon;
use App\TimeServerList;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('homepage');
});

Route::post('/login', 'Account@Login');

Route::group(['middleware' => 'account_check'], function () {

    Route::get('/index', function () {
        session(['login_time' => Carbon::now()]);
        return view('index');
    });

    Route::get('/zimbra', function () {
        session(['login_time' => Carbon::now()]);
        return view('zimbra.index');
    });

    Route::get('/reboot', function () {
        session(['login_time' => Carbon::now()]);
        return view('zimbra.reboot');
    });

    Route::get('/zimbra_log', function () {
        session(['login_time' => Carbon::now()]);
        return view('zimbra.zimbra_log');
    });

    Route::get('/audit_log', function () {
        session(['login_time' => Carbon::now()]);
        return view('zimbra.audit_log');
    });

    Route::get('/mount_check', function () {
        session(['login_time' => Carbon::now()]);
        return view('zimbra.mount_check');
    });

    Route::get('/timezone', function () {
        session(['login_time' => Carbon::now()]);
        $process = new Process('sudo cat /etc/timezone');
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $location = $process->getOutput();
        return view('zimbra.timezone', ['location' => $location]);
    });

    Route::get('/localtime', function () {
        session(['login_time' => Carbon::now()]);
        return view('zimbra.localtime');
    });

    Route::get('/time_server_list', function () {
        session(['login_time' => Carbon::now()]);
        $time_server_list = TimeServerList::find(1);
        return view('zimbra.time_server_list', ['time_server_list' => $time_server_list]);
    });

    Route::get('/location/zone', function () {
        return response()->file(public_path().'/location/Zone.json');
    });

    Route::get('/country/{country}', function ($country) {
        return response()->file(public_path().'/country/'.$country.'.json');
    });

    Route::get('/zmexternalsync', function () {
        session(['login_time' => Carbon::now()]);
        return view('zimbra.zmexternalsync');
    });

    //sync to zimbra
    Route::post('/sync_submit', 'SyncProcess@SyncToZimbra');

    //return view
    Route::get('/tcp_ipv4', 'NetworkConfig@ViewNetwrokConfig');

    //network config - update
    Route::post('/update_network_config', 'NetworkConfig@UpdateNetwrokConfig');

    //zone change
    Route::post('/zonechange', 'DateTimeProcess@ZoneChange');

    //local time - ntpdate
    Route::post('/localtime', 'DateTimeProcess@LocalTimeNTPdate');

    //local time - get combobox data
    Route::get('/localtime/data', 'DateTimeProcess@LocalTimeData');

    //time server list (新增/刪除)
    Route::post('/time_server_list', 'DateTimeProcess@TimeServerList');

    //Zimbra log file & keyword search
    Route::post('/checkZimbraLog', 'LogProcess@ZimbraLog');

    //Audit log file & keyword search
    Route::post('/checkAuditLog', 'LogProcess@AuditLog');

    //Zimbra Mount Check
    Route::post('/zimbraMountCheck', 'MountCheckProcess@ZimbraMount');

    //Ubuntu reboot & shutdown
    Route::post('/shutdown', 'SystemProcess@ProcessShutdown');
    Route::post('/reboot', 'SystemProcess@ProcessReboot');

    //Web - logut
    Route::get('/logout', 'Account@Logout');
    Route::get('/checkAutoLogout', 'Account@CheckAutoLogout');
});
