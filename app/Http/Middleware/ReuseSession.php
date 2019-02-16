<?php

namespace App\Http\Middleware;

use Closure;

class ReuseSession
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
        if(isset($request->token)
        || ($request->token != null))
            session()->setId($request->token);

        session()->start();

        return $next($request);
    }
}
