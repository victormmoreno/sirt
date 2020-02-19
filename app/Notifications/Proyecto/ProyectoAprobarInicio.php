<?php

namespace App\Notifications\Proyecto;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProyectoAprobarInicio extends Notification implements ShouldQueue
{
    use Queueable;
    private $proyecto;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($proyecto)
    {
        $this->setProyecto($proyecto);
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
            'link'  => route('proyecto.inicio', $this->getProyecto()->id),
            'icon'  => 'library_books',
            'color' => 'green',
            'autor' => "{$this->getProyecto()->articulacion_proyecto->actividad->gestor->user->nombres} {$this->getProyecto()->articulacion_proyecto->actividad->gestor->user->apellidos}",
            'text'  => "El gestor ha solicitado aprobar la fase de inicio | {$this->getProyecto()->articulacion_proyecto->actividad->codigo_actividad} - {$this->getProyecto()->articulacion_proyecto->actividad->nombre}",
          ];
    }

    public function setProyecto($proyecto)
    {
        $this->proyecto = $proyecto;
    }

    public function getProyecto()
    {
        return $this->proyecto;
    }
}
