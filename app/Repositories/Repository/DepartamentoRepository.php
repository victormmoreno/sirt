<?php

namespace App\Repositories\Repository;

use App\Models\Departamento;

class DepartamentoRepository
{
	public function getAllDepartamentos()
	{
		return Departamento::allDepartamentos()->pluck('nombre','id');
    }
}
