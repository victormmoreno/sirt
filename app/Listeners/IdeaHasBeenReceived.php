<?php

namespace App\Listeners;

use App\Events\Idea\IdeaHasReceived;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

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
        Log::info('Idea recibida '.$event->idea->nombreproyecto);
    }
}
