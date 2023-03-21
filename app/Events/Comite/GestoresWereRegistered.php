<?php

namespace App\Events\Comite;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class GestoresWereRegistered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $nodo;
    public $comite;
    public $emails;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($comite, $emails)
    {
        $this->comite = $comite;
        $this->emails = $emails;
        $this->nodo = $comite->ideas->first()->nodo->entidad->nombre;
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
