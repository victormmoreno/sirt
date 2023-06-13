<?php

namespace App\Strategies\User\OfficerStorage;

use Illuminate\Http\Request;
use App\Contracts\User\OfficerStorage;
use App\Models\Nodo;
use App\Models\LineaTecnologica;
use App\User;
use Carbon\Carbon;



class ExpertOfficerStorage implements OfficerStorage
{
    public function buildStorageRecord(Request $request)
    {
        if(isset($request->expert_node)){
            $node = Nodo::find($request->expert_node);
        }
        if(isset($request->centro_formacion)){
            $line = LineaTecnologica::where('id', $request->expert_line)->first();
        }
        return [
            'linea' => isset($line) ? $line->id : null,
            'nodo' => isset($node) ? $node->id : null,
            'vinculacion' => $request->expert_type_relationship,
            'codigo' => $request->expert_code_contract,
            'fecha_inicio' => $request->expert_start_date_contract,
            'fecha_finalizacion' => $request->expert_end_date_contract,
            'valor_contrato' => $request->expert_contract_value_contract,
            'honorarios' => $request->expert_fees_contract,
        ];
    }

    public function save(Request $request, User $user)
    {
        $infoContract = $this->buildStorageRecord($request);
        $user->experto()->updateOrCreate(
            ['role' => User::IsExperto()],
            [
                'linea_id' => $infoContract['linea'],
                'nodo_id' =>  $infoContract['nodo'],
                'vinculacion' => $infoContract['vinculacion'],
                'honorarios' =>  $infoContract['honorarios'],
            ]
        );

        if($request->expert_type_relationship == 0 && isset($user->experto)){

            if(isset($user->experto->contratos) && $user->experto->contratos->count() ){
                $currentContract = $user->experto->contratos()
                ->whereYear('created_at', Carbon::now()->year)->get()->last();
                if(!is_null($currentContract) || isset($currentContract)){
                    $currentContract->update($this->propertiesArray($infoContract));
                }else{
                    $user->experto->contratos()->create($this->propertiesArray($infoContract));
                }
            }else{
                $user->experto->contratos()->create($this->propertiesArray($infoContract));
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
