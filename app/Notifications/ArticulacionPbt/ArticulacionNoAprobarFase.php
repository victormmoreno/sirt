<?php

namespace App\Notifications\ArticulacionPbt;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ArticulacionNoAprobarFase extends Notification implements ShouldQueue
{
    use Queueable;
    private $articulacion;
    private $movimiento;
    private $fase;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($articulacion, $movimiento, $fase)
    {
        $this->articulacion = $articulacion;
        $this->movimiento = $movimiento;
        $this->fase = $fase;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Fase {$this->fase} de la articulación no aprobada | {$this->articulacion->actividad->codigo_actividad} - {$this->articulacion->actividad->nombre}" )
            ->markdown('emails.articulacionespbt.phase-not-passed', ['articulacion' => $this->articulacion, 'movimiento' => $this->movimiento, 'fase' => $this->fase]);
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
            'link'  => route('articulaciones.show', $this->articulacion->id),
            'icon'  => 'library_books',
            'color' => 'green',
            'autor' => "{$this->movimiento->user->nombres} {$this->movimiento->user->apellidos}",
            'text'  => "Fase {$this->fase} de la articulación no aprobada: {$this->articulacion->actividad->codigo_actividad} - {$this->articulacion->actividad->nombre}",
          ];
    }
}
