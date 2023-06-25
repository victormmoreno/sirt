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


    public function activadorContrato();

    public function activadorContratoLatest();

    public function articuladorContrato();

    public function articuladorContratoLatest();

    public function apoyoTecnicoContrato();

    public function apoyoTecnicoContratoLatest();

    public function dinamizadorContrato();

    public function dinamizadorContratoLatest();

    public function expertoContrato();

    public function expertoContratoLatest();

    public function infocenterContrato();

    public function infocenterContratoLatest();

    public function ingresoContrato();

    public function ingresoContratoLatest();
}
