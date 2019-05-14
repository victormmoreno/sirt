<?php

namespace App\Listeners;

use App\Mail\PleaseActivateYourAccount;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;

class SendActivationLink
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
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        Mail::to($event->user->email)->send(new PleaseActivateYourAccount($event->user));
    }
}
