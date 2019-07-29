<?php

namespace App\Listeners\User\Auth\ResetPassword;

use App\Mail\User\Auth\PasswordChanged;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class LogSuccessfulPasswordReset
{

    public $user;
    public $subject = 'Contraseña Cambiada';
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PasswordReset  $event
     * @return void
     */
    public function handle(PasswordReset $event)
    {
        Mail::to($event->user->email)->send(new PasswordChanged($event->user));
    }
}
