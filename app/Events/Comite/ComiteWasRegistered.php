<?php

namespace App\Events\Comite;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ComiteWasRegistered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $datosIdea;
    public $emailSession;
    public $pdf;
    public $extensiones;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($datosIdea, $pdf, $extensiones)
    {
        $this->datosIdea = $datosIdea;
        $this->pdf = $pdf;
        $this->extensiones = $extensiones;
        $this->emailSession = auth()->user()->email;
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
