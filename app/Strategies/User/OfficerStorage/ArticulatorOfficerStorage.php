<?php

namespace App\Strategies\User\OfficerStorage;

use Illuminate\Http\Request;
use App\Contracts\User\OfficerStorage;
use App\Models\Nodo;
use App\User;
use Carbon\Carbon;

class ArticulatorOfficerStorage implements OfficerStorage
{
    public function buildStorageRecord(Request $request)
    {
        if(isset($request->articulator_node)){
            $node = Nodo::find($request->articulator_node);
        }
        return [
            'nodo' => isset($node) ? $node->id : null,
            'vinculacion' => $request->articulator_type_relationship,
            'codigo' => $request->articulator_code_contract,
            'fecha_inicio' => $request->articulator_start_date_contract,
            'fecha_finalizacion' => $request->articulator_end_date_contract,
            'valor_contrato' => $request->articulator_contract_value_contract,
            'honorarios' => $request->articulator_fees_contract,
        ];
    }

    public function save(Request $request, User $user)
    {
        $infoContract = $this->buildStorageRecord($request);
        $user->articulador()->updateOrCreate(
            ['role' => User::IsArticulador()],
            [
                'linea_id' => null,
                'nodo_id' =>  $infoContract['nodo'],
                'vinculacion' => $infoContract['vinculacion'],
                'honorarios' =>  $infoContract['honorarios'],
            ]
        );

        if($request->articulator_type_relationship == 0 && isset($user->articulador)){

            if(isset($user->articulador->contratos) && $user->articulador->contratos->count() ){
                $currentContract = $user->articulador->contratos()
                ->whereYear('created_at', Carbon::now()->year)->get()->last();
                if(!is_null($currentContract) || isset($currentContract)){
                    $currentContract->update($this->propertiesArray($infoContract));
                }else{
                    $user->articulador->contratos()->create($this->propertiesArray($infoContract));
                }
            }else{
                $user->articulador->contratos()->create($this->propertiesArray($infoContract));
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
