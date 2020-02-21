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
	 * @param string $fecha_fin Segunda fecha para realizar el filtro
	 * @return Builder
	 * @author dum
	 */
	public function consultarTalentosAsociadosAProyectos($fecha_inicio, $fecha_fin)
	{
		return User::select('codigo_actividad',
		'documento',
		'nombres',
		'email',
		'apellidos')
		->selectRaw('CONCAT(celular, "; ", users.telefono) AS contactos')
		->join('talentos', 'talentos.user_id', '=', 'users.id')
		->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.talento_id', '=', 'talentos.id')
		->join('articulacion_proyecto', 'articulacion_proyecto_talento.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
		->join('proyectos', 'proyectos.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
		->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
		->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
		->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
		->where(function($q) use ($fecha_inicio, $fecha_fin) {
			$q->where(function($query) use ($fecha_inicio, $fecha_fin) {
				$query->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])
				->where('proyectos.estado_aprobacion', 1);
			})
			->orWhere(function($query) use ($fecha_inicio, $fecha_fin) {
				$query->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin]);
			});
		})
		->orderBy('nombres');
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
