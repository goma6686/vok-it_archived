<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfNotAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard="administrator")
    {
        if(!auth()->guard($guard)->check()){
            return redirect(route('administrator.login'));
        }

        return $next($request);
    }
}
