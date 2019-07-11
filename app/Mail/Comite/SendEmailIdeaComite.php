<?php

namespace App\Mail\Comite;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Controllers\PDF\PdfComiteController;

class SendEmailIdeaComite extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $datosIdea;
    public $pdf;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($datosIdea, $pdf)
    {
        $this->datosIdea = $datosIdea;
        $this->pdf = base64_encode($pdf);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.comite.send-email-ideas-comite')
        ->attachData(base64_decode($this->pdf), 'name.pdf', [
          'mime' => 'application/pdf',
        ]);
    }
}
