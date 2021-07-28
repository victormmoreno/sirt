<?php

namespace App\Repositories\Repository\UserRepository;

use App\User;
use App\Models\{Talento, Proyecto};

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
     * Consulta los talentos asociados a los proyectos como propietarios
     * @param string $fecha_inicio Primera fecha para realizar el filtro
     * @param string $fecha_cierre Segunda fecha para realizar el filtro
     * @return Builder
     * @author dum
     */
    public function talentosPropietarios($fecha_inicio, $fecha_cierre)
    {
        return User::select(
            'codigo_actividad',
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
            'apellidos',
			'actividades.nombre',
			'lineastecnologicas.nombre AS nombre_linea',
			'sublineas.nombre AS nombre_sublinea',
			'areasconocimiento.nombre AS nombre_areaconocimiento',
			'fecha_inicio',
			'fases.nombre AS nombre_fase',
			'entidades.nombre AS nodo_nombre'
        )
            ->selectRaw('CONCAT(celular, "; ", users.telefono) AS contactos')
            ->selectRaw('CONCAT(ciudades.nombre, " - ", departamentos.nombre) AS ciudad_residencia')
            ->selectRaw('IF(eps.nombre = "Otra", otra_eps, "No aplica") AS otra_eps')
            ->selectRaw('IF(grado_discapacidad = 0, "No", "Si") AS grado_discapacidad')
            ->selectRaw('IF(grado_discapacidad = 0, "No aplica", descripcion_grado_discapacidad) AS descripcion_grado_discapacidad')
            ->selectRaw('IF(genero = ' . User::IsMasculino() . ', "Masculino", "Femenino") AS genero')
			->selectRaw('concat(ideas.codigo_idea, " - ", ideas.nombre_proyecto) AS nombre_idea')
			->selectRaw('concat(users.documento, " - ", users.nombres, " ", users.apellidos) AS gestor')
			->selectRaw('IF(pp.trl_esperado = '.Proyecto::IsTrl6Esperado().', "TRL 6", "TRL 7 - TRL 8") AS trl_esperado')
			->selectRaw('IF(fases.nombre = "Finalizado", IF(pp.trl_obtenido = 0, "TRL 6", IF(pp.trl_obtenido = 1, "TRL 7", "TRL 8")), "El proyecto no se ha cerrado") AS trl_obtenido')
			->selectRaw('IF(fases.nombre = "Finalizado" || fases.nombre = "Suspendido", fecha_cierre, "El proyecto no se ha cerrado") AS fecha_cierre')
			->selectRaw('IF(areasconocimiento.nombre = "Otro", pp.otro_areaconocimiento, "No aplica") AS otro_areaconocimiento')
			->selectRaw('IF(pp.fabrica_productividad = 0, "No", "Si") AS fabrica_productividad')
			->selectRaw('IF(pp.reci_ar_emp = 0, "No", "Si") AS reci_ar_emp')
			->selectRaw('IF(pp.economia_naranja = 0, "No", "Si") AS economia_naranja')
			->selectRaw('IF(pp.economia_naranja = 0, "No aplica", pp.tipo_economianaranja) AS tipo_economianaranja')
			->selectRaw('IF(pp.dirigido_discapacitados = 0, "No", "Si") AS dirigido_discapacitados')
			->selectRaw('IF(pp.dirigido_discapacitados = 0, "No aplica", pp.tipo_discapacitados) AS tipo_discapacitados')
			->selectRaw('IF(pp.art_cti = 0, "No", "Si") AS art_cti')
			->selectRaw('IF(pp.art_cti = 0, "No aplica", pp.nom_act_cti) AS nom_act_cti')
			->selectRaw('IF(fases.nombre = "Cierre", IF(pp.diri_ar_emp = 0, "No", "Si"), "El proyecto no se ha cerrado") AS diri_ar_emp')
			->selectRaw('DATE_FORMAT(fecha_cierre, "%Y") AS anho')
			->selectRaw('DATE_FORMAT(fecha_cierre, "%m") AS mes')
            ->join('talentos', 'talentos.user_id', '=', 'users.id')
            ->join('propietarios', 'propietarios.propietario_id', '=', 'users.id')
            ->join('proyectos', 'proyectos.id', '=', 'propietarios.proyecto_id')
            ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
            ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')

            ->join('gruposanguineos', 'gruposanguineos.id', '=', 'users.gruposanguineo_id')

			->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
            ->join('ciudades', 'ciudades.id', '=', 'users.ciudad_id')
			->join('proyectos AS pp', 'pp.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
            ->join('nodos', 'nodos.id', '=', 'pp.nodo_id')
            ->join('gestores', 'gestores.id', '=', 'pp.asesor_id')
            ->join('fases', 'fases.id', '=', 'pp.fase_id')
            ->join('eps', 'eps.id', '=', 'users.eps_id')
            ->join('departamentos', 'departamentos.id', '=', 'ciudades.departamento_id')
            ->join('etnias', 'etnias.id', '=', 'users.etnia_id')
            ->join('gradosescolaridad', 'gradosescolaridad.id', '=', 'users.gradoescolaridad_id')
            ->join('tipo_talentos', 'tipo_talentos.id', '=', 'talentos.tipo_talento_id')
			->join('sublineas', 'sublineas.id', '=', 'pp.sublinea_id')
			->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
			->join('areasconocimiento', 'areasconocimiento.id', '=', 'pp.areaconocimiento_id')
			->leftJoin('ideas', 'ideas.id', '=', 'pp.idea_id')
            ->where('propietario_type', 'App\User')
            ->where(function ($q) use ($fecha_inicio, $fecha_cierre) {
                $q->where(function ($query) use ($fecha_inicio, $fecha_cierre) {
                    $query->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_cierre]);
                })
				->orWhere(function($query) use ($fecha_inicio, $fecha_cierre) {
					$query->where(function($query) use ($fecha_inicio, $fecha_cierre) {
					$query->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_cierre]);
                        $query->orWhere(function ($query) {
                            $query->whereIn('fases.nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre']);
                        });
                    });
				});
            })
            ->orderBy('codigo_actividad')
            ->withTrashed();
    }

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
		'apellidos',
		'actividades.nombre',
		'lineastecnologicas.nombre AS nombre_linea',
		'sublineas.nombre AS nombre_sublinea',
		'areasconocimiento.nombre AS nombre_areaconocimiento',
		'fecha_inicio',
		'fases.nombre AS nombre_fase',
		'entidades.nombre AS nodo_nombre')
		->selectRaw('CONCAT(celular, "; ", users.telefono) AS contactos')
		->selectRaw('CONCAT(ciudades.nombre, " - ", departamentos.nombre) AS ciudad_residencia')
		->selectRaw('IF(eps.nombre = "Otra", otra_eps, "No aplica") AS otra_eps')
		->selectRaw('IF(grado_discapacidad = 0, "No", "Si") AS grado_discapacidad')
		->selectRaw('IF(grado_discapacidad = 0, "No aplica", descripcion_grado_discapacidad) AS descripcion_grado_discapacidad')
		->selectRaw('IF(genero = '.User::IsMasculino().', "Masculino", "Femenino") AS genero')
		->selectRaw('concat(ideas.codigo_idea, " - ", ideas.nombre_proyecto) AS nombre_idea')
		->selectRaw('concat(users.documento, " - ", users.nombres, " ", users.apellidos) AS gestor')
		->selectRaw('IF(pp.trl_esperado = '.Proyecto::IsTrl6Esperado().', "TRL 6", "TRL 7 - TRL 8") AS trl_esperado')
		->selectRaw('IF(fases.nombre = "Finalizado", IF(pp.trl_obtenido = 0, "TRL 6", IF(pp.trl_obtenido = 1, "TRL 7", "TRL 8")), "El proyecto no se ha cerrado") AS trl_obtenido')
		->selectRaw('IF(fases.nombre = "Finalizado" || fases.nombre = "Suspendido", fecha_cierre, "El proyecto no se ha cerrado") AS fecha_cierre')
		->selectRaw('IF(areasconocimiento.nombre = "Otro", pp.otro_areaconocimiento, "No aplica") AS otro_areaconocimiento')
		->selectRaw('IF(pp.fabrica_productividad = 0, "No", "Si") AS fabrica_productividad')
		->selectRaw('IF(pp.reci_ar_emp = 0, "No", "Si") AS reci_ar_emp')
		->selectRaw('IF(pp.economia_naranja = 0, "No", "Si") AS economia_naranja')
		->selectRaw('IF(pp.economia_naranja = 0, "No aplica", pp.tipo_economianaranja) AS tipo_economianaranja')
		->selectRaw('IF(pp.dirigido_discapacitados = 0, "No", "Si") AS dirigido_discapacitados')
		->selectRaw('IF(pp.dirigido_discapacitados = 0, "No aplica", pp.tipo_discapacitados) AS tipo_discapacitados')
		->selectRaw('IF(pp.art_cti = 0, "No", "Si") AS art_cti')
		->selectRaw('IF(pp.art_cti = 0, "No aplica", pp.nom_act_cti) AS nom_act_cti')
		->selectRaw('IF(fases.nombre = "Cierre", IF(pp.diri_ar_emp = 0, "No", "Si"), "El proyecto no se ha cerrado") AS diri_ar_emp')
		->selectRaw('DATE_FORMAT(fecha_cierre, "%Y") AS anho')
		->selectRaw('DATE_FORMAT(fecha_cierre, "%m") AS mes')
		->join('talentos', 'talentos.user_id', '=', 'users.id')
		->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.talento_id', '=', 'talentos.id')
		->join('articulacion_proyecto', 'articulacion_proyecto_talento.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
		->join('proyectos', 'proyectos.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
		->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
		->join('gruposanguineos', 'gruposanguineos.id', '=', 'users.gruposanguineo_id')
		->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
		->join('ciudades', 'ciudades.id', '=', 'users.ciudad_id')
		->join('proyectos AS pp', 'pp.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
        ->join('gestores', 'gestores.id', '=', 'pp.asesor_id')
        ->join('nodos', 'nodos.id', '=', 'pp.nodo_id')
		->join('fases', 'fases.id', '=', 'pp.fase_id')
		->join('eps', 'eps.id', '=', 'users.eps_id')
		->join('departamentos', 'departamentos.id', '=', 'ciudades.departamento_id')
		->join('etnias', 'etnias.id', '=', 'users.etnia_id')
		->join('gradosescolaridad', 'gradosescolaridad.id', '=', 'users.gradoescolaridad_id')
		->join('tipo_talentos', 'tipo_talentos.id', '=', 'talentos.tipo_talento_id')
		->join('sublineas', 'sublineas.id', '=', 'pp.sublinea_id')
		->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
		->join('areasconocimiento', 'areasconocimiento.id', '=', 'pp.areaconocimiento_id')
		->leftJoin('ideas', 'ideas.id', '=', 'pp.idea_id')
		->where(function($q) use ($fecha_inicio, $fecha_cierre) {
			$q->where(function($query) use ($fecha_inicio, $fecha_cierre) {
				$query->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_cierre]);
			})
			->orWhere(function($query) use ($fecha_inicio, $fecha_cierre) {
				$query->where(function($query) use ($fecha_inicio, $fecha_cierre) {
				$query->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_cierre]);
                    $query->orWhere(function ($query) {
                        $query->whereIn('fases.nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre']);
                    });
                });
			});
		})
		->orderBy('codigo_actividad')
		->withTrashed();
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
		->join('nodos', 'nodos.id', '=', 'proyectos.nodo_id')
		->groupBy('talentos.id');
	}
}
