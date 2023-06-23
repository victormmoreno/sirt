<?php

namespace App\Strategies\User\OfficerStorage;

use Illuminate\Http\Request;
use App\Contracts\User\OfficerStorage;
use App\Models\Contrato;
use App\Models\UserNodo;
use App\User;
use Carbon\Carbon;

class   ActivatorOfficerStorage implements OfficerStorage
{

    public function buildStorageRecord(Request $request)
    {
        return [
            'vinculacion' => $request->activator_type_relationship,
            'codigo' => $request->activator_code_contract,
            'fecha_inicio' => $request->activator_start_date_contract,
            'fecha_finalizacion' => $request->activator_end_date_contract,
            'valor_contrato' => $request->activator_contract_value_contract,
            'honorarios' => $request->activator_fees_contract,
        ];
    }

    public function save(Request $request, User $user)
    {
        $infoContract = $this->buildStorageRecord($request);
        $user->activador()->updateOrCreate(
            ['role' => User::IsActivador()],
            [
                'linea_id' => null,
                'nodo_id' =>  null,
                'vinculacion' => $infoContract['vinculacion'],
                'honorarios' =>  $infoContract['honorarios'],
            ]
        );

        if($request->activator_type_relationship == 0 && isset($user->activador)){

            if(isset($user->activador->contratos) && $user->activador->contratos->count() ){
                $currentContract = $user->activador->contratos()
                ->where('codigo' ,$request->activator_code_contract)
                ->whereYear('fecha_inicio', Carbon::now()->year)
                ->latest('contratos.fecha_inicio')
                ->latest('contratos.fecha_finalizacion')
                ->get()->last();
                if(!is_null($currentContract) || isset($currentContract)){
                    $currentContract->update($this->propertiesArray($infoContract));
                }else{
                    $user->activador->contratos()->create($this->propertiesArray($infoContract));
                }
            }else{
                $user->activador->contratos()->create($this->propertiesArray($infoContract));
            }
        }
    }

    public function propertiesArray(array $infoContract)
    {
        return [
            'codigo' =>  $infoContract['codigo'],
            'fecha_finalizacion' => $infoContract['fecha_finalizacion'],
            'fecha_inicio' => $infoContract['fecha_inicio'],
            'valor_contrato' => $infoContract['valor_contrato'],
            'honorarios' => $infoContract['honorarios']
        ];
    }

    public function buildResponse($data): String
    {
        $reponse = "";
        if($data instanceof UserNodo){
            $reponse .= "<span class='card-title primary-text center'>Información Activador</span>
                <div class='server-load row'>
                    <div class='server-stat col s6 m6 l6'>
                        <p> ".($data->vinculacion == 0 ? 'Contratista' : 'Planta')."</p>
                        <span>Tipo de vinculación</span>
                    </div>
                    <div class='server-stat col s6 m4 l6'>
                        <p>$ ".number_format($data->honorarios, 2)."</p>
                        <span>Honorarios mensulaes</span>
                    </div>
                </div>";
        }else if($data instanceof Contrato){
            $reponse .= "<span class='card-title primary-text center'>Información Activador</span>
            <div class='server-load row'>
                <div class='server-stat col s6 m6 l4'>
                    <p> ".($data->vinculacion == 0 ? 'Contratista' : 'Planta')."</p>
                    <span>Tipo de vinculación</span>
                </div>
                <div class='server-stat col s6 m6 l4'>
                    <p>{$data->codigo}</p>
                    <span>Número de contrato</span>
                </div>
                <div class='server-stat col s6 m6 l4'>
                    <p>{$data->fecha_inicio}</p>
                    <span>Fecha inicio contrato</span>
                </div>
                <div class='server-stat col s6 m6 l4'>
                    <p>{$data->fecha_finalizacion}</p>
                    <span>Fecha finalizacion contrato</span>
                </div>
                <div class='server-stat col s6 m4 l4'>
                    <p>$ ". number_format($data->valor_contrato, 2)."</p>
                    <span>Valor del contrato</span>
                </div>
                <div class='server-stat col s6 m4 l4'>
                    <p>$ ".number_format($data->honorarios, 2)."</p>
                    <span>Honorarios mensulaes</span>
                </div>
            </div>";
        }

        return $reponse;
    }
}
