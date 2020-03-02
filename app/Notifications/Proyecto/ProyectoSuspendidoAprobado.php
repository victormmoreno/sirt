<?php

namespace App\Notifications\Proyecto;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProyectoSuspendidoAprobado extends Notification implements ShouldQueue
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
        'link'  => route('proyecto.suspender', $this->getProyecto()->id),
        'icon'  => 'library_books',
        'color' => 'green',
        'autor' => "{$this->getProyecto()->articulacion_proyecto->actividad->gestor->user->nombres} {$this->getProyecto()->articulacion_proyecto->actividad->gestor->user->apellidos}",
        'text'  => "Se aprobó la suspensión del proyecto | {$this->getProyecto()->articulacion_proyecto->actividad->codigo_actividad} - {$this->getProyecto()->articulacion_proyecto->actividad->nombre}",
      ];
    }
  
    /**
     * Asigna un valor a $proyecto
     *
     * @param object $proyecto
     * @return void
     */
    private function setProyecto($proyecto)
    {
      $this->proyecto = $proyecto;
    }
  
    /**
     * Retorna el valor de $proyecto
     *
     * @return object
     * @author dum
     */
    private function getProyecto()
    {
      return $this->proyecto;
    }
}
