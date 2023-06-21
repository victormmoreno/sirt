<?php

namespace App\Http\Traits\User;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Notifications\User\CompleteTalentInformation;
use App\Values\OfficerStorageValues;
use App\Models\UserNodo;
use App\Models\Contrato;
use App\User;
use App\Strategies\User\OfficerStorage\ActivatorOfficerStorage;


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

        if(isset($this->activador)){
            $response =  (new ActivatorOfficerStorage)->buildResponse($this->activador);
        }
        if(isset($this->activadorContratoLatest)){
            $response =  (new ActivatorOfficerStorage)->buildResponse($this->activadorContratoLatest);
        }
        if(isset($this->dinamizador)){
            $response =  "Dinamizador";
        }

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

    public function activadorContratoLatest()
    {
        return $this->hasOneThrough(
            Contrato::class,
            UserNodo::class,
            'user_id',
            'user_nodo_id'
        )->where('role', User::IsActivador())
        ->latest('contratos.fecha_inicio')
        ->latest('contratos.created_at');
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
    public function articuladorContratoMax()
    {
        return $this->hasManyThrough(
            Contrato::class,
            UserNodo::class,
            'user_id',
            'user_nodo_id'
        )->where('role', User::IsArticulador())
        ->selectRaw('entidades.nombre as nodo, contratos.codigo, max(fecha_inicio) as fecha_inicio, contratos.fecha_finalizacion, contratos.valor_contrato, contratos.honorarios')
        ->join('nodos', 'nodos.id', '=', 'user_nodo.nodo_id')
        ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
        ->groupBy('user_id');
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
    public function apoyoTecnicoContratoMax()
    {
        return $this->hasManyThrough(
            Contrato::class,
            UserNodo::class,
            'user_id',
            'user_nodo_id'
        )->where('role', User::IsApoyoTecnico())
        ->selectRaw('contratos.codigo, max(fecha_inicio) as fecha_inicio, contratos.fecha_finalizacion, contratos.valor_contrato, contratos.honorarios')

        ->groupBy('user_id');
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
