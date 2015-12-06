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
        if(\Session::has('session_type_user')){
            if(\Session::get('session_type_user') != $role && \Session::get('session_type_user') != "super"){
                return \Redirect::to('/dashboard');
            }
        }
        return $next($request);
    }
}
