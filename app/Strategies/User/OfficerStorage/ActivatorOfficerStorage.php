<?php

namespace App\Strategies\User\OfficerStorage;

use Illuminate\Http\Request;
use App\Contracts\User\OfficerStorage;


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
            // 'vigencia'
        ];
    }

    public function buildResponse(array $data)
    {

    }
}
