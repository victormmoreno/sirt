<?php

namespace App\Http\Traits\User;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Notifications\User\CompleteTalentInformation;
use App\Values\OfficerStorageValues;
use App\Models\UserNodo;
use App\Models\Contrato;
use App\User;



trait MustCompleteOfficerInformation
{
    /**
     * Determine if the user has completed information officer.
     *
     * @return bool
     */
    public function hasCompletedOfficerInformation()
    {
        return ! is_null($this->informacion_user_completed_at) && ! is_null($this->informacion_user);
    }

    /**
     * Mark the given user's information officer as completed.
     *
     * @return bool
     */
    public function markInformationOfficerAsCompleted()
    {
        return $this->forceFill([
            'informacion_user_completed_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * save information officer.
     *
     */
    public function saveInformationOfficer(Request $request = null)
    {
        if(
            !is_null($request) &&
            isset($request->roles)
            // is_null($this->informacion_user_completed_at)
            )
        {
            $officeStorageClass = OfficerStorageValues::OFFICER[$request->role];


            return (new $officeStorageClass)->buildStorageRecord($request);




            // $this->update(['informacion_user' => $structures]);

            // $this->markInformationOfficerAsCompleted();
        }
    }

    /**
     * Send the email information officer notification.
     *
     * @return void
     */
    public function sendEmailToCompleteOfficerInformation()
    {
        return;// $this->notify(new CompleteOfficerInformation);
    }


    public function getInformationOfficerBuilder()
    {
        // if(isset($this->informacion_user["talento"])){
        //     $talentType = Str::snake(Str::lower($this->informacion_user["talento"]["tipo_talento"]));
        //     $talentStorageClass = OfficerStorageValues::OFFICER[$talentType];
        //     return (new $talentStorageClass)->buildResponse($this->informacion_user);
        // }
    }

    public function getInformationOfficerEloquent()
    {
        return;
    }

    /**
    * Get the user's user activator contract.
    */
    public function activadorContrato()
    {
        return $this->hasManyThrough(
            Contrato::class,
            UserNodo::class,
            'user_id',
            'user_nodo_id'
        )->where('role', User::IsActivador());
    }

    public function activatorContractCurrentYear()
    {
        return $this->hasOneThrough(
            Contrato::class,
            UserNodo::class,
            'user_id',
            'user_nodo_id'
        )->where('role', User::IsActivador())
        ->whereYear('contratos.fecha_inicio', \Carbon\Carbon::now()->year);
    }


    /**
    * Get the user's user articulator contract.
    */
    public function articuladorContrato()
    {
        return $this->hasManyThrough(
            Contrato::class,
            UserNodo::class,
            'user_id',
            'user_nodo_id'
        )->where('role', User::IsArticulador());
    }

    /**
    * Get the user's user tecnical support contract.
    */
    public function apoyoTecnicoContrato()
    {
        return $this->hasManyThrough(
            Contrato::class,
            UserNodo::class,
            'user_id',
            'user_nodo_id'
        )->where('role', User::IsApoyoTecnico());
    }

    /**
    * Get the user's user dynamizator contract.
    */
    public function dinamizadorContrato()
    {
        return $this->hasManyThrough(
            Contrato::class,
            UserNodo::class,
            'user_id',
            'user_nodo_id'
        )->where('role', User::IsDinamizador());
    }

    /**
    * Get the user's user expert contract.
    */
    public function expertoContrato()
    {
        return $this->hasManyThrough(
            Contrato::class,
            UserNodo::class,
            'user_id',
            'user_nodo_id'
        )->where('role', User::IsExperto());
    }


    /**
    * Get the user's user infocenter contract.
    */
    public function infocenterContrato()
    {
        return $this->hasManyThrough(
            Contrato::class,
            UserNodo::class,
            'user_id',
            'user_nodo_id'
        )->where('role', User::IsInfocenter());
    }


    /**
    * Get the user's user expert contract.
    */
    public function ingresoContrato()
    {
        return $this->hasManyThrough(
            Contrato::class,
            UserNodo::class,
            'user_id',
            'user_nodo_id'
        )->where('role', User::IsIngreso());
    }
}
