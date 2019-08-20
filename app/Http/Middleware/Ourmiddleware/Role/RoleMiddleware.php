<?php

namespace App\Http\Middleware\Ourmiddleware\Role;

use Closure;
use Illuminate\Support\{Arr, Facades\Auth};
use Spatie\Permission\Exceptions\UnauthorizedException;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (Auth::guest()) {
            throw UnauthorizedException::notLoggedIn();
        }
        $roles = is_array($role) ? $role : explode('|', $role);
        if ( !collect($roles)->contains( session()->get('login_role') ) ) {
          throw UnauthorizedException::forRoles($roles);
        }
        return $next($request);
    }
}
