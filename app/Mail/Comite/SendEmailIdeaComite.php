<?php

namespace App\Mail\Comite;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailIdeaComite extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $datosIdea;
    public $pdf;
    public $subject = "Resultado de CSIBT";

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($datosIdea, $pdf)
    {
        $this->datosIdea = $datosIdea;
        $this->pdf       = base64_encode($pdf);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.comite.send-email-ideas-comite')
            ->attachData(base64_decode($this->pdf), 'resultados-CSIBT.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
