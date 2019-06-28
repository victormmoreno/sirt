<?php

namespace App\Http\Controllers\Help;

use App\Http\Controllers\Controller;
use App\Repositories\Repository\Help\HelpRepository;
use Illuminate\Http\Request;

class HelpController extends Controller
{
	public $helpRepostory;

    public function __construct(HelpRepository $helpRepostory)
    {
        $this->middleware('auth');
        $this->helpRepostory = $helpRepostory;
    }

    /*================================================================================
    =            metodo para consultar las ciudedes segun el departamento            =
    ================================================================================*/

    public function getCiudad($departamento)
    {

        return response()->json([
            'ciudades' => $this->helpRepostory->getAllCiudadDepartamento($departamento),
        ]);
    }

    /*=====  End of metodo para consultar las ciudedes segun el departamento  ======*/

    /*======================================================================================
    =            metodo para consultar los centros de formación segun la regional            =
    ======================================================================================*/
    
    public function getCentrosRegional($regional)
    {

        return response()->json([
            'centros' => $this->helpRepostory->getAllCentrosRegional($regional),
        ]);
    }
    
    
    /*=====  End of metodo para consultar los centros de formación segun la regional  ======*/
    
}
