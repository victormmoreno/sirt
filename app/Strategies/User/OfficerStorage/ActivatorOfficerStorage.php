<?php

namespace App\Strategies\User\OfficerStorage;

use Illuminate\Http\Request;
use App\Contracts\User\OfficerStorage;
use App\User;
use Carbon\Carbon;

class ActivatorOfficerStorage implements OfficerStorage
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
                ->whereYear('created_at', Carbon::now()->year)->get()->last();
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

    public function buildResponse(array $data)
    {

    }
}
