<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewContractor extends Notification implements ShouldQueue
{
    use Queueable;
    public $user_form;
    public $user_to;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user_form, $user_to)
    {
        $this->setUserFrom($user_form);
        $this->setUserTo($user_to);
    }

    public function setUserFrom($user_form)
    {
        $this->user_form = $user_form;
    }

    public function setUserTo($user_to)
    {
        $this->user_to = $user_to;
    }

    public function getUserFrom()
    {
        return $this->user_form;
    }

    public function getUserTo()
    {
        return $this->user_to;
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
            ->subject('Nuevo funcionario ' . $this->getUserFrom()->present()->nodoContratista() . config('app.name'))
            ->markdown('emails.users.auth.new-contractor', ['user_form' => $this->getUserFrom(), 'user_to' => $this->getUserTo()]);
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
            'link'  => route('user.contractor.confirm.request', $this->getUserFrom()->documento),
            'icon'  => 'lightbulb',
            'color' => 'cyan',
            'autor' => "Nuevo funcionario | {$this->getUserFrom()->nombres} {$this->getUserFrom()->apellidos}",
            'text'  => "{$this->getUserFrom()->nombres} {$this->getUserFrom()->apellidos} está haciendo una petición de registro en el aplicativo",
        ];
    }
}
