<?php

namespace App\Strategies\User\TalentStorage;

use Illuminate\Http\Request;
use  App\Contracts\User\TalentStorage;
use App\Models\TipoTalento;

class CorporateOwnerStorage implements TalentStorage
{
    public function buildStorageRecord(Request $request){
        return [
            'tipo_talento' => TipoTalento::IS_PROPIETARIO_EMPRESA,
            'empresa' => isset($request->empresa) ? $request->empresa : null
        ];
    }

    public function buildResponse(array $data)
    {
        return "<div class='server-load row'>
                    <div class='server-stat col s6 m4 l3'>
                        <p>".$data['talento']['tipo_talento']."</p>
                        <span>Tipo Talento</span>
                    </div>
                </div>";
        return "Tipo Talento: ".$data['talento']['tipo_talento']."<br>"."  Empresa: ". (!is_null($data['talento']['empresa']) ? $data['talento']['empresa'] : 'No registra');
    }
}
