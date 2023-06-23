<?php

namespace App\Http\Traits\User;

use Illuminate\Http\Request;
use App\Models\UserNodo;
use App\Models\Contrato;
use App\User;
use App\Strategies\User\OfficerStorage\ActivatorOfficerStorage;
use App\Strategies\User\OfficerStorage\DynamizerOfficerStorage;
use Carbon\Carbon;


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
        // dd($this->activador);
        $response = "";
         if($this->isUserActivador() && isset($this->activador) && $this->activador->vinculacion == 0 && isset($this->activadorContratoLatest)){
            $response .=  (new ActivatorOfficerStorage)->buildResponse($this->activadorContratoLatest);
        }
        else if($this->isUserActivador() && isset($this->activador) && $this->activador->vinculacion == 1){
            $response .=  (new ActivatorOfficerStorage)->buildResponse($this->activador);
        }
        if($this->isUserDinamizador() && isset($this->dinamizador) && $this->dinamizador->vinculacion == 0  && isset($this->dinamizadorContratoLatest)){
            $response .=  (new DynamizerOfficerStorage)->buildResponse($this->dinamizadorContratoLatest);
        }
        else if($this->isUserDinamizador() && isset($this->dinamizador) && isset($this->dinamizador) && $this->dinamizador->vinculacion == 1){
            $response .=  (new DynamizerOfficerStorage)->buildResponse($this->dinamizador);
        }
        if($this->isUserExperto() && isset($this->experto)){
            $response .=  "Experto";
        }
        return $response;

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
        ->whereYear('fecha_inicio', Carbon::now()->year)
        ->latest('contratos.fecha_inicio')
        ->latest('contratos.fecha_finalizacion')
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
    public function articuladorContratoLatest()
    {
        return $this->hasOneThrough(
            Contrato::class,
            UserNodo::class,
            'user_id',
            'user_nodo_id'
        )->where('role', User::IsArticulador())
        ->latest('contratos.fecha_inicio')
        ->latest('contratos.created_at');
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

    public function dinamizadorContratoLatest()
    {
        return $this->hasOneThrough(
            Contrato::class,
            UserNodo::class,
            'user_id',
            'user_nodo_id'
        )->where('role', User::IsDinamizador())
        ->whereYear('fecha_inicio', Carbon::now()->year)
        ->latest('contratos.fecha_inicio')
        ->latest('contratos.fecha_finalizacion')
        ->latest('contratos.created_at');
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
