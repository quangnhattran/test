<?php

namespace App\Http\Middleware;

use Closure;

class YouMustConfirmEmail
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
        if(! auth()->user()->confirmed) {
            return redirect('/threads')->with(['flash'=>'Your email not confirmed','type'=>'danger']);
        }
        return $next($request);
    }
}
