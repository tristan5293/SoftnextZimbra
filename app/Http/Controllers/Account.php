<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;
use App\Personals;
use Hash;
use Cookie;
use Carbon\Carbon;

class Account extends Controller
{
    public function Login(Request $request)
    {
        $account = $request->input('login_id');
        $password = $request->input('login_pwd');
        $remeber_account = $request->has('cookie_Account') ? true : false;

        $user = Users::where('account', '=', $account)->first();

        if ($user != null) {
            if (Hash::check($password, $user->password)) {
                $roles = $user->roles()->get(); // get user roles
                $request->session()->put('account', $account);
                $request->session()->put('roles', $roles);
                $request->session()->put('login_time', Carbon::now());
                if ($remeber_account) {
                    $cookie_account = Cookie::make('cookie_account', $account, 60 * 12 * 7);
                } else {
                    $cookie_account = Cookie::forget('cookie_account');
                }
                return redirect('/index')->withCookie($cookie_account);
            }
        }

        return redirect('/')->with('msg', trans('lang.account_error'));
    }

    public function Logout(Request $request)
    {
        $request->session()->flush();

        return redirect('/');
    }

    public function CheckAutoLogout(Request $request)
    {
        $login_time = $request->session()->get('login_time');
        $diff_seconds =  Carbon::createFromFormat('Y-m-d H:i:s', $login_time)->diffInSeconds(Carbon::now());
        if($diff_seconds > 15 * 60)
        {
            return 'logout';
        }
    }

}
