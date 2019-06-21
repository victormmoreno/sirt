<?php

namespace App\Repositories\Repository;

use App\Models\LineaTecnologica;

class SublineaRepository
{

	public function getAllLineas()
	{
		return LineaTecnologica::allLineas()->get();
	}

}