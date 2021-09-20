<?php

namespace App\Listeners\Proyecto;

use App\Events\Proyecto\ProyectoWasApproved;
use App\Mail\Proyecto\SendEmailProyectoAprobado;
use Illuminate\Support\Facades\Mail;


class ProyectoWasApprovedInPhase
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
     * @param  ProyectoWasApproved  $event
     * @return void
     */
    public function handle(ProyectoWasApproved $event)
    {
        Mail::to($event->dinamizadores)->send(new SendEmailProyectoAprobado($event->proyecto, $event->movimiento));
    }
}
