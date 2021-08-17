<?php

namespace App\Listeners\User;

use App\Events\User\UserWasRegistered;
use Illuminate\Support\Facades\Mail;
use App\Mail\User\Auth\{SendNotificationPassoword, SendLoginInstructionsEmail};
use App\User;
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
        if ($event->user->hasRole(User::IsTalento())) {
            Mail::to($event->user->email)->send(new SendNotificationPassoword($event->user, $event->password));
        }else{
            Mail::to($event->user->email)->send(new SendLoginInstructionsEmail($event->user, $event->password));
        }
    }
}
