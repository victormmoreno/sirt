<?php

namespace App\Listeners\Articulation;

use App\Events\Articulation\AccompanyingApprovalRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\Articulation\SendAccompanimentApprovalMail;

class AccompanyingApprovalRequestSent
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AccompanyingApprovalRequest  $event
     * @return void
     */
    public function handle(AccompanyingApprovalRequest $event)
    {
        Mail::to($event->recipients)->send(new SendAccompanimentApprovalMail($event->notification));
    }
}
