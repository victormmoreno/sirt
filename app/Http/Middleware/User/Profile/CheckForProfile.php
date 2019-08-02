<?php

namespace App\Http\Middleware\User\Profile;

use Illuminate\Support\Facades\Auth;
use Closure;

class CheckForProfile
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
        // return $next($request);

         if (!Auth::user()) {
            return redirect('/home');
        }

        return $next($request);
    }
}
