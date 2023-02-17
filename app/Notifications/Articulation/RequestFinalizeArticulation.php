<?php

namespace App\Notifications\Articulation;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;


class RequestFinalizeArticulation extends Notification implements ShouldQueue
{
    use Queueable;
    private $articulation;
    private $notification;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($articulation, $notification)
    {
        $this->articulation = $articulation;
        $this->notification = $notification;
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
            ->subject("Solicitud de aval para finalizar la ". __('articulation') ." {$this->articulation->present()->articulationCode()} - {$this->articulation->present()->articulationName()}" )
            ->markdown('emails.articulation.request-finalize-articulation', ['articulation' => $this->articulation, 'notification' => $this->notification]);
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
            'link'  => route('articulations.show',  $this->articulation),
            'icon'  => 'library_books',
            'color' => 'green',
            'autor' => "{$this->notification->remitente->nombres} {$this->notification->remitente->nombres}",
            'text'  => "El articulador ha solicitado el aval para finalizar la ". __('articulation') ." {$this->articulation->present()->articulationCode()}",
        ];
    }

}
