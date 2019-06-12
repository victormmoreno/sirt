<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendNotificationPassoword extends Mailable
{
    use Queueable, SerializesModels;
    
    public $subject = 'Contraseña de ingreso a la plataforma';
    public $user;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user     = $user;
        // $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.users.send-notificacion-password');
    }
}
