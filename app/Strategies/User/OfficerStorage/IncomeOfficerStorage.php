<?php

namespace App\Strategies\User\OfficerStorage;

use Illuminate\Http\Request;
use App\Contracts\User\OfficerStorage;
use App\Models\Nodo;
use App\Models\Contrato;
use App\Models\UserNodo;
use App\User;
use Carbon\Carbon;

class IncomeOfficerStorage implements OfficerStorage
{
    public function buildStorageRecord(Request $request)
    {
        if(isset($request->income_node)){
            $node = Nodo::find($request->income_node);
        }
        return [
            'nodo' => isset($node) ? $node->id : null,
            'vinculacion' => $request->income_type_relationship,
            'codigo' => $request->income_code_contract,
            'fecha_inicio' => $request->income_start_date_contract,
            'fecha_finalizacion' => $request->income_end_date_contract,
            'valor_contrato' => $request->income_contract_value_contract,
            'honorarios' => $request->income_fees_contract,
        ];
    }

    public function save(Request $request, User $user)
    {
        $infoContract = $this->buildStorageRecord($request);
        $user->ingreso()->updateOrCreate(
            ['role' => User::IsIngreso()],
            [
                'linea_id' => null,
                'nodo_id' =>  $infoContract['nodo'],
                'vinculacion' => $infoContract['vinculacion'],
                'honorarios' =>  $infoContract['honorarios'],
            ]
        );

        if($request->income_type_relationship == 0 && isset($user->ingreso)){

            if(isset($user->ingreso->contratos) && $user->ingreso->contratos->count() ){
                $currentContract = $user->ingreso->contratos()
                ->where('codigo' ,$request->income_code_contract)
                ->whereYear('fecha_inicio', Carbon::now()->year)
                ->latest('contratos.fecha_inicio')
                ->latest('contratos.fecha_finalizacion')
                ->get()->last();
                if(!is_null($currentContract) || isset($currentContract)){
                    $currentContract->update($this->propertiesArray($infoContract));
                }else{
                    $user->ingreso->contratos()->create($this->propertiesArray($infoContract));
                }
            }else{
                $user->ingreso->contratos()->create($this->propertiesArray($infoContract));
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
            $reponse .= "<span class='card-title primary-text center'>Información Ingreso</span>
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
                        <p>$ ".number_format($data->honorarios, 2)."</p>
                        <span>Honorarios mensulaes</span>
                    </div>
                </div>";
        }else if($data instanceof Contrato){
            $reponse .= "<span class='card-title primary-text center'>Información Ingreso</span>
            <div class='server-load row'>
                <div class='server-stat col s6 m6 l3'>
                    <p>". $data->ingreso->nodo->entidad->nombre ."</p>
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
                    <p>$ ".number_format($data->valor_contrato, 2)."</p>
                    <span>Valor del contrato</span>
                </div>
                <div class='server-stat col s6 m4 l3'>
                    <p>$ ".number_format($data->honorarios, 2)."</p>
                    <span>Honorarios mensulaes</span>
                </div>
            </div>";
        }
        return $reponse;
    }
}
