<?php

namespace App\Listeners\Proyecto;

use App\Events\Proyecto\ProyectoSuspenderWasRequested;
use Illuminate\Support\Facades\Mail;
use App\Mail\Proyecto\SendEmailAprobarSuspenderProyecto;

class ProyectoSuspenderWasRequestedExperto
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
     * @param  ProyectoSuspenderWasRequested  $event
     * @return void
     */
    public function handle(ProyectoSuspenderWasRequested $event)
    {
        Mail::to($event->dinamizadores)->send(new SendEmailAprobarSuspenderProyecto($event->proyecto, $event->movimiento));
    }
}
