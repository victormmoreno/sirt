<?php

namespace App\Mail\Support;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class AutomaticMessageSent extends Mailable
{
    use Queueable, SerializesModels;

    public $message;

    public $subject = "Solicitud Enviada";

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if(!collect($this->message['archive'])->isEmpty()){
            return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject("[Ticket ID:{$this->message['ticket']}] {$this->message['subject']}")
                    ->markdown('emails.support.automatic-message-sent')
                    ->attach($this->message['archive']->getRealPath(), [
                        'as' => $this->message['archive']->getClientOriginalName()
                    ]);
        }
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject("[Ticket ID:{$this->message['ticket']}] {$this->message['subject']}")
                    ->markdown('emails.support.automatic-message-sent');

    }



}
