<?php

namespace App\Repositories\Repository\UserRepository;

use App\User;
use App\Models\Talento;

class TalentoRepository
{
	/*===============================================================================
	=            metodo para mostrar todos usuarios talentos del sistema            =
	===============================================================================*/

	public function getAllTalentos()
	{
		return User::InfoUserDatatable()
            ->Join('talentos', 'talentos.user_id', '=', 'users.id')
            ->role(User::IsTalento());
            

	}

	/*=====  End of metodo para mostrar todos usuarios talentos del sistema  ======*/

	/**
	 * Consulta los talentos asociados a los proyectos
	 * @param string $fecha_inicio Primera fecha para realizar el filtro
	 * @param string $fecha_cierre Segunda fecha para realizar el filtro
	 * @return Builder
	 * @author dum
	 */
	public function consultarTalentosAsociadosAProyectos($fecha_inicio, $fecha_cierre)
	{
		return User::select('codigo_actividad',
		'documento',
		'nombres',
		'email',
		'estrato',
		'barrio',
		'fechanacimiento',
		'users.direccion',
		'eps.nombre AS nombre_eps',
		'gruposanguineos.nombre AS tipo_sangre',
		'etnias.nombre AS nombre_etnia',
		'institucion',
		'titulo_obtenido',
		'fecha_terminacion',
		'tipo_talentos.nombre AS nombre_tipotalento',
		'gradosescolaridad.nombre AS nombre_gradoescolaridad',
		'apellidos')
		->selectRaw('CONCAT(celular, "; ", users.telefono) AS contactos')
		->selectRaw('CONCAT(ciudades.nombre, " - ", departamentos.nombre) AS ciudad_residencia')
		->selectRaw('IF(eps.nombre = "Otra", otra_eps, "No aplica") AS otra_eps')
		->selectRaw('IF(grado_discapacidad = 0, "No", "Si") AS grado_discapacidad')
		->selectRaw('IF(grado_discapacidad = 0, "No aplica", descripcion_grado_discapacidad) AS descripcion_grado_discapacidad')
		->selectRaw('IF(genero = '.User::IsMasculino().', "Masculino", "Femenino") AS genero')
		->join('talentos', 'talentos.user_id', '=', 'users.id')
		->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.talento_id', '=', 'talentos.id')
		->join('articulacion_proyecto', 'articulacion_proyecto_talento.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
		->join('proyectos', 'proyectos.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
		->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
		->join('fases', 'fases.id', '=', 'proyectos.fase_id')
		->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
		->join('gruposanguineos', 'gruposanguineos.id', '=', 'users.gruposanguineo_id')
		->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
		->join('ciudades', 'ciudades.id', '=', 'users.ciudad_id')
		->join('eps', 'eps.id', '=', 'users.eps_id')
		->join('departamentos', 'departamentos.id', '=', 'ciudades.departamento_id')
		->join('etnias', 'etnias.id', '=', 'users.etnia_id')
		->join('gradosescolaridad', 'gradosescolaridad.id', '=', 'users.gradoescolaridad_id')
		->join('tipo_talentos', 'tipo_talentos.id', '=', 'talentos.tipo_talento_id')
		->where(function($q) use ($fecha_inicio, $fecha_cierre) {
			$q->where(function($query) use ($fecha_inicio, $fecha_cierre) {
				$query->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_cierre]);
			})
			->orWhere(function($query) use ($fecha_inicio, $fecha_cierre) {
				$query->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_cierre]);
			});
		})
		// ->where(function ($q) use ($fecha_inicio, $fecha_cierre) {
		// 	$q->where(function ($query) use ($fecha_inicio, $fecha_cierre) {
		// 	  $query->whereBetween('actividades.fecha_cierre', [$fecha_inicio, $fecha_cierre])
		// 		->whereIn('fases.nombre', ['Cierre', 'Suspendido']);
		// 	})
		// 	  ->orWhere(function ($query) {
		// 		$query->whereIn('fases.nombre', ['Inicio', 'Planeación', 'Ejecución']);
		// 	  });
		//   })
		->orderBy('codigo_actividad');
	}

	/**
	 * Consulta los talentos
	 *
	 * @return Builder
	 * @author dum
	 */
	public function totalTalentosEnProyectos()
	{
		return Talento::select('talentos.id')
		->join('users', 'users.id', '=', 'talentos.user_id')
		->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.talento_id', '=', 'talentos.id')
		->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'articulacion_proyecto_talento.articulacion_proyecto_id')
		->join('proyectos', 'proyectos.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
		->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
		->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
		->join('perfiles', 'perfiles.id', '=', 'talentos.perfil_id')
		->groupBy('talentos.id');
	}

}
