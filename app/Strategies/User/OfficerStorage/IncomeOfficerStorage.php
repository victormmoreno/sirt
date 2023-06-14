<?php

namespace App\Strategies\User\OfficerStorage;

use Illuminate\Http\Request;
use App\Contracts\User\OfficerStorage;
use App\Models\Nodo;
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
                ->whereYear('created_at', Carbon::now()->year)->get()->last();
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

    public function buildResponse(array $data)
    {

    }
}
