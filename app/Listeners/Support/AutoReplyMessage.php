<?php

namespace App\Listeners\Support;

use App\Events\Support\MessageWasSent;
use Illuminate\Support\Facades\Mail;
use App\Mail\Support\AutomaticMessageSent;

class AutoReplyMessage
{


    /**
     * Handle the event.
     *
     * @param  MessageWasSent  $event
     * @return void
     */
    public function handle(MessageWasSent $event)
    {
        Mail::to([$event->message['email'], config('app.technical_support.contact.email')])->send(new AutomaticMessageSent($event->message ));
    }
}
