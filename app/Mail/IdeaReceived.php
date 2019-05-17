<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class IdeaReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Idea Recibida';
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
        return $this->markdown('emails.idea-received');
    }
}
