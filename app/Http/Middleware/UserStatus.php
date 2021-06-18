<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;

class UserStatus
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


        $user = User::where('email', '=', $request->email)->first();

        if (isset($user)) {

            if ($user->status != 0) {
                return redirect()->route('login');
            }

        }
        return $next($request);
    }
}
