<?php

namespace App\Strategies\User\TalentStorage;

use Illuminate\Http\Request;
use App\Contracts\User\TalentStorage;
use App\Models\TipoTalento;
use App\Models\Regional;
use App\Models\Centro;


class ApprenticeWithContratStorage implements TalentStorage
{
    public function buildStorageRecord(Request $request)
    {
        if(isset($request->regional)){
            $regional = Regional::find($request->regional);
        }
        if(isset($request->centro_formacion)){
            $centro_formacion = Centro::with('entidad')->where('id', $request->centro_formacion)->first();
        }
        return [
            'tipo_talento' => TipoTalento::IS_APRENDIZ_SENA_CON_APOYO,
            'regional' => isset($regional) ? $regional->nombre : null,
            'centro_formacion' => isset($centro_formacion->entidad) ? $centro_formacion->entidad->nombre : null,
            'programa_formacion' => isset($request->programa_formacion) ? $request->programa_formacion : null,
        ];
    }

    public function buildResponse(array $data)
    {
        return "<span class='card-title primary-text center'>Información Talento</span>
                <div class='server-load row'>
                    <div class='server-stat col s6 m6 l6'>
                        <p>".$data['talento']['tipo_talento']."</p>
                        <span>Tipo Talento</span>
                    </div>
                    <div class='server-stat col s6 m6 l6'>
                        <p>".$data['talento']['regional']." / ".$data['talento']['centro_formacion']."</p>
                        <span>Regional / Centro de Formación</span>
                    </div>

                </div>
                <div class='server-load row'>
                    <div class='server-stat col s6 m4 l6'>
                        <p>".$data['talento']['programa_formacion']."</p>
                        <span>Programa de Formación</span>
                    </div>
                </div>";

    }
}
