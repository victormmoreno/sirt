<?php

namespace App\Repositories\Repository\Help;

use App\Models\Ciudad;

class CiudadRepository
{

	/*============================================================================
    =            metodo para consultar las ciudades por departmamento            =
    ============================================================================*/

    public function getAllCiudadDepartamento($departamento)
    {
        return Ciudad::allCiudadDepartamento($departamento)->get();
    }

    /*=====  End of metodo para consultar las ciudades por departmamento  ======*/
}


