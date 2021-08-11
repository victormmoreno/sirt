<?php

namespace App\Notifications\ArticulacionPbt;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ArticulacionAprobarSuspendido extends Notification implements ShouldQueue
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
            'text'  => "El Articulador ha solicitado aprobar la suspensión de la articulación | {$this->articulacion->present()->articulacionCode()} - {$this->articulacion->present()->articulacionName()}",
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
