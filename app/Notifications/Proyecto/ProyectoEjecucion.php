<?php

namespace App\Notifications\Proyecto;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProyectoEjecucion extends Notification implements ShouldQueue
{
    use Queueable;
    private $proyecto;
    private $fecha;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($proyecto, $fecha)
    {
        $this->proyecto = $proyecto;
        $this->fecha = $fecha;
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
            'link'  => $this->proyecto->present()->proyectoRutaActual(),
            'icon'  => 'library_books',
            'color' => 'green',
            'autor' => "{$this->proyecto->asesor->nombres} {$this->proyecto->asesor->apellidos}",
            'text'  => "El experto ha registrado una fecha para finalizar la ejecución del proyecto {$this->proyecto->codigo_proyecto} - {$this->proyecto->nombre} | {$this->fecha}",
          ];
    }

}
