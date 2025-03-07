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
    protected $countDynamizerOfficers = 1;
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

    /**
     * returns all the dynamizers of a node
     * @return
     */
    protected function queryOfficeByNodo(Request  $request)
    {
        if ($request->filled('dynamizer_node')) {
            return User::whereHas('dinamizador.nodo', function ($query) use ($request) {
                $query->where('id', $request->dynamizer_node);
            });
        }
        return null;
    }


    public function save(Request $request, User $user)
    {
        $dynamizers = $this->queryOfficeByNodo($request)->get();
        if ($dynamizers !== null && $dynamizers->count() >= $this->countDynamizerOfficers) {
            $dynamizers->each(function ($item) {
                if($item->hasRole(User::IsDinamizador())){
                    $item->removeRole(User::IsDinamizador());
                }
                if($item->roles->count() == 0 && !$item->hasRole(User::IsUsuario()))
                {
                    $item->assignRole(User::IsUsuario());
                }
            });
        }
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
                ->where('codigo' ,$request->dynamizer_code_contract)
                ->whereYear('fecha_inicio', Carbon::now()->year)
                ->latest('contratos.fecha_inicio')
                ->latest('contratos.fecha_finalizacion')
                ->get()->last();
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
                        <p>$ ".number_format($data->honorarios, 2)."</p>
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
                    <p>$ ".number_format($data->valor_contrato, 2)."</p>
                    <span>Valor del contrato</span>
                </div>
                <div class='server-stat col s6 m4 l3'>
                    <p>$ ".number_format($data->honorarios, 2)."</p>
                    <span>Honorarios mensulaes</span>
                </div>
            </div>
            <div class='server-load row'>

            </div>";
        }

        return $reponse;
    }
}
