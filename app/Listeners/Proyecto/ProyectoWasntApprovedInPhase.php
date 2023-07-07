<?php

namespace App\Listeners\Proyecto;

use App\Events\Proyecto\ProyectoWasntApproved;
use App\Mail\Proyecto\SendEmailProyectoNoAprobado;
use Illuminate\Support\Facades\Mail;

class ProyectoWasntApprovedInPhase
{

    /**
     * Handle the event.
     *
     * @param  ProyectoWasntApproved  $event
     * @return void
     */
    public function handle(ProyectoWasntApproved $event)
    {
        Mail::to([$event->proyecto->asesor->email, auth()->user()->email])->send(new SendEmailProyectoNoAprobado($event->proyecto, $event->movimiento));
    }
}
