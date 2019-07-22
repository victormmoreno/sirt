<?php

namespace App\Repositories\Repository;

use App\Models\Departamento;

class DepartamentoRepository
{

	/*=====================================================================
	=            metodo para consultar todas los departamentos            =
	=====================================================================*/
	
	public function getAllDepartamentos()
	{
		return Departamento::allDepartamentos()->pluck('nombre','id');
	}
	
	/*=====  End of metodo para consultar todas los departamentos  ======*/
	
}