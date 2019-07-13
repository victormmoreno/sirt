<?php

namespace App\Repositories\Repository;

use App\Models\Centro;

class CentroRepository
{

	/*=======================================================================================
	=            metodo API para consultar los centros de formacion por regional            =
	=======================================================================================*/
	
	public function getAllCentrosRegional($regional)
	{
		return Centro::AllCentrosRegional($regional)->pluck('nombre','id');
	}
	
	/*=====  End of metodo API para consultar los centros de formacion por regional  ======*/
	

}