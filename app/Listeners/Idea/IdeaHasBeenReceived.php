<?php

namespace App\Listeners\Idea;

use App\Events\Idea\IdeaHasReceived;
use App\Mail\Comite\SendEmailIdeaComite;
use App\Mail\IdeaEnviadaEmprendedor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
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
        // Log::info('Idea recibida '.$event->idea->nombreproyecto);
        Mail::to($event->idea->correo_contacto)->send(new IdeaEnviadaEmprendedor($event->idea));
    }
}
