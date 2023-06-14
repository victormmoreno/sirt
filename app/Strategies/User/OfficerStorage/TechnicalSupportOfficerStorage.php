<?php

namespace App\Strategies\User\OfficerStorage;

use Illuminate\Http\Request;
use App\Contracts\User\OfficerStorage;
use App\Models\Nodo;
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
                ->whereYear('created_at', Carbon::now()->year)->get()->last();
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

    public function buildResponse(array $data)
    {

    }
}
