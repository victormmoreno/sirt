<?php

namespace App\Notifications\Encuesta;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EncuestaRespondida extends Notification implements ShouldQueue
{
    use Queueable;
    public $proyecto;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($proyecto)
    {
        $this->proyecto = $proyecto;
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
        $this->proyecto->setQuery($this->proyecto);
        return [
            'link'  => route('proyecto.ejecucion', $this->proyecto->id),
            'icon'  => 'assignment_turned_in',
            'color' => 'bg-secondary',
            'autor' => "{$this->proyecto->getUser()->nombres} {$this->proyecto->getUser()->apellidos}",
            'text'  => "El usuario ha respondido la encuesta de satisfacción del proyecto {$this->proyecto->codigo_proyecto} - {$this->proyecto->nombre} | {$this->proyecto->resultadosEncuesta->fecha_respuesta}",
          ];
    }
}
