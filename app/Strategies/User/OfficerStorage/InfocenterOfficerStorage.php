<?php

namespace App\Strategies\User\OfficerStorage;

use Illuminate\Http\Request;
use App\Contracts\User\OfficerStorage;
use App\Models\Nodo;
use App\User;
use Carbon\Carbon;

class InfocenterOfficerStorage implements OfficerStorage
{
    public function buildStorageRecord(Request $request)
    {
        if(isset($request->infocenter_node)){
            $node = Nodo::find($request->infocenter_node);
        }
        return [
            'nodo' => isset($node) ? $node->id : null,
            'vinculacion' => $request->infocenter_type_relationship,
            'codigo' => $request->infocenter_code_contract,
            'fecha_inicio' => $request->infocenter_start_date_contract,
            'fecha_finalizacion' => $request->infocenter_end_date_contract,
            'valor_contrato' => $request->infocenter_contract_value_contract,
            'honorarios' => $request->infocenter_fees_contract,
        ];
    }

    public function save(Request $request, User $user)
    {
        $infoContract = $this->buildStorageRecord($request);
        $user->infocenter()->updateOrCreate(
            ['role' => User::IsInfocenter()],
            [
                'linea_id' => null,
                'nodo_id' =>  $infoContract['nodo'],
                'vinculacion' => $infoContract['vinculacion'],
                'honorarios' =>  $infoContract['honorarios'],
            ]
        );

        if($request->infocenter_type_relationship == 0 && isset($user->infocenter)){

            if(isset($user->infocenter->contratos) && $user->infocenter->contratos->count() ){
                $currentContract = $user->infocenter->contratos()
                ->whereYear('created_at', Carbon::now()->year)->get()->last();
                if(!is_null($currentContract) || isset($currentContract)){
                    $currentContract->update($this->propertiesArray($infoContract));
                }else{
                    $user->infocenter->contratos()->create($this->propertiesArray($infoContract));
                }
            }else{
                $user->infocenter->contratos()->create($this->propertiesArray($infoContract));
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
