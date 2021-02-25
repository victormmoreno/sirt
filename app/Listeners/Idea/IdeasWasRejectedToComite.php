<?php

namespace App\Listeners\Idea;

use App\Events\Idea\IdeasWasRejected;
use Illuminate\Support\Facades\Mail;
use App\Mail\Idea\IdeaRechazadaParaComite;

class IdeasWasRejectedToComite
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
     * @param  IdeasWasRejected  $event
     * @return void
     */
    public function handle(IdeasWasRejected $event)
    {
        Mail::to($event->idea->talento->user->email)->bcc(auth()->user()->email)->send(new IdeaRechazadaParaComite($event->idea, $event->motivos));
    }
}
