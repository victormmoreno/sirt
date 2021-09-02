<?php

namespace App\Mail\User\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotificationPassoword extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject;
    public $user;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$password, $subject = null)
    {
        $this->user     = $user;
        $this->password = $password;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.users.auth.send-notificacion-password')
                    ->subject($this->subject);
    }
}
