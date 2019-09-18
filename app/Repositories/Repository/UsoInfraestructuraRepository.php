<?php

namespace App\Repositories\Repository;

use App\User;
use App\Models\LineaTecnologica;
use App\Models\Actividad;
use App\Models\UsoInfraestructura;
use Illuminate\Support\Facades\DB;

class UsoInfraestructuraRepository
{
	public function store($request)
	{

	
		
		DB::beginTransaction();
    	try {

			// $gestor = User::where('documento',explode(" - ", $request->txtgestor)[0])->first()->gestor->id;
			// $linea = LineaTecnologica::where('nombre', $request->txtlinea)->first()->id;
			$actividad = Actividad::where('codigo_actividad', explode(" - ", $request->txtactividad)[0])	
									->first()->id;

			$usoInfraestructura = UsoInfraestructura::create([
				'actividad_id' => $actividad,
				'fecha' => $request->txtfecha,
				'asesoria_directa' => isset($request->txtasesoriadirecta) ? $request->txtasesoriadirecta : '0',
				'asesoria_indirecta' => isset($request->txtasesoriaindirecta) ? $request->txtasesoriaindirecta : '0',
				'descripcion' => $request->txtdescripcion,
				'estado' => 1,
			]);

			if ($request->filled('talento')) {
				
				$usoInfraestructura->usotalentos()->sync($request->get('talento'), false);
			
			}

			if ($request->filled('laboratorio')) {
				$syncData = array();
			    foreach($request->get('laboratorio') as $id => $value){
			    	$syncData[$id] =  array('laboratorio_id'=> $value, 'tiempo' => $request->get('tiempouso')[$id]);
			    }
				$usoInfraestructura->usolaboratorios()->sync($syncData);
			}
			DB::commit();
	      	return 'true';
	    } catch (Exception $e) {
	      	DB::rollback();
	      	return 'false';
	    }
		
	}


	/**
     * retorna query con los usos de infraestructura
     * @return collection
     * @author devjul
     */
    public function getUsoInfraestructuraForUser(array $relations)
    {
        return UsoInfraestructura::usoInfraestructuraWithRelations($relations);
    }
}