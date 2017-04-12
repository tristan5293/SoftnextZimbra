<?php

namespace App\Http\Middleware;

use Closure;

class AccountCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $account = $request->session()->get('account');
        if (!isset($account)) {
            return redirect('/');
        }
        return $next($request);
    }
}
