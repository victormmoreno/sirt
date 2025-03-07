<?php

namespace App\Notifications\Articulation;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;


class ArticulationStageNoApproveEndorsement extends Notification implements ShouldQueue
{
    use Queueable;
    private $articulationStage;
    private $notification;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($articulationStage, $notification)
    {
        $this->articulationStage = $articulationStage;
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
        return ['database'];
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
            ->subject("Solicitud de aprobación para {$this->articulationStage->present()->articulationStageCode()} - {$this->articulationStage->present()->articulationStageName()}" )
            ->markdown('emails.articulation.endorsement-stage-articulation', ['articulationStage' => $this->articulationStage, 'notification' => $this->notification]);
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
            'link'  => route('articulation-stage.show',  $this->articulationStage),
            'icon'  => 'library_books',
            'color' => 'green',
            'autor' => "",
            'text'  => "El articulador ha solicitado la aprobación para {$this->articulationStage->present()->articulationStageEndorsementApproval()} la ". __('articulation-stage') ." {$this->articulationStage->code}",
        ];
    }

}
