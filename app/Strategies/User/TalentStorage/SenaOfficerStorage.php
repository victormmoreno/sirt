<?php

namespace App\Strategies\User\TalentStorage;

use Illuminate\Http\Request;
use App\Contracts\User\TalentStorage;
use App\Models\TipoTalento;
use App\Models\Regional;
use App\Models\Centro;


class SenaOfficerStorage implements TalentStorage
{
    public function buildStorageRecord(Request $request){
        if(isset($request->regional)){
            $regional = Regional::find($request->regional);
        }
        if(isset($request->centro_formacion)){
            $centro_formacion = Centro::with('entidad')->where('id', $request->centro_formacion)->first();
        }
        return [
            'tipo_talento' => TipoTalento::IS_FUNCIONARIO_SENA,
            'regional' => isset($regional) ? $regional->nombre : null,
            'centro_formacion' => isset($centro_formacion->entidad) ? $centro_formacion->entidad->nombre : null,
            'dependencia' => isset($request->dependencia) ? $request->dependencia : null,
        ];
    }
}
