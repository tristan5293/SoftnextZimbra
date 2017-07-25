<?php

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Carbon\Carbon;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get_server_time', function () {
    $process = new Process('sudo cat /etc/timezone');
    $process->run();
    if (!$process->isSuccessful()) {
        //throw new ProcessFailedException($process2);
        return $process->getErrorOutput();
    }else{
        return Carbon::now(trim($process->getOutput()));
    }
});
