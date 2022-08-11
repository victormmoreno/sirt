<?php

namespace App\Events\Proyecto;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;


class ProyectoApproveWasRequested
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $notificacion;
    public $destinatarios;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($notificacion, $destinatarios)
    {
        $this->notificacion = $notificacion;
        $this->destinatarios = $destinatarios;
    }
}
