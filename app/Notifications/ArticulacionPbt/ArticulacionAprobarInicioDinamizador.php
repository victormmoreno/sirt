<?php

namespace App\Notifications\ArticulacionPbt;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ArticulacionAprobarInicioDinamizador extends Notification implements ShouldQueue
{
    use Queueable;
    private $articulacion;
    private $talento;
    private $movimiento;
    private $fase;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($articulacion, $talento, $movimiento, $fase)
    {
        $this->articulacion = $articulacion;
        $this->talento = $talento;
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
            ->subject("Aprobación fase de {$this->fase} | {$this->articulacion->actividad->codigo_actividad} - {$this->articulacion->actividad->nombre}" )
            ->markdown('emails.articulacionespbt.approval-start-dinamizador', ['data' => $this->articulacion, 'fase' => $this->fase, 'user' => $this->talento, 'movimiento' => $this->movimiento]);
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
            'link'  => route("articulaciones.show", $this->articulacion->id),
            'icon'  => 'library_books',
            'color' => 'green',
            'autor' => "{$this->talento->nombres} {$this->talento->apellidos}",
            'text'  => "El {$this->movimiento->role->name} ha aprobado la fase de {$this->fase} | {$this->articulacion->actividad->codigo_actividad} - {$this->articulacion->actividad->nombre}",
          ];
    }

}
