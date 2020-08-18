<?php

namespace App\Listeners\Comite;

use App\Events\Comite\GestoresWereRegistered;
use App\Mail\Comite\SendEmailGestoresAgendamiento;
use Illuminate\Support\Facades\Mail;

class GestoresWereRegisteredInAgendamiento
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
     * @param  GestoresWereRegistered  $event
     * @return void
     */
    public function handle(GestoresWereRegistered $event)
    {
        Mail::to($event->emails)->send(new SendEmailGestoresAgendamiento($event->comite, $event->nodo));
    }
}
