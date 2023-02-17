<?php

namespace App\Mail\Articulation;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAccompanimentApprovalMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $notification;
    public $subject = "Solicitud de aprobación";
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($notification)
    {
        $this->notification = $notification;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))->markdown('emails.articulation.send-articulations-approval-mail');
    }
}
