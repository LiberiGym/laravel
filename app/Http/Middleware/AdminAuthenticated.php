<?php

namespace App\Http\Middleware;

use Closure;
class AdminAuthenticated
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
        if(auth()->check() && (auth()->user()->role_id == 3 || auth()->user()->role_id == 4))
        {
            return $next($request);
        }

        return redirect('/login');
    }
}
