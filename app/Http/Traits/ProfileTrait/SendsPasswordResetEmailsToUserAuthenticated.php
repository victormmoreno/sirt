<?php

namespace App\Http\Traits\ProfileTrait;

use Illuminate\Support\Facades\Password;

trait SendsPasswordResetEmailsToUserAuthenticated
{

    public function passwordReset()
    {
        $this->authorize('updatePassword', $this->getAuthUserFindByIdEloquent());
        $user = auth()->user()->only('email');


        $response = $this->broker()->sendResetLink(
            $this->credentials($user)
        );

        return $response == Password::RESET_LINK_SENT
        ? $this->sendResetLinkResponse()
        : $this->sendResetLinkFailedResponse();
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse()
    {
        return back()->with('status', 'Te enviamos un correo electrónico con las instrucciones para restablecer la contraseña.');
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse()
    {
        return back()
            ->withErrors('error', 'se ha podido enviar el correo de enlace para reestablecer tu contraseña.');
    }

    /**
     * Get the needed authentication credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials($user)
    {
        return $user;
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }

    private function getAuthUserFindByIdEloquent()
    {
        return $this->userRepository->findByIdEloquent(auth()->user()->id)->firstOrFail();
    }

}
