<?php

namespace App\Http\Middleware\Ourmiddleware\Role;

use Closure;
use Illuminate\Support\Facades\Auth;
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
        $roles = is_array($role)
        ? $role
        : explode('|', $role);

        foreach ($roles as $rol) {
            if (session()->get('login_role') != $rol && !Auth::user()->hasAnyRole($roles)) {
                throw UnauthorizedException::forRoles($roles);
            }
        }

        return $next($request);
    }
}
