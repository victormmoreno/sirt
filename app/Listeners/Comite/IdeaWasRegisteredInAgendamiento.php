<?php

namespace App\Listeners\Comite;

use App\Events\Comite\AgendamientoWasRegistered;
use App\Mail\Comite\SendEmailIdeaAgendamiento;
use Illuminate\Support\Facades\Mail;
// use Illuminate\Queue\InteractsWithQueue;
// use Illuminate\Contracts\Queue\ShouldQueue;

class IdeaWasRegisteredInAgendamiento
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
     * @param  AgendamientoWasRegistered  $event
     * @return void
     */
    public function handle(AgendamientoWasRegistered $event)
    {
        Mail::to([$event->idea->correo_contacto, auth()->user()->email])->send(new SendEmailIdeaAgendamiento($event->idea, $event->comite));
    }
}
