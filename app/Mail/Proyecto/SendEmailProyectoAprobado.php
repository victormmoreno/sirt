<?php

namespace App\Mail\Proyecto;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailProyectoAprobado extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $proyecto;
    public $movimiento;
    public $subject = "Fase de proyecto aprobada";

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($proyecto, $movimiento)
    {
        $this->proyecto = $proyecto;
        $this->movimiento = $movimiento;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))->markdown('emails.proyecto.send-emai-proyecto-aprobado');
    }
}
