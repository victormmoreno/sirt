<?php

namespace App\Listeners\User;

use App\Contracts\User\MustCompleteTalentInformation;
use App\Events\User\CompletedTalentInformation;

class SendEmailCompletationInformationTalentNotification
{
    /**
     * Handle the event.
     *
     * @param  CompletedTalentInformation  $event
     * @return void
     */
    public function handle(CompletedTalentInformation $event)
    {
        if ($event->user instanceof MustCompleteTalentInformation && ! $event->user->hasCompletedTalentInformation()) {
            $event->user->sendEmailToCompleteTalentInformation();
        }
    }
}
