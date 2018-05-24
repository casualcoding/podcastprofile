<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class LoggedOutOrHasAcceptedPrivacyPolicy
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
        if (!Auth::check()){
            return $next($request);
        }
        if (Auth::user()->hasAcceptedPrivacyPolicy()) {
            return $next($request);
        }
        return redirect()->route('privacyUpdate');
    }
}
