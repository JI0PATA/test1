<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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

        if (!$request->session()->has('admin') && $request->route()->getPrefix() === '/admin') return redirect(route('home'));
        elseif ($request->session()->has('admin')) {
            if ($request->route()->getName() === 'login' || $request->route()->getName() === 'register') return redirect(route('home'));
        }

        return $next($request);
    }
}
