<?php

namespace App\Mail\User\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordChanged extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $subject = "Contraseña cambiada";

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.users.auth.password-changed');
    }
}
