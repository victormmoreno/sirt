<?php

namespace App\Strategies\User\TalentStorage;

use Illuminate\Http\Request;
use App\Contracts\User\TalentStorage;
use App\Models\TipoTalento;

class EntrepreneurStorage implements TalentStorage
{
    public function buildStorageRecord(Request $request){
        return [
            'tipo_talento' => TipoTalento::IS_EMPRENDEDOR
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
    }
}
