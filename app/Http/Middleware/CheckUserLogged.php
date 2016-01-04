<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserLogged {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if(!\Session::has('session_id')){
            \Session::flash('message', trans('messages.user_session_exp.message'));
            \Session::flash('message-type', 'alert-danger');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('/');
        }
        return $next($request);
    }
}
