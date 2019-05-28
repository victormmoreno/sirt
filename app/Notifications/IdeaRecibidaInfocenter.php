<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class IdeaRecibidaInfocenter extends Notification implements ShouldQueue
{
    use Queueable;
    public $idea;
    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($idea, $user)
    {
        $this->idea = $idea;
        $this->user = $user;
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
                    ->subject('Nueva Idea | '. $this->user->nombrenodo)
                    // ->greeting('Hola, <br>' . $this->idea->nombre_completo. '<br> Cordial Saludo.')
                    // ->line('Ha recibido este mensaje porque el señor(a) '.$this->idea->nombre_completo.' ha adjuntado una nueva idea.')
                    // ->line('Gracias por usar nuestra aplicación!');
                    ->markdown('emails.idea.Idea-enviada-infocenter',['user'=>$this->user,'idea'=> $this->idea]);
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
            'link' => route('ideas.show', $this->idea->id),
            'text' => 'Haz recibido una nueva idea  '. $this->idea->nombreproyecto,
        ];
    }
}
