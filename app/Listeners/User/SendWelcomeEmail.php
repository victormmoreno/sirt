<?php

namespace App\Listeners\User;

use App\Events\User\UserWasRegistered;
use Illuminate\Support\Facades\Mail;
use App\Mail\User\Auth\SendNotificationPassoword;

class SendWelcomeEmail
{

    /**
     * Handle the event.
     *
     * @param  UserWasRegistered  $event
     * @return void
     */
    public function handle(UserWasRegistered $event)
    {
        Mail::to($event->user->email)->send(new SendNotificationPassoword($event->user, $event->password, $event->message));
    }
}
