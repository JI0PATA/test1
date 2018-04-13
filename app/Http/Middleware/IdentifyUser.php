<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IdentifyUser
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

        if ($request->login === 'admin' && $request->password === 'PassworD') {
            $request->session()->put('admin', '1');
            return redirect(route('admin'));
        }

        return $next($request);
    }
}
