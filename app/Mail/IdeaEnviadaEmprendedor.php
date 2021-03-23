<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class IdeaEnviadaEmprendedor extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject = 'Idea Postulada';
    public $idea;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($idea)
    {
        $this->idea = $idea;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                ->markdown('emails.idea.Idea-enviada-emprendedor');
    }
}
