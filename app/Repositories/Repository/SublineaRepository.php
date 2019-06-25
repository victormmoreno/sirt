<?php

namespace App\Repositories\Repository;

use App\Models\LineaTecnologica;
use App\Models\Sublinea;

class SublineaRepository
{

	public function getAllLineas()
	{
		return LineaTecnologica::pluck('nombre','id');
	}

	public function getAllSublineas()
	{
		return Sublinea::allSublineas()->select(['sublineas.id', 'sublineas.nombre', 'lineastecnologicas.nombre as linea'])
						->join('lineastecnologicas','lineastecnologicas.id', 'sublineas.lineatecnologica_id')
						->orderby('lineastecnologicas.nombre', 'asc')
						->get();
	}

	public function findById($id)
	{
		return Sublinea::findOrFail($id);
	}

	public function store($request)
	{
		return Sublinea::create([
			"nombre"    => $request->input('txtnombre'),
            "lineatecnologica_id" => $request->input('txtlinea'),
		]);
	}


	public function update($request,$sublinea)
	{
		return $sublinea->update([
			"nombre"    => $request->input('txtnombre'),
            "lineatecnologica_id" => $request->input('txtlinea'),
		]);


	}

}