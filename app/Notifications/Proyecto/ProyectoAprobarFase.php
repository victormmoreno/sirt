<?php

namespace App\Notifications\Proyecto;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProyectoAprobarFase extends Notification implements ShouldQueue
{
    use Queueable;
    private $control;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($control)
    {
        $this->control = $control;
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
            'link'  => $this->control->fase->nombre == 'Concluido sin finalizar' ? route('proyecto.suspender', $this->control->notificable->id) : $this->control->notificable->present()->proyectoRutaActual(),
            'icon'  => 'library_books',
            'color' => 'green',
            'autor' => "{$this->control->remitente->nombres} {$this->control->remitente->nombres}",
            'text'  => "El experto ha solicitado aprobar la fase de {$this->control->fase->nombre} | {$this->control->notificable->codigo_proyecto} - {$this->control->notificable->nombre}",
          ];
    }

}
