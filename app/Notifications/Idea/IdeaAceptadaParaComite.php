<?php

namespace App\Notifications\Idea;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class IdeaAceptadaParaComite extends Notification implements ShouldQueue
{
    use Queueable;
    public $idea;
    public $articulador;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($idea, $articulador)
    {
        $this->idea = $idea;
        $this->articulador = $articulador;
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
            'link'  => route('idea.detalle', $this->idea->id),
            'icon'  => 'lightbulb',
            'color' => 'cyan',
            'autor' => "{$this->articulador->nombres} {$this->articulador->apellidos}",
            'text'  => "ha aceptado la postulación de una idea | {$this->idea->nombre_proyecto}",
        ];
    }
}
