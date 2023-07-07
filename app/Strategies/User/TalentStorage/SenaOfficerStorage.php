<?php

namespace App\Strategies\User\TalentStorage;

use Illuminate\Http\Request;
use App\Contracts\User\TalentStorage;
use App\Models\Centro;
use App\Models\TipoTalento;
use App\Models\Regional;


class SenaOfficerStorage implements TalentStorage
{
    public function buildStorageRecord(Request $request){
        if(isset($request->regional)){
            $regional = Regional::find($request->regional);
        }
        if(isset($request->centro_formacion)){
            $centro = Centro::has('entidad')->where('id', $request->centro_formacion)->first();
        }
        return [
            'tipo_talento' => TipoTalento::IS_FUNCIONARIO_SENA,
            'regional' => isset($regional) ? $regional->nombre : null,
            'centro_formacion' => isset($centro->entidad) ? $centro->entidad->nombre : null,
            'dependencia' => isset($request->dependencia) ? $request->dependencia : null,
        ];
    }

    public function buildResponse(array $data)
    {
        return "<span class='card-title primary-text center'>Información Talento</span>
                <div class='server-load row'>
                    <div class='server-stat col s12 m6 l6'>
                        <p>".$data['talento']['tipo_talento']."</p>
                        <span>Tipo Talento</span>
                    </div>
                    <div class='server-stat col s12 m6 l6'>
                        <p>".$data['talento']['regional']."</p>
                        <span>Regional</span>
                    </div>
                    <div class='server-stat col s12 m6 l6'>
                        <p>".$data['talento']['centro_formacion']."</p>
                        <span>Centro de Formación</span>
                    </div>
                    <div class='server-stat col s12 m6 l6'>
                        <p>".$data['talento']['dependencia']."</p>
                        <span>Dependencia</span>
                    </div>
                </div>";
    }
}
