<?php

namespace App\Events\Proyecto;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ProyectoWasntApproved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $proyecto;
    public $movimiento;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($proyecto, $movimiento)
    {
        $this->proyecto = $proyecto;
        $this->movimiento = $movimiento;
    }

}
