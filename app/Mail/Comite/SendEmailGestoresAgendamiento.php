<?php

namespace App\Mail\Comite;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailGestoresAgendamiento extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $comite;
    public $nodo;
    public $subject = "Agendamiento del CSIBT - Gestores";

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($comite, $nodo)
    {
        $this->comite = $comite;
        $this->nodo = $nodo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))->markdown('emails.comite.send-email-gestores-agendamiento');
    }
}
