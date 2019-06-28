<?php

namespace App\Repositories\Repository\Help;

use App\Models\Centro;
use App\Models\Ciudad;

class HelpRepository
{

	/*============================================================================
    =            metodo para consultar las ciudades por departmamento            =
    ============================================================================*/

    public function getAllCiudadDepartamento($departamento)
    {
        return Ciudad::allCiudadDepartamento($departamento)->get();
    }

    /*=====  End of metodo para consultar las ciudades por departmamento  ======*/

    /*======================================================================
    =            metodo para consultar los centros por regional            =
    ======================================================================*/
    
    public function getAllCentrosRegional($regional)
    {
    	return Centro::AllCentrosRegional($regional)->get();
    }
    
    /*=====  End of metodo para consultar los centros por regional  ======*/
    
}


