<?php

namespace App\Listeners\Comite;

use App\Mail\Comite\SendEmailIdeaComite;
use App\Events\Comite\ComiteWasRegistered;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
     *
     * @param  ComiteWasRegistered  $event
     * @return void
     */
    public function handle(ComiteWasRegistered $event)
    {
        Mail::to([$event->datosIdea->correo_contacto, auth()->user()->email])->send(new SendEmailIdeaComite($event->datosIdea, $event->pdf));
    }
}
