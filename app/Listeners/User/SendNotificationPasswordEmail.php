<?php

namespace App\Listeners\User;

use App\Events\User\UserWasRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\User\SendNotificationPassoword;
use Illuminate\Support\Facades\Log;

class SendNotificationPasswordEmail
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  UserWasRegistered  $event
     * @return void
     */
    public function handle(UserWasRegistered $event)
    {
        
        Mail::to($event->user->email)->send(new SendNotificationPassoword($event->user, $event->password));
        
    }
}
