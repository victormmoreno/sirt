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
     * $event->datosIdea->gestor->user->email
     * @param  ComiteWasRegistered  $event
     * @return void
     */
    public function handle(ComiteWasRegistered $event)
    {
        if ($event->datosIdea->gestor != null) {
            Mail::to([$event->datosIdea->correo_contacto, $event->emailSession, $event->datosIdea->gestor->user->email])->send(new SendEmailIdeaComite($event->datosIdea, $event->pdf, $event->extensiones));
        } else {
            Mail::to([$event->datosIdea->correo_contacto, $event->emailSession])->send(new SendEmailIdeaComite($event->datosIdea, $event->pdf, $event->extensiones));
        }
    }
}
