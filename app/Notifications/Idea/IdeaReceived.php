<?php

namespace App\Notifications\Idea;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IdeaReceived extends Notification 
{
    use Queueable;
    public $idea;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($idea)
    {
        $this->idea = $idea;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
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
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Idea Recibida | Tecnorque Nodo ' . $this->idea->nodo->entidad->nombre)
            ->greeting('Hola ' . $this->idea->nombres_contacto . ' ' . $this->idea->apellidos_contacto . ',')

            ->markdown('emails.idea.Idea-enviada', ['idea' => $this->idea]);
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
            'link' => route('idea.ideas'),
            'text' => 'Haz recibido una nueva idea  '. $this->idea->nombreproyecto,
        ];
        //
        // return $this->idea->toArray();
    }
}
