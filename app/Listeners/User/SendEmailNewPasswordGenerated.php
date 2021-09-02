<?php

namespace App\Listeners\User;

use App\Events\User\UserHasNewPasswordGenerated;

use Illuminate\Support\Facades\Mail;
use App\Mail\User\Auth\SendNotificationPassoword;

class SendEmailNewPasswordGenerated
{

    /**
     * Handle the event.
     *
     * @param  UserHasNewPasswordGenerated  $event
     * @return void
     */
    public function handle(UserHasNewPasswordGenerated $event)
    {
        Mail::to($event->user->email)->send(new SendNotificationPassoword($event->user, $event->password, $event->message));
    }
}
