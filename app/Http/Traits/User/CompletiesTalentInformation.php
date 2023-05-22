<?php

namespace App\Http\Traits\User;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RedirectsUsers;
use App\Events\User\CompletedTalentInformation;

trait CompletiesTalentInformation
{
    use RedirectsUsers;

    /**
     * Show the email complete talent information notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return $request->user()->hasCompletedTalentInformation()
                        ? redirect($this->redirectPath())
                        : view('users.complete-talent-information');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function complete(Request $request)
    {
        // if ($request->route('id') != $request->user()->getKey()) {
        //     throw new AuthorizationException;
        // }

        if ($request->user()->hasCompletedTalentInformation()) {
            return redirect($this->redirectPath());
        }

        if ($request->user()->markInformationTalentAsCompleted()) {
            event(new CompletedTalentInformation($request->user()));
        }

        return redirect($this->redirectPath())->with('completed', true);
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }
        $request->user()->sendEmailVerificationNotification();

        return back()->with('resent', true);
    }
}
