<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role="")
    {
        if(!\Session::has('session_id')){
            // echo "back"; die;
            //logged
            //return \Redirect::to('/');
        }
        return $next($request);
    }
}
