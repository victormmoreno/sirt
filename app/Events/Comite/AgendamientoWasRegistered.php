<?php

namespace App\Events\Comite;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class AgendamientoWasRegistered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $idea;
    public $comite;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($idea, $comite)
    {
        $this->idea = $idea;
        $this->comite = $comite;
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
