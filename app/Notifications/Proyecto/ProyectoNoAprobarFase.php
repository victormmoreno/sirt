<?php

namespace App\Notifications\Proyecto;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProyectoNoAprobarFase extends Notification implements ShouldQueue
{
    use Queueable;
    private $proyecto;
    private $movimiento;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($proyecto, $movimiento)
    {
        $this->setProyecto($proyecto);
        $this->setMovimiento($movimiento);
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
            'autor' => "{$this->getMovimiento()->usuario}",
            'text'  => "Fase {$this->getMovimiento()->fase} del proyecto no aprobada: {$this->getMovimiento()->comentarios} | {$this->getProyecto()->articulacion_proyecto->actividad->codigo_actividad} - {$this->getProyecto()->articulacion_proyecto->actividad->nombre}",
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

    /**
     * Asigna un valor a $movimiento
     *
     * @param object $movimiento
     * @return void
     */
    private function setMovimiento($movimiento)
    {
        $this->movimiento = $movimiento;
    }

    /**
     * Retorna el valor de $movimiento
     *
     * @return object
     * @author dum
     */
    private function getMovimiento()
    {
        return $this->movimiento;
    }
}
