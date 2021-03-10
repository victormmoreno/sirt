<?php

namespace App\Events\Proyecto;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ProyectoApproveWasRequested
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $proyecto;
    public $talento_lider;
    public $movimiento;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($proyecto, $talento_lider, $movimiento)
    {
        $this->proyecto = $proyecto;
        $this->talento_lider = $talento_lider;
        $this->movimiento = $movimiento;
    }
}
