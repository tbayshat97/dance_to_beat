<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        //check here if the user is authenticated
        if (!Auth::guard('admin')->check() && in_array('admin', $guards)) {
            return redirect()->route('admin.login_form');
        }

        if (!Auth::guard('artist')->check() && in_array('artist', $guards)) {
            return redirect()->route('artist.login_form');
        }

        return $next($request);
    }
}
