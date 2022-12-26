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
        if (session()->get('login_role') == 'Administrador') {
            return $next($request);
        }
        $roles = is_array($role) ? $role : explode('|', $role);
        if ( !collect($roles)->contains( session()->get('login_role') ) ) {
            //throw UnauthorizedException::forRoles($roles);
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        return $next($request);
    }
}
