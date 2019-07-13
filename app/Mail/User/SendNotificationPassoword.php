<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotificationPassoword extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    
    public $subject = 'Contraseña de ingreso a Plataforma Red Tecnoparque Colombia';
    public $user;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$password)
    {
        $this->user     = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.users.send-notificacion-password')
                    ->subject('Contraseña de ingreso a  '.config('app.name'));
                    
                    // ->attach(public_path('\images\favicon.ico'));
                    // ->attach(public_path('\images\favicon.ico'), [
                    //     'as' => 'name.png',
                    //     'mime' => 'application/png',
                    // ]);

    }
}
