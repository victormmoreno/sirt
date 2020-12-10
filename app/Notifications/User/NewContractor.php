<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewContractor extends Notification implements ShouldQueue
{
    use Queueable;
    private $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->setUser($user);
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
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
        ->subject(config('app.name') . ' | Nuevo contratista' . config('app.name'))
            ->greeting('Hola señor dinamizador')
        ->line('Hemos enviado este correo para informarte que el usuario '. $this->getUser()->nombres.' '.$this->getUser()->apellidos. ' está solicitando acceso por primera vez al aplicaivo.');
        // ->markdown('emails.users.auth.new-contractor');
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
            'link'  => route('usuario.usuarios.edit', $this->getUser()->documento),
            'icon'  => 'lightbulb',
            'color' => 'cyan',
            'autor' => "Nuevo contatista | {$this->getUser()->nombres} {$this->getUser()->apellidos}",
            'text'  => "El contratista está haciendo una petición de registro en el nodo.",
        ];
    }
}
