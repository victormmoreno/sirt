<?php

namespace App\Listeners\Contact;

use App\Events\Contact\MessageWasSent;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contact\AutomaticMessageSent;

class AutoReplyMessage
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MessageWasSent  $event
     * @return void
     */
    public function handle(MessageWasSent $event)
    {
        Mail::to([$event->email])->send(new AutomaticMessageSent($event));
    }
}
