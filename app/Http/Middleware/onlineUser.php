<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class onlineUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check())
        {
            $user =  Auth::user();

            $user->visit();

            $priode =  now()->addMinute(2);
            Cache::put('user-is-online-'.$user->id , true , $priode);
        }

        return $next($request);
    }
}
