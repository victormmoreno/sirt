<?php

namespace App\Notifications\Articulation;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;


class AccompanyingApprovalNotification extends Notification implements ShouldQueue
{
    use Queueable;
    private $model;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->model = $model;
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
            'link'  => route('accompaniments.show',  $this->model->notificable),
            'icon'  => 'autorenew',
            'color' => 'orange',
            'autor' => "{$this->model->remitente->nombres} {$this->model->remitente->nombres}",
            'text'  => "El articulador ha solicitado aprobar | {$this->model->notificable->present()->accompanimentCode()}",
        ];
    }

}
