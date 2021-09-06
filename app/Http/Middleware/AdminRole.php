<?php

namespace App\Http\Middleware;

use Closure;

class AdminRole
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle($request, Closure $next)
    {
        if(auth()->user()->user_type_id == 1 || auth()->user()->user_type_id == 2){
            return $next($request);
        }
        return redirect('/');
    }
}
