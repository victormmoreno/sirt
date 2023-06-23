<?php

namespace App\Strategies\User\OfficerStorage;

use Illuminate\Http\Request;
use App\Contracts\User\OfficerStorage;
use App\Models\Nodo;
use App\Models\Contrato;
use App\Models\UserNodo;
use App\User;
use Carbon\Carbon;

class DynamizerOfficerStorage implements OfficerStorage
{
    public function buildStorageRecord(Request $request)
    {
        if(isset($request->dynamizer_node)){
            $node = Nodo::find($request->dynamizer_node);
        }
        return [
            'nodo' => isset($node) ? $node->id : null,
            'vinculacion' => $request->dynamizer_type_relationship,
            'codigo' => $request->dynamizer_code_contract,
            'fecha_inicio' => $request->dynamizer_start_date_contract,
            'fecha_finalizacion' => $request->dynamizer_end_date_contract,
            'valor_contrato' => $request->dynamizer_contract_value_contract,
            'honorarios' => $request->dynamizer_fees_contract,
        ];
    }

    public function save(Request $request, User $user)
    {
        $infoContract = $this->buildStorageRecord($request);
        $user->dinamizador()->updateOrCreate(
            ['role' => User::IsDinamizador()],
            [
                'linea_id' => null,
                'nodo_id' =>  $infoContract['nodo'],
                'vinculacion' => $infoContract['vinculacion'],
                'honorarios' =>  $infoContract['honorarios'],
            ]
        );

        if($request->dynamizer_type_relationship == 0 && isset($user->dinamizador)){

            if(isset($user->dinamizador->contratos) && $user->dinamizador->contratos->count() ){
                $currentContract = $user->dinamizador->contratos()
                ->whereYear('created_at', Carbon::now()->year)->get()->last();
                if(!is_null($currentContract) || isset($currentContract)){
                    $currentContract->update($this->propertiesArray($infoContract));
                }else{
                    $user->dinamizador->contratos()->create($this->propertiesArray($infoContract));
                }
            }else{
                $user->dinamizador->contratos()->create($this->propertiesArray($infoContract));
            }
        }
    }

    public function propertiesArray(array $infoContract)
    {
        return [
            'nodo_id' => $infoContract['nodo'],
            'codigo' =>  $infoContract['codigo'],
            'fecha_inicio' => $infoContract['fecha_inicio'],
            'fecha_finalizacion' => $infoContract['fecha_finalizacion'],
            'valor_contrato' => $infoContract['valor_contrato'],
            'honorarios' => $infoContract['honorarios']
        ];
    }

    public function buildResponse($data)
    {
        $reponse = "";
        if($data instanceof UserNodo){
            $reponse .= "<span class='card-title primary-text center'>Información Dinamizador</span>
                <div class='server-load row'>
                    <div class='server-stat col s6 m6 l4'>
                        <p> {$data->nodo->entidad->nombre}</p>
                        <span>Nodo</span>
                    </div>
                    <div class='server-stat col s6 m6 l4'>
                        <p> ".($data->vinculacion == 0 ? 'Contratista' : 'Planta')."</p>
                        <span>Tipo de vinculación</span>
                    </div>
                    <div class='server-stat col s6 m4 l4'>
                        <p>{$data->honorarios}</p>
                        <span>Honorarios mensulaes</span>
                    </div>
                </div>";
        }else if($data instanceof Contrato){
            $reponse .= "<span class='card-title primary-text center'>Información Dinamizador</span>
            <div class='server-load row'>
                <div class='server-stat col s6 m6 l3'>
                    <p> {$data->dinamizador->nodo->entidad->nombre}</p>
                    <span>Nodo</span>
                </div>
                <div class='server-stat col s6 m6 l3'>
                    <p> ".($data->vinculacion == 0 ? 'Contratista' : 'Planta')."</p>
                    <span>Tipo de vinculación</span>
                </div>
                <div class='server-stat col s6 m6 l3'>
                    <p>{$data->codigo}</p>
                    <span>Número de contrato</span>
                </div>
                <div class='server-stat col s6 m6 l3'>
                    <p>{$data->fecha_inicio}</p>
                    <span>Fecha inicio contrato</span>
                </div>
                <div class='server-stat col s6 m6 l3'>
                    <p>{$data->fecha_finalizacion}</p>
                    <span>Fecha finalizacion contrato</span>
                </div>
                <div class='server-stat col s6 m6 l3'>
                    <p>{$data->valor_contrato}</p>
                    <span>Valor del contrato</span>
                </div>
                <div class='server-stat col s6 m4 l3'>
                    <p>{$data->honorarios}</p>
                    <span>Honorarios mensulaes</span>
                </div>
            </div>
            <div class='server-load row'>

            </div>";
        }

        return $reponse;
    }
}
