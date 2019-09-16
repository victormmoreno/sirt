<?php

namespace App\Repositories\Repository;

use App\User;
use App\Models\LineaTecnologica;
use App\Models\Actividad;
use App\Models\usoInfraestructura;
use Illuminate\Support\Facades\DB;

class UsoInfraestructuraRepository
{
	public function store($request)
	{

		DB::beginTransaction();
    	try {

			// $gestor = User::where('documento',explode(" - ", $request->txtgestor)[0])->first()->gestor->id;
			// $linea = LineaTecnologica::where('nombre', $request->txtlinea)->first()->id;
			$actividad = Actividad::where('nombre', $request->txtproyecto)	
									->orWhere('nombre', $request->txtarticulacion)
									->orWhere('nombre', $request->txtedt)
									->first()->id;

			$usoInfraestructura = usoInfraestructura::create([
				'actividad_id' => $actividad,
				'fecha' => $request->txtfecha,
				'asesoria_directa' => isset($request->txtasesoriadirecta) ? $request->txtasesoriadirecta : 0,
				'asesoria_indirecta' => isset($request->txtasesoriaindirecta) ? $request->txtasesoriaindirecta : 0,
				'descripcion' => $request->descripcion,
				'estado' => 1,
			]);

			DB::commit();
	      	return true;
	    } catch (Exception $e) {
	      	DB::rollback();
	      	return false;
	    }
		
	}
}