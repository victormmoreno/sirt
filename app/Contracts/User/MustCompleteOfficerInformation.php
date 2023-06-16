<?php
namespace App\Contracts\User;

interface MustCompleteOfficerInformation
{
    /**
     * Determine if the user has completed information Officer.
     *
     * @return bool
     */
    public function hasCompletedOfficerInformation();

    /**
     * Mark the given user's information Officer as completed.
     *
     * @return bool
     */
    public function markInformationOfficerAsCompleted();

    /**
     * save information Officer.
     *
     * @return void
     */
    public function saveInformationOfficer();

    /**
     * Send the email information Officer notification.
     *
     * @return void
     */
    public function sendEmailToCompleteOfficerInformation();

    /**
     * Get the email address that should be used for completation information Officer.
     *
     * @return void
     */
    public function getEmailForCompletation();
    /**
     * Get the information Officer.
     *
     * @return void
     */
    public function getInformationOfficerBuilder();

    /**
     * Get the information Officer.
     *
     * @return void
     */
    public function getInformationOfficerEloquent();

}
