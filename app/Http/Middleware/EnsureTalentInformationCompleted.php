<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use App\Contracts\User\MustCompleteTalentInformation;

class EnsureTalentInformationCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $redirectToRoute = null, $role = null)
    {
        if (! $request->user() ||
            (
                $request->user() instanceof MustCompleteTalentInformation &&
                ($request->user()->isUserTalento() || $request->user()->isUserConvencional()) &&
                ! $request->user()->hasCompletedTalentInformation()
            )) {
            return $request->expectsJson()
                    ? abort(403, 'No has completado la información de talento.')
                    : Redirect::guest(URL::route($redirectToRoute ?: 'informationtalent.notice'));
        }

        return $next($request);
    }
}
