<?php

namespace App\Http\Controllers\Help;

use App\Http\Controllers\Controller;
use App\Repositories\Repository\Help\CiudadRepository;
use Illuminate\Http\Request;

class CiudadController extends Controller
{
	public $ciudadRepostory;

    public function __construct(CiudadRepository $ciudadRepostory)
    {
        $this->middleware('auth');
        $this->ciudadRepostory = $ciudadRepostory;
    }

    /*================================================================================
    =            metodo para consultar las ciudedes segun el departamento            =
    ================================================================================*/

    public function getCiudad($departamento)
    {

        return response()->json([
            'ciudades' => $this->ciudadRepostory->getAllCiudadDepartamento($departamento),
        ]);
    }

    /*=====  End of metodo para consultar las ciudedes segun el departamento  ======*/
}
