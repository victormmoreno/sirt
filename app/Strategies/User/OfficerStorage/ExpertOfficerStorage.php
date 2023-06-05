<?php

namespace App\Strategies\User\OfficerStorage;

use Illuminate\Http\Request;
use App\Contracts\User\OfficerStorage;


class ExpertOfficerStorage implements OfficerStorage
{
    public function buildStorageRecord(Request $request)
    {
        return [
            'nodo_id' => $request->nodo_id,
            'codigo' => $request->codigo,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_finalizacion' => $request->fecha_finalizacion,
            'valor_contrato' => $request->valor_contrato,
            'vinculacion' => $request->vinculacion,
            'honorarios' => $request->honorarios,
            // 'vigencia'
        ];
    }

    public function buildResponse(array $data)
    {

    }
}
