<?php

namespace App\Http\Traits\User;

use App\Notifications\User\CompleteTalentInformation;

trait MustCompleteTalentInformation
{
    /**
     * Determine if the user has completed information talent.
     *
     * @return bool
     */
    public function hasCompletedTalentInformation()
    {
        return ! is_null($this->informacion_talento_completed_at) && ! is_null($this->informacion_talento);
    }

    /**
     * Mark the given user's information talent as completed.
     *
     * @return bool
     */
    public function markInformationTalentAsCompleted()
    {
        return $this->forceFill([
            'informacion_talento_completed_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * save information talent.
     *
     * @return void
     */
    public function saveInformationTalent()
    {
        if(! is_null($this->informacion_talento))
        {

        }
    }

    /**
     * Send the email information talent notification.
     *
     * @return void
     */
    public function sendEmailToCompleteTalentInformation()
    {
        $this->notify(new CompleteTalentInformation);
    }

    /**
     * Get the email address that should be used for completation information talent.
     *
     * @return string
     */
    public function getEmailForCompletation()
    {
        return $this->email;
    }
}
