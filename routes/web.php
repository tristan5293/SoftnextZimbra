<?php
use Carbon\Carbon;
use App\TimeServerList;
use App\ShutdownSpecific;

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

    Route::get('/zimbra_log', function () {
        session(['login_time' => Carbon::now()]);
        return view('zimbra.zimbra_log');
    });

    Route::get('/mailbox_log', function () {
        session(['login_time' => Carbon::now()]);
        return view('zimbra.mailbox_log');
    });

    Route::get('/audit_log', function () {
        session(['login_time' => Carbon::now()]);
        return view('zimbra.audit_log');
    });

    Route::get('/access_log', function () {
        session(['login_time' => Carbon::now()]);
        return view('zimbra.access_log');
    });

    Route::get('/sys_log', function () {
        session(['login_time' => Carbon::now()]);
        return view('zimbra.sys_log');
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

    Route::get('/service', function () {
        session(['login_time' => Carbon::now()]);
        return view('zimbra.service');
    });

    Route::get('/admin_pwd_change', function () {
        session(['login_time' => Carbon::now()]);
        return view('zimbra.admin_pwd_change');
    });

    Route::get('/product_info', function () {
        session(['login_time' => Carbon::now()]);
        return view('zimbra.product_info');
    });

    //sync to zimbra
    Route::post('/sync_submit', 'SyncProcess@SyncToZimbra');

    //return view
    Route::get('/ldapsync', 'SyncXMLParser@XMLParserToView');

    //return view
    Route::get('/tcp_ipv4', 'NetworkConfig@ViewNetwrokConfig');

    //return view
    Route::get('/reboot', 'SystemProcess@ViewReboot');

    //ldapsync data save to xml file
    Route::post('/ldapsync_data', 'SyncXMLParser@DataSaveToSyncXML');

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

    //Mail log file & keyword search
    Route::post('/checkMailLog', 'LogProcess@MailLog');

    //Audit log file & keyword search
    Route::post('/checkAuditLog', 'LogProcess@AuditLog');

    //Access log file & keyword search
    Route::post('/checkAccessLog', 'LogProcess@AccessLog');

    //sys log file & keyword search
    Route::post('/checkSysLog', 'LogProcess@SysLog');

    //Zimbra Mount Check
    Route::post('/zimbraMountCheck', 'MountCheckProcess@ZimbraMount');

    //Ubuntu reboot & shutdown
    Route::post('/shutdown', 'SystemProcess@ProcessShutdown');
    Route::post('/reboot', 'SystemProcess@ProcessReboot');

    //Ubuntu shutdown specific
    Route::post('/shutdown_specific', 'SystemProcess@ShutdownSpecific');

    //Ubuntu cancel shutdown specific
    Route::post('/cancel_shutdown_specific', 'SystemProcess@CancelShutdownSpecific');

    //Zimbra All Service Restart
    Route::post('/all_srv_restart', 'ServiceRestart@AllSrvRestart');

    //Zimbra mta Service Restart
    Route::post('/mta_srv_restart', 'ServiceRestart@MtaSrvRestart');

    //Zimbra proxy Service Restart
    Route::post('/proxy_srv_restart', 'ServiceRestart@ProxySrvRestart');

    //Zimbra mailbox Service Restart
    Route::post('/mailbox_srv_restart', 'ServiceRestart@MailboxSrvRestart');

    //Zimbra spell Service Restart
    Route::post('/spell_srv_restart', 'ServiceRestart@SpellSrvRestart');

    //admin pwd change
    Route::post('/pwdChange', 'AdminPWDChange@PWDChange');

    //admin pwd reset
    Route::get('/pwdReset', 'AdminPWDChange@PWDReset');

    //Web - logut
    Route::get('/logout', 'Account@Logout');
    Route::get('/checkAutoLogout', 'Account@CheckAutoLogout');
});
