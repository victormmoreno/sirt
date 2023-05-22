<?php
namespace App\Contracts\User;

interface MustCompleteTalentInformation
{
    /**
     * Determine if the user has completed information talent.
     *
     * @return bool
     */
    public function hasCompletedTalentInformation();

    /**
     * Mark the given user's information talent as completed.
     *
     * @return bool
     */
    public function markInformationTalentAsCompleted();

    /**
     * save information talent.
     *
     * @return void
     */
    public function saveInformationTalent();

    /**
     * Send the email information talent notification.
     *
     * @return void
     */
    public function sendEmailToCompleteTalentInformation();

    /**
     * Get the email address that should be used for completation information talent.
     *
     * @return void
     */
    public function getEmailForCompletation();

}
