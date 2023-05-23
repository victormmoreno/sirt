<?php

namespace App\Strategies\User\TalentStorage;

use Illuminate\Http\Request;
use App\Contracts\User\TalentStorage;
use App\Models\TipoTalento;


class CorporateOfficerStorage implements TalentStorage
{
    public function buildStorageRecord(Request $request){
        return [
            'tipo_talento' => TipoTalento::IS_FUNCIONARIO_EMPRESA,
            'empresa' => isset($request->empresa) ? $request->empresa : null
        ];
    }
}
