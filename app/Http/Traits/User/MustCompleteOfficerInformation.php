<?php

namespace App\Http\Traits\User;

use Illuminate\Http\Request;
use App\Models\UserNodo;
use App\Models\Contrato;
use App\User;
use App\Strategies\User\OfficerStorage\ActivatorOfficerStorage;
use App\Strategies\User\OfficerStorage\DynamizerOfficerStorage;
use App\Strategies\User\OfficerStorage\ExpertOfficerStorage;
use App\Strategies\User\OfficerStorage\ArticulatorOfficerStorage;
use App\Strategies\User\OfficerStorage\InfocenterOfficerStorage;
use App\Strategies\User\OfficerStorage\TechnicalSupportOfficerStorage;
use App\Strategies\User\OfficerStorage\IncomeOfficerStorage;
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
        $roles = is_array($request->role) ? $request->role : explode(', ', $request->role);
        $roles = collect($roles)
            ->flatten()
            ->map(function ($role) use($request) {
                if (empty($role)) {
                    return false;
                }
                if($role == User::IsActivador())
                {
                    return (new ActivatorOfficerStorage)->save($request, $this);
                }
                if($role == User::IsDinamizador())
                {
                    return (new DynamizerOfficerStorage)->save($request, $this);
                }
                if($role == User::IsExperto())
                {
                    return (new ExpertOfficerStorage)->save($request, $this);
                }
                if($role == User::IsArticulador())
                {
                    return (new ArticulatorOfficerStorage)->save($request, $this);
                }
                if($role == User::IsApoyoTecnico())
                {
                    return (new TechnicalSupportOfficerStorage)->save($request, $this);
                }
                if($role == User::IsInfocenter())
                {
                    return (new InfocenterOfficerStorage)->save($request, $this);
                }
                if($role == User::IsIngreso())
                {
                    return (new IncomeOfficerStorage)->save($request, $this);
                }
                if($role == User::IsTalento())
                {
                    if($request->talent_type == 1){
                        $request->merge([
                            'tipo_talento' => 'aprendiz_sena_con_apoyo_de_sostenimiento',
                            'regional' => $request->regional,
                            'centro_formacion' => $request->training_center,
                            'programa_formacion' => $request->training_program,
                        ]);
                    }
                    else if($request->talent_type == 2){
                        $request->merge([
                            'tipo_talento' => 'aprendiz_sena_sin_apoyo_de_sostenimiento',
                            'regional' => $request->regional,
                            'centro_formacion' => $request->training_center,
                            'programa_formacion' => $request->training_program
                        ]);
                    }
                    else if($request->talent_type  == 3){
                        $request->merge([
                            'tipo_talento' => 'egresado_sena',
                            'regional' => $request->regional,
                            'centro_formacion' => $request->training_center,
                            'programa_formacion' => $request->training_program,
                            'tipo_formacion' => $request->formation_type,
                        ]);
                    }
                    else if($request->talent_type == 7)
                    {
                        $request->merge([
                            'tipo_talento' => 'emprendedor'
                        ]);
                    }
                    else if($request->talent_type == 8){
                        $request->merge([
                            'tipo_talento' => 'estudiante_universitario',
                            'tipo_estudio' => $request->study_type,
                            'universidad' => $request->university,
                            'carrera' => $request->career,
                        ]);
                    }
                    else if($request->talent_type == 9){
                        $request->merge([
                            'tipo_talento' => 'funcionario_de_empresa',
                            'empresa' => $request->company
                        ]);
                    }
                    else if($request->talent_type == 5){
                        $request->merge([
                            'tipo_talento' => 'funcionario_sena',
                            'regional' => $request->regional,
                            'centro_formacion' => $request->training_center,
                            'dependencia' => $request->dependency
                        ]);
                    }
                    else if($request->talent_type == 4){
                        $request->merge([
                            'tipo_talento' => 'instructor_sena',
                            'regional' => $request->regional,
                            'centro_formacion' => $request->training_center,
                        ]);
                    }
                    else if($request->talent_type == 6){
                        $request->merge([
                            'tipo_talento' => 'propietario_empresa',
                            'empresa' => $request->company
                        ]);
                    }
                    return $this->saveInformationTalent($request);
                }
                return $role;
            })->filter(function ($role) {return $role;});
            $this->syncRoles($request->role);
            $this->markInformationOfficerAsCompleted();
    }

    public function getInformationOfficerBuilder()
    {
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
        else if($this->isUserDinamizador() && isset($this->dinamizador) && $this->dinamizador->vinculacion == 1){
            $response .=  (new DynamizerOfficerStorage)->buildResponse($this->dinamizador);
        }
        if($this->isUserExperto() && isset($this->experto) && $this->experto->vinculacion == 0  && isset($this->expertoContratoLatest)){
            $response .=  (new ExpertOfficerStorage)->buildResponse($this->expertoContratoLatest);
        }
        else if($this->isUserExperto() && isset($this->experto) && $this->experto->vinculacion == 1){
            $response .=  (new ExpertOfficerStorage)->buildResponse($this->experto);
        }
        if($this->isUserArticulador() && isset($this->articulador) && $this->articulador->vinculacion == 0  && isset($this->articuladorContratoLatest)){
            $response .=  (new ArticulatorOfficerStorage)->buildResponse($this->articuladorContratoLatest);
        }
        else if($this->isUserArticulador() && isset($this->articulador) && $this->articulador->vinculacion == 1){
            $response .=  (new ArticulatorOfficerStorage)->buildResponse($this->articulador);
        }
        if($this->isUserInfocenter() && isset($this->infocenter) && $this->infocenter->vinculacion == 0  && isset($this->infocenterContratoLatest)){
            $response .=  (new InfocenterOfficerStorage)->buildResponse($this->infocenterContratoLatest);
        }
        else if($this->isUserInfocenter() && isset($this->infocenter) && $this->infocenter->vinculacion == 1){
            $response .=  (new InfocenterOfficerStorage)->buildResponse($this->infocenter);
        }
        if($this->isUserApoyoTecnico() && isset($this->apoyotecnico) && $this->apoyotecnico->vinculacion == 0  && isset($this->apoyoTecnicoContratoLatest)){
            $response .=  (new TechnicalSupportOfficerStorage)->buildResponse($this->apoyoTecnicoContratoLatest);
        }
        else if($this->isUserApoyoTecnico() && isset($this->apoyotecnico) && $this->apoyotecnico->vinculacion == 1){
            $response .=  (new TechnicalSupportOfficerStorage)->buildResponse($this->apoyotecnico);
        }
        if($this->isUserIngreso() && isset($this->ingreso) && $this->ingreso->vinculacion == 0  && isset($this->ingresoContratoLatest)){
            $response .=  (new IncomeOfficerStorage)->buildResponse($this->ingresoContratoLatest);
        }
        else if($this->isUserIngreso() && isset($this->ingreso) && $this->ingreso->vinculacion == 1){
            $response .=  (new IncomeOfficerStorage)->buildResponse($this->ingreso);
        }
        return $response;
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
        ->whereYear('fecha_inicio', Carbon::now()->year)
        ->latest('contratos.fecha_inicio')
        ->latest('contratos.fecha_finalizacion')
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

    public function apoyoTecnicoContratoLatest()
    {
        return $this->hasOneThrough(
            Contrato::class,
            UserNodo::class,
            'user_id',
            'user_nodo_id'
        )->where('role', User::IsApoyoTecnico())
        ->whereYear('fecha_inicio', Carbon::now()->year)
        ->latest('contratos.fecha_inicio')
        ->latest('contratos.fecha_finalizacion')
        ->latest('contratos.created_at');
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

    public function expertoContratoLatest()
    {
        return $this->hasOneThrough(
            Contrato::class,
            UserNodo::class,
            'user_id',
            'user_nodo_id'
        )->where('role', User::IsExperto())
        ->whereYear('fecha_inicio', Carbon::now()->year)
        ->latest('contratos.fecha_inicio')
        ->latest('contratos.fecha_finalizacion')
        ->latest('contratos.created_at');
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

    public function infocenterContratoLatest()
    {
        return $this->hasOneThrough(
            Contrato::class,
            UserNodo::class,
            'user_id',
            'user_nodo_id'
        )->where('role', User::IsInfocenter())
        ->whereYear('fecha_inicio', Carbon::now()->year)
        ->latest('contratos.fecha_inicio')
        ->latest('contratos.fecha_finalizacion')
        ->latest('contratos.created_at');
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

    public function ingresoContratoLatest()
    {
        return $this->hasOneThrough(
            Contrato::class,
            UserNodo::class,
            'user_id',
            'user_nodo_id'
        )->where('role', User::IsIngreso())
        ->whereYear('fecha_inicio', Carbon::now()->year)
        ->latest('contratos.fecha_inicio')
        ->latest('contratos.fecha_finalizacion')
        ->latest('contratos.created_at');
    }
}
