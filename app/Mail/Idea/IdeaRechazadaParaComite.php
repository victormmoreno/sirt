<?php

namespace App\Mail\Idea;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class IdeaRechazadaParaComite extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $subject = 'Se le ha citado a un taller de fortalecimiento';
    public $idea;
    public $motivos;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($idea, $motivos)
    {
        $this->idea = $idea;
        $this->motivos = $motivos;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))->markdown('emails.idea.idea-rechazada-para-comite');
    }
}
