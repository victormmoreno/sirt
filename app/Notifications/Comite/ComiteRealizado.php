<?php

namespace App\Notifications\Comite;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ComiteRealizado extends Notification implements ShouldQueue
{
    use Queueable;
    private $comite;
    private $infocenter;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comite, $infocenter)
    {
        $this->setComite($comite);
        $this->infocenter = $infocenter;
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
            'link'  => route('csibt.detalle', $this->getComite()->id),
            'icon'  => 'gavel',
            'color' => 'green',
            'autor' => $this->infocenter,
            'text'  => "El infocenter ha calificado el comité | {$this->getComite()->codigo} - {$this->getComite()->fechacomite}",
          ];
    }

    public function setComite($comite)
    {
        $this->comite = $comite;
    }

    public function getComite()
    {
        return $this->comite;
    }
}
