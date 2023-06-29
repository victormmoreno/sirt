<?php

namespace App\Strategies\User\OfficerStorage;

use Illuminate\Http\Request;
use App\Contracts\User\OfficerStorage;
use App\Models\Nodo;
use App\Models\Contrato;
use App\Models\UserNodo;
use App\Models\LineaTecnologica;
use App\User;
use Carbon\Carbon;

class TechnicalSupportOfficerStorage implements OfficerStorage
{
    public function buildStorageRecord(Request $request)
    {
        if(isset($request->technical_support_node)){
            $node = Nodo::find($request->technical_support_node);
        }
        if(isset($request->technical_support_line)){
            $line = LineaTecnologica::where('id', $request->technical_support_line)->first();
        }
        return [
            'linea' => isset($line) ? $line->id : null,
            'nodo' => isset($node) ? $node->id : null,
            'vinculacion' => $request->technical_support_type_relationship,
            'codigo' => $request->technical_support_code_contract,
            'fecha_inicio' => $request->technical_support_start_date_contract,
            'fecha_finalizacion' => $request->technical_support_end_date_contract,
            'valor_contrato' => $request->technical_support_contract_value_contract,
            'honorarios' => $request->technical_support_fees_contract,
        ];
    }

    public function save(Request $request, User $user)
    {
        $infoContract = $this->buildStorageRecord($request);
        $user->apoyotecnico()->updateOrCreate(
            ['role' => User::IsApoyoTecnico()],
            [
                'linea_id' => $infoContract['linea'],
                'nodo_id' =>  $infoContract['nodo'],
                'vinculacion' => $infoContract['vinculacion'],
                'honorarios' =>  $infoContract['honorarios'],
            ]
        );

        if($request->technical_support_type_relationship == 0 && isset($user->apoyotecnico)){

            if(isset($user->apoyotecnico->contratos) && $user->apoyotecnico->contratos->count() ){
                $currentContract = $user->apoyotecnico->contratos()
                ->where('codigo' ,$request->technical_support_code_contract)
                ->whereYear('fecha_inicio', Carbon::now()->year)
                ->latest('contratos.fecha_inicio')
                ->latest('contratos.fecha_finalizacion')
                ->get()->last();
                if(!is_null($currentContract) || isset($currentContract)){
                    $currentContract->update($this->propertiesArray($infoContract));
                }else{
                    $user->apoyotecnico->contratos()->create($this->propertiesArray($infoContract));
                }
            }else{
                $user->apoyotecnico->contratos()->create($this->propertiesArray($infoContract));
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
            $reponse .= "<span class='card-title primary-text center'>Información Apoyo Técnico</span>
                <div class='server-load row'>
                    <div class='server-stat col s6 m6 l3'>
                        <p> {$data->nodo->entidad->nombre}</p>
                        <span>Nodo</span>
                    </div>
                    <div class='server-stat col s6 m6 l3'>
                        <p> {$data->linea->abreviatura} - {$data->linea->nombre}</p>
                        <span>Línea</span>
                    </div>
                    <div class='server-stat col s6 m6 l3'>
                        <p> ".($data->vinculacion == 0 ? 'Contratista' : 'Planta')."</p>
                        <span>Tipo de vinculación</span>
                    </div>
                    <div class='server-stat col s6 m4 l3'>
                        <p>$ ".number_format($data->honorarios, 2)."</p>
                        <span>Honorarios mensulaes</span>
                    </div>
                </div>";
        }else if($data instanceof Contrato){
            $reponse .= "<span class='card-title primary-text center'>Información Apoyo Técnico</span>
            <div class='server-load row'>
                <div class='server-stat col s6 m6 l3'>
                    <p> {$data->apoyotecnico->nodo->entidad->nombre}</p>
                    <span>Nodo</span>
                </div>
                <div class='server-stat col s6 m6 l3'>
                    <p>{$data->apoyotecnico->linea->abreviatura} - {$data->apoyotecnico->linea->nombre}</p>
                    <span>Línea</span>
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
