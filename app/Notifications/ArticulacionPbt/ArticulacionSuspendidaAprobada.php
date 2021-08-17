<?php

namespace App\Notifications\ArticulacionPbt;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ArticulacionSuspendidaAprobada extends Notification implements ShouldQueue
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
            'link'  => route('articulacion.suspender', $this->getArticulacion()->id),
            'icon'  => 'autorenew',
            'color' => 'orange',
            'autor' => "{$this->getArticulacion()->present()->articulacionPbtUserAsesor()}",
            'text'  => "Se aprobó la suspensión de la articulación | {$this->articulacion->present()->articulacionCode()} - {$this->articulacion->present()->articulacionName()}",
        ];
    }

    /**
     * Asigna un valor a $articulacion
     *
     * @param object $articulacion
     * @return void
     */
    private function setArticulacion($articulacion)
    {
        $this->articulacion = $articulacion;
    }

    /**
     * Retorna el valor de $articulacion
     *
     * @return object
     * @author devjul
     */
    private function getArticulacion()
    {
        return $this->articulacion;
    }
}
