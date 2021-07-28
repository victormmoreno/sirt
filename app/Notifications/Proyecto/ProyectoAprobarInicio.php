<?php

namespace App\Notifications\Proyecto;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProyectoAprobarInicio extends Notification implements ShouldQueue
{
    use Queueable;
    private $proyecto;
    private $fase;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($proyecto, $fase)
    {
        $this->setProyecto($proyecto);
        $this->setFase($fase);
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
            'autor' => "{$this->getProyecto()->present()->proyectoUserAsesor()}",
            'text'  => "El experto ha solicitado aprobar la fase de {$this->getFase()} | {$this->getProyecto()->articulacion_proyecto->actividad->codigo_actividad} - {$this->getProyecto()->articulacion_proyecto->actividad->nombre}",
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

    public function setFase($fase)
    {
        $this->fase = $fase;
    }

    public function getFase()
    {
        return $this->fase;
    }
}
