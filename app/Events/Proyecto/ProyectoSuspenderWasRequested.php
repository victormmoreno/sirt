<?php

namespace App\Events\Proyecto;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ProyectoSuspenderWasRequested
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $proyecto;
    public $movimiento;
    public $dinamizadores;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($proyecto, $movimiento, $dinamizadores)
    {
        $this->proyecto = $proyecto;
        $this->movimiento = $movimiento;
        $this->dinamizadores = $dinamizadores;
    }
    
}
