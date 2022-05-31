<?php

namespace App\Listeners\Proyecto;

use App\Events\Proyecto\ProyectoApproveWasRequested;
use Illuminate\Support\Facades\Mail;
use App\Mail\Proyecto\SendEmailAprobarProyecto;

class ProyectoApproveWasRequestedInPhase
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
     * @param  ProyectoApproveWasRequested  $event
     * @return void
     */
    public function handle(ProyectoApproveWasRequested $event)
    {
        Mail::to($event->destinatarios)->send(new SendEmailAprobarProyecto($event->notificacion));
    }
}

