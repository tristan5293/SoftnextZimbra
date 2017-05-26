<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;
use Hash;

class AdminPWDChange extends Controller
{
    public function PWDChange(Request $request)
    {
        $old_pwd = $request->input('old_pwd');
        $new_pwd = $request->input('new_pwd');
        $new_pwd_again = $request->input('new_pwd_again');

        $user = Users::where('account', '=', 'admin')->first();
        if (Hash::check($old_pwd, $user->password)) {
            if ( strcmp ($new_pwd, $new_pwd_again) == 0  ){
                Users::where('account', '=', 'admin')->update(['password' => Hash::make($new_pwd)]);
                return '更改成功';
            }
        }
        return '更改失敗';
    }

    public function PWDReset(Request $request)
    {
        Users::where('account', '=', 'admin')->update(['password' => Hash::make('8888')]);
        return '更改成功';
    }
}
