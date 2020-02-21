<?php

namespace App\Repositories\Repository;

use App\Models\Entidad;

class CentroRepository
{

    /*=======================================================================================
	=            metodo API para consultar los centros de formacion por regional            =
	=======================================================================================*/

    public function getAllCentrosRegional($regional)
    {

        return Entidad::join('centros', 'entidades.id', 'centros.entidad_id')
            ->join('regionales', 'regionales.id', 'centros.regional_id')
            ->where('centros.regional_id', $regional)
            ->pluck('entidades.nombre', 'entidades.id');
    }

    /*=====  End of metodo API para consultar los centros de formacion por regional  ======*/
}
