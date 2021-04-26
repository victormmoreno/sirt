<?php

namespace App\Mail\Idea;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class IdeaAceptadaParaComiteInfocenter extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $subject = 'Se ha aceptado una idea para comité';
    public $idea;
    public $observaciones;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($idea, $observaciones)
    {
        $this->idea = $idea;
        $this->observaciones = $observaciones;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))->markdown('emails.idea.idea-aceptada-para-comite-infocenter');
    }
}
