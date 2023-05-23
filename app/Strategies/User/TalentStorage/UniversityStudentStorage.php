<?php

namespace App\Strategies\User\TalentStorage;

use Illuminate\Http\Request;
use App\Contracts\User\TalentStorage;
use App\Models\TipoTalento;
use App\Models\TipoEstudio;

class UniversityStudentStorage implements TalentStorage
{
    public function buildStorageRecord(Request $request)
    {
        if(isset($request->tipo_estudio)){
            $tipo_estudio = TipoEstudio::where('id', $request->tipo_estudio)->first();
        }
        return [
            'tipo_talento' => TipoTalento::IS_ESTUDIANTE_UNIVERSITARIO,
            'tipo_estudio' => isset($tipo_estudio) ? $tipo_estudio->nombre : null,
            'universidad' => isset($request->universidad) ? $request->universidad : null,
            'carrera' => isset($request->carrera) ? $request->carrera : null,
        ];
    }
}
