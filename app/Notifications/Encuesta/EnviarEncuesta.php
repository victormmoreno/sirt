<?php

namespace App\Notifications\Encuesta;

use Illuminate\Support\Facades\Lang;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EnviarEncuesta extends Notification implements ShouldQueue
{

    use Queueable;
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;
    public $query;

    /**
     * The callback that should be used to build the mail message.
     *
     * @var \Closure|null
     */
    public static $toMailCallback;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($query, $token)
    {
        $this->query = $query;
        $this->token = $token;

    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }
        if(class_basename($this->query) == class_basename(\App\Models\Proyecto::class)){
            return (new MailMessage)
                ->subject(Lang::getFromJson('Encuesta de Satisfaccion').' '. strtolower(class_basename($this->query)). ' '.  $this->query->codigo_proyecto)
                ->markdown('emails.encuesta.enviar-link-encuesta-proyecto', [
                    'query' => $this->query,
                    'notifiable' => $notifiable,
                    'token' => $this->token,
                ]);
        }
        if(class_basename($this->query) == class_basename(\App\Models\Articulation::class)){
            return (new MailMessage)
            ->subject(Lang::getFromJson('Encuesta de Satisfaccion').' '. strtolower(class_basename($this->query)). ' '.  $this->query->code)
            ->markdown('emails.encuesta.enviar-link-encuesta-articulacion', [
                'query' => $this->query,
                'notifiable' => $notifiable,
                'token' => $this->token,
            ]);
        }
    }

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }
}
