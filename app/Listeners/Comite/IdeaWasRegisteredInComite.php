<?php

namespace App\Listeners\Comite;

use App\Mail\Comite\SendEmailIdeaComite;
use App\Events\Comite\ComiteWasRegistered;
use Illuminate\Support\Facades\Mail;

class IdeaWasRegisteredInComite
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
     * $event->datosIdea->asesor->email
     * @param  ComiteWasRegistered  $event
     * @return void
     */
    public function handle(ComiteWasRegistered $event)
    {
        if ($event->datosIdea->asesor != null) {
            Mail::to([$event->datosIdea->user->email, $event->emailSession, $event->datosIdea->asesor->email])->send(new SendEmailIdeaComite($event->datosIdea, $event->pdf));
        } else {
            Mail::to([$event->datosIdea->user->email, $event->emailSession])->send(new SendEmailIdeaComite($event->datosIdea, $event->pdf));
        }
    }
}
