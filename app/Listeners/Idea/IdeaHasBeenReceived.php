<?php

namespace App\Listeners\Idea;

use App\Events\Idea\IdeaHasReceived;
use App\Mail\IdeaEnviadaEmprendedor;
use Illuminate\Support\Facades\Mail;

class IdeaHasBeenReceived
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
     * @param  IdeaHasReceived  $event
     * @return void
     */
    public function handle(IdeaHasReceived $event)
    {

        Mail::to($event->idea->correo_contacto)->send(new IdeaEnviadaEmprendedor($event->idea));
    }
}
