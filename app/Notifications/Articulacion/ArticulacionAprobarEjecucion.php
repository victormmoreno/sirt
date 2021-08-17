<?php

namespace App\Notifications\Articulacion;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ArticulacionAprobarEjecucion extends Notification implements ShouldQueue
{
    use Queueable;
    private $articulacion;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($articulacion)
    {
        $this->setArticulacion($articulacion);
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
            'link'  => route('articulacion.ejecucion', $this->getArticulacion()->id),
            'icon'  => 'library_books',
            'color' => 'green',
            'autor' => "{$this->getArticulacion()->articulacion_proyecto->actividad->gestor->user->nombres} {$this->getArticulacion()->articulacion_proyecto->actividad->gestor->user->apellidos}",
            'text'  => "El experto ha solicitado aprobar la fase de ejecución | {$this->getArticulacion()->articulacion_proyecto->actividad->codigo_actividad} - {$this->getArticulacion()->articulacion_proyecto->actividad->nombre}",
          ];
    }

    public function setArticulacion($articulacion)
    {
        $this->articulacion = $articulacion;
    }

    public function getArticulacion()
    {
        return $this->articulacion;
    }
}
