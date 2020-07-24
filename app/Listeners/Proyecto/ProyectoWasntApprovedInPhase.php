<?php

namespace App\Listeners\Proyecto;

use App\Events\Proyecto\ProyectoWasntApproved;
use App\Mail\Proyecto\SendEmailProyectoNoAprobado;
use Illuminate\Support\Facades\Mail;

class ProyectoWasntApprovedInPhase
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
     * @param  ProyectoWasntApproved  $event
     * @return void
     */
    public function handle(ProyectoWasntApproved $event)
    {
        Mail::to([$event->proyecto->articulacion_proyecto->actividad->gestor->user->email, auth()->user()->email])->send(new SendEmailProyectoNoAprobado($event->proyecto, $event->movimiento));
    }
}
