<?php

namespace App\Listeners\Idea;

use App\Events\Idea\IdeasWasAccepted;
use App\Mail\Idea\{IdeaAceptadaParaComite, IdeaAceptadaParaComiteInfocenter};
use Illuminate\Support\Facades\Mail;

class IdeasWasAcceptedToComite
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
     * @param  IdeasWasAccepted  $event
     * @return void
     */
    public function handle(IdeasWasAccepted $event)
    {
        Mail::to($event->idea->user->email)->send(new IdeaAceptadaParaComite($event->idea, $event->observaciones));
        Mail::to($event->infocenters)->send(new IdeaAceptadaParaComiteInfocenter($event->idea, $event->observaciones));
    }
}
