<?php

namespace App\Http\Middleware;

use Closure;

class LocalResponse
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
        if($request->header('local')){
            app()->setLocale($request->header('local'));
        }
        return $next($request);
    }
}
