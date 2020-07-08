<?php

namespace App\Mail\Comite;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailIdeaAgendamiento extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $idea;
    public $comite;
    public $subject = "Agendamiento del CSIBT";

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($idea, $comite)
    {
        $this->idea = $idea;
        $this->comite = $comite;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))->markdown('emails.comite.send-emai-ideas-agendamiento');
    }
}
