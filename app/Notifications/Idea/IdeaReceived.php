<?php

namespace App\Notifications\Idea;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class IdeaReceived extends Notification implements ShouldQueue
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
            'autor' => "{$this->idea->user->nombres} {$this->idea->user->apellidos}",
            'text'  => "ha inscrito una nueva idea | {$this->idea->nombre_proyecto}",
        ];

    }
}
