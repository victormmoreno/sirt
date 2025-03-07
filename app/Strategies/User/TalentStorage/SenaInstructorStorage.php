<?php

namespace App\Strategies\User\TalentStorage;

use Illuminate\Http\Request;
use App\Contracts\User\TalentStorage;
use App\Models\TipoTalento;
use App\Models\Regional;
use App\Models\Centro;

class SenaInstructorStorage implements TalentStorage
{
    public function buildStorageRecord(Request $request){
        if(isset($request->regional)){
            $regional = Regional::find($request->regional);
        }
        if(isset($request->centro_formacion)){
            $centro_formacion = Centro::has('entidad')->where('id', $request->centro_formacion)->first();
        }
        return [
            'tipo_talento' => TipoTalento::IS_INSTRUCTOR_SENA,
            'regional' => isset($regional) ? $regional->nombre : null,
            'centro_formacion' => isset($centro_formacion->entidad) ? $centro_formacion->entidad->nombre : null,
        ];
    }

    public function buildResponse(array $data)
    {
        return "<span class='card-title primary-text center'>Información Talento</span>
        <div class='server-load row'>
            <div class='server-stat col s6 m6 l4'>
                <p>".$data['talento']['tipo_talento']."</p>
                <span>Tipo Talento</span>
            </div>
            <div class='server-stat col s6 m6 l4'>
                <p>".$data['talento']['regional']."</p>
                <span>Regional</span>
            </div>
            <div class='server-stat col s6 m6 l4'>
                <p>".$data['talento']['centro_formacion']."</p>
                <span>Centro de Formación</span>
            </div>
        </div>";
    }
}
