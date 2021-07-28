<?php

namespace App\Notifications\ArticulacionPbt;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ArticulacionAprobarInicio extends Notification implements ShouldQueue
{
    use Queueable;
    private $articulacion;
    private $fase;
    private $talent;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($articulacion, $fase, $talent)
    {
        $this->setArticulacion($articulacion);
        $this->setFase($fase);
        $this->talent = $talent;
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

        $fase = nameFase($this->getFase());
        return (new MailMessage)
            ->subject("Aprobación fase de {$this->getFase()} | {$this->getArticulacion()->actividad->codigo_actividad} - {$this->getArticulacion()->actividad->nombre}" )
            ->markdown('emails.articulacionespbt.approval-start', ['data' => $this->getArticulacion(), 'fase' => $fase, 'user' => $this->talent]);
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
            'link'  => route("articulaciones.show", $this->getArticulacion()->id),
            'icon'  => 'autorenew',
            'color' => 'orange',
            'autor' => "{$this->getArticulacion()->asesor->nombres} {$this->getArticulacion()->asesor->apellidos}",
            'text'  => "El Articulador ha solicitado aprobar la fase de {$this->getFase()} | {$this->getArticulacion()->actividad->codigo_actividad} - {$this->getArticulacion()->actividad->nombre}",
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

    public function setFase($fase)
    {
        $this->fase = $fase;
    }

    public function getFase()
    {
        return $this->fase;
    }
}
