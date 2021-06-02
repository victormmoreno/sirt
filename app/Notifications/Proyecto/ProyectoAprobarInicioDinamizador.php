<?php

namespace App\Notifications\Proyecto;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProyectoAprobarInicioDinamizador extends Notification implements ShouldQueue
{
    use Queueable;
    private $proyecto;
    private $talento;
    private $movimiento;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($proyecto, $talento, $movimiento)
    {
        $this->proyecto = $proyecto;
        $this->talento = $talento;
        $this->movimiento = $movimiento;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'link'  => route('proyecto.inicio', $this->proyecto->id),
            'icon'  => 'library_books',
            'color' => 'green',
            'autor' => "{$this->talento->nombres} {$this->talento->apellidos}",
            'text'  => "El {$this->movimiento->rol} ha aprobado la fase de {$this->movimiento->fase} | {$this->proyecto->articulacion_proyecto->actividad->codigo_actividad} - {$this->proyecto->articulacion_proyecto->actividad->nombre}",
          ];
    }

}
