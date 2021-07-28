<?php

namespace App\Notifications\Articulacion;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ArticulacionAprobarCierre extends Notification implements ShouldQueue
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
            'link'  => route('articulacion.cierre', $this->getArticulacion()->id),
            'icon'  => 'library_books',
            'color' => 'green',
            'autor' => "{$this->getArticulacion()->asesor->user->nombres} {$this->getArticulacion()->asesor->apellidos}",
            'text'  => "El experto ha solicitado aprobar la fase de cierre | {$this->getArticulacion()->articulacion_proyecto->actividad->codigo_actividad} - {$this->getArticulacion()->articulacion_proyecto->actividad->nombre}",
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
