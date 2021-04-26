<?php

namespace App\Events\Idea;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class IdeasWasAccepted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $idea;
    public $infocenters;
    public $observaciones;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($idea, $infocenters, $observaciones)
    {
        $this->idea = $idea;
        $this->infocenters = $infocenters;
        $this->observaciones = $observaciones;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
