<?php

namespace App\Repositories\Repository;


use App\Models\{Proyecto, Entidad, Fase, ControlNotificaciones, Movimiento, Role, Idea, EstadoIdea, Sede, GrupoInvestigacion};
use Illuminate\Support\Facades\{DB, Notification, Storage, Session};
use App\Notifications\Proyecto\{ProyectoAprobarFase, ProyectoAprobarSuspendido, ProyectoSuspendidoAprobado, ProyectoNoAprobarFase};
use Carbon\Carbon;
use App\Events\Proyecto\{ProyectoWasntApproved, ProyectoWasApproved, ProyectoApproveWasRequested, ProyectoSuspenderWasRequested};
use App\User;
use App\Repositories\Repository\Repository;

class ProyectoRepository extends Repository
{

    private $ideaRepository;

    public function __construct(IdeaRepository $ideaRepository = null)
    {
        $this->setIdeaRepository($ideaRepository);
    }

    /**
     * Asgina un valor a $ideaRepository
     * @param object $ideaRepository
     * @return void
     * @author dum
     */
    private function setIdeaRepository($ideaRepository)
    {
        $this->ideaRepository = $ideaRepository;
    }

    /**
     * Retorna el valor de $ideaRepository
     * @return object
     * @author dum
     */
    private function getIdeaRepository()
    {
        return $this->ideaRepository;
    }

    /**
     * Verifica que el nuevo talento interlocutor, sea diferente al actual
     *
     * @param Request $request
     * @param $talentos
     * @return type
     * @author dum
     **/
    private function verificarCambioDeTalentoInterlocutor($talentos_nuevos, $proyecto)
    {
        $talento_nuevo = $this->verificarNuevoTalento($talentos_nuevos);
        $talento_actual = $proyecto->talentos()->wherePivot('talento_lider', 1)->first()->id;
        if ($talento_nuevo == $talento_actual) {
            return false;
        }
        return true;
    }

    /**
     * Verifica el id del nuevo talento interlocutor
     *
     * @param array $talentos_nuevos Nuevos talento de un proyecto
     * @return int
     * @author dum
     **/
    private function verificarNuevoTalento($talentos_nuevos)
    {
        for ($i=0; $i < count($talentos_nuevos); $i++) {
            if ($talentos_nuevos[$i]['talento_lider'] == 1) {
                return $talentos_nuevos[$i]['user_id'];
            }
        }
        return -1;
    }

    /**
     * Verifica que los talentos ejecutores del proyecto se hayan cambiado
     *
     * @param $talentos_actuales
     * @param $talentos_nuevos
     * @return bool
     * @author dum
     **/
    public function verificarCambioDeTalentos($talentos_actuales, $talentos_nuevos)
    {
        if ($talentos_nuevos->count() >= $talentos_actuales->count()) {
            if( $talentos_nuevos->diff($talentos_actuales)->count() == 0 ) {
                return false;
            } else {
                return true;
            }
        } else {
            if( $talentos_actuales->diff($talentos_nuevos)->count() == 0 ) {
                return false;
            } else {
                return true;
            }
        }
    }

    /**
     * Cambia los talentos del proyecto
     *
     * @param Request $request
     * @param Proyecto $proyecto
     * @return array
     * @author dum
     **/
    public function update_talentos($request, $proyecto)
    {
        DB::beginTransaction();
        try {
            $proyecto_actual = $proyecto;
            $talentos_actuales = $proyecto_actual->talentos()->orderBy('id')->get();
            $syncData = array();
            $syncData = $this->arraySyncTalentosDeUnProyecto($request);
            $cambio_talento_interlocutor = $this->verificarCambioDeTalentoInterlocutor($syncData, $proyecto_actual);
            $proyecto->talentos()->sync($syncData, true);
            $cambio_talentos_proyecto = $this->verificarCambioDeTalentos($talentos_actuales, $proyecto->talentos()->orderBy('id')->get());
            if ($cambio_talento_interlocutor) {
                // Historial del cambio de talento interlocutor
                $this->registrarHistorialProyecto($proyecto, 'cambió el talento interlocutor');
            }
            if ($cambio_talentos_proyecto) {
                // Historial del cambio de talentos ejecutores
                $this->registrarHistorialProyecto($proyecto, 'cambió los talentos del proyecto');
            }
            Proyecto::habilitarTalentos($proyecto);
            DB::commit();
            return ['state' => true, 'id' => $proyecto->id];
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return ['state' => false];
        }
    }

    public function registrarHistorialProyecto($proyecto, $movimiento)
    {
        $proyecto->movimientos()->attach(Movimiento::where('movimiento', $movimiento)->first(), [
            'proyecto_id' => $proyecto->id,
            'user_id' => auth()->user()->id,
            'fase_id' => $proyecto->fase_id,
            'role_id' => Role::where('name', session()->get('login_role'))->first()->id
        ]);
    }

    /**
     * Consulta la información de un proyecto
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function selectProyecto()
    {
        return Proyecto::select(
            'codigo_proyecto',
            'proyectos.nombre',
            'areasconocimiento.nombre AS nombre_areaconocimiento',
            'sublineas.nombre AS sublinea_nombre',
            'lineastecnologicas.abreviatura AS abreviatura_linea',
            'lineastecnologicas.nombre AS nombre_linea',
            'fecha_inicio',
            'fecha_cierre',
            'economia_naranja',
            'fases.nombre AS nombre_fase',
            'proyectos.id',
            'proyectos.experto_id'
        )
        ->selectRaw('concat(users.nombres, " ", users.apellidos) AS gestor')
        ->selectRaw('concat(ideas.codigo_idea, " - ", ideas.nombre_proyecto) as nombre_idea')
        ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
        ->join('users', 'users.id', '=', 'proyectos.experto_id')
        ->join('ideas', 'ideas.id', '=', 'proyectos.idea_id')
        ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
        ->join('areasconocimiento', 'areasconocimiento.id', '=', 'proyectos.areaconocimiento_id')
        ->leftJoin('fases', 'fases.id', '=', 'proyectos.fase_id')
        ->join('nodos', 'nodos.id', '=', 'proyectos.nodo_id');
    }

    public function selectProyectosLimiteInicio($nodo, $experto)
    {
        $now = Carbon::now();
        return $this->selectProyecto()->selectRaw('DATEDIFF("'.$now.'", fecha_inicio) as dias')->where('nodos.id', $nodo)
        ->where('fases.nombre', Proyecto::IsInicio())
        ->whereRaw('DATEDIFF("'.$now.'", fecha_inicio) > '.config('app.proyectos.duracion.inicio'))
        ->orderBy('fecha_inicio')
        ->asesor($experto);
    }

    public function selectProyectosLimitePlaneacion($nodo, $experto)
    {
        $now = Carbon::now();
        return $this->selectProyecto()->selectRaw('MAX(hist.created_at) AS aprobacion, DATEDIFF("'.$now.'", hist.created_at) AS dias')
        ->join('movimientos_actividades_users_roles as hist', 'hist.proyecto_id', '=', 'proyectos.id')
        ->join('roles as r', 'r.id', '=', 'hist.role_id')
        ->join('fases as fh', 'fh.id', '=', 'hist.fase_id')
        ->join('movimientos as m', 'm.id', '=', 'hist.movimiento_id')
        ->where('nodos.id', $nodo)
        ->where("m.movimiento", Movimiento::IsAprobar())
        ->where('r.name', User::IsDinamizador())
        ->where('fh.nombre', Proyecto::IsInicio())
        ->where('fases.nombre', Proyecto::IsPlaneacion())
        ->whereRaw('DATEDIFF("'.$now.'", hist.created_at) > '.config('app.proyectos.duracion.planeacion'))
        ->orderBy('hist.created_at')
        ->asesor($experto);
    }

    /**
     * Consulta trls esperado entre fechas
     * @param string $field Trl que se va a consultar
     * @param string $field_date Campo por el que se va a filtrar (fecha)
     * @param string $year Anño de cierre de los proyectos
     * @param array $tipos_trl Tipo de trl que se va a consultar
     * @return Builder
     * @author dum
     **/
    public function consultarTrl(string $field, string $field_date, string $year, array $tipos_trl)
    {
        $this->traducirMeses();
        return Proyecto::select($field)
        ->selectRaw('count(proyectos.id) AS cantidad, nodos.id AS nodo, MONTHNAME(fecha_cierre) AS mes')
        ->join('users', 'users.id', '=', 'proyectos.experto_id')
        ->join('nodos', 'nodos.id', '=', 'proyectos.nodo_id')
        ->join('fases', 'fases.id', '=', 'proyectos.fase_id')
        ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
        ->whereYear($field_date, $year)
        ->whereIn($field, $tipos_trl)
        ->where('fases.nombre', Proyecto::IsFinalizado())
        ->groupBy('nodos.id');
    }

    /**
     * Consulta cantidad de proyecto por fase
     * @param string $fase Fase que se va a filtrar
     * @return Builder
     * @author dum
     **/
    public function proyectosSeguimientoCerrados($year)
    {
        return Proyecto::select('fases.nombre AS fase', 'entidades.nombre')
        ->selectRaw('count(proyectos.id) as cantidad')
        ->join('users', 'users.id', '=', 'proyectos.experto_id')
        ->join('fases', 'fases.id', '=', 'proyectos.fase_id')
        ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
        ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
        ->join('nodos', 'nodos.id', '=', 'proyectos.nodo_id')
        ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
        ->whereIn('fases.nombre', ['Finalizado', 'Cancelado'])
        ->groupBy('entidades.nombre', 'fase')
        ->whereYear('fecha_cierre', $year);
    }


    public function proyectosInscritosPorMes($year)
    {
        $this->traducirMeses();
        return Proyecto::selectRaw('MONTH(fecha_inicio) AS mes, COUNT(proyectos.id) AS cantidad, DATE_FORMAT(fecha_inicio, "%M") AS nombre_mes')
        ->join('users', 'users.id', '=', 'proyectos.experto_id')
        ->join('fases', 'fases.id', '=', 'proyectos.fase_id')
        ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
        ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
        ->join('nodos', 'nodos.id', '=', 'proyectos.nodo_id')
        ->whereYear('fecha_inicio', $year)
        ->groupBy("mes", "nombre_mes")
        ->orderBy("mes");
    }

    public function proyectosCerradosPorMes($year)
    {
        $this->traducirMeses();
        return Proyecto::selectRaw('MONTH(fecha_cierre) AS mes, COUNT(proyectos.id) AS cantidad, DATE_FORMAT(fecha_cierre, "%M") AS nombre_mes')
        ->join('users', 'users.id', '=', 'proyectos.experto_id')
        ->join('fases', 'fases.id', '=', 'proyectos.fase_id')
        ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
        ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
        ->join('nodos', 'nodos.id', '=', 'proyectos.nodo_id')
        ->whereYear('fecha_cierre', $year)
        ->whereIn('fases.nombre', [Proyecto::IsFinalizado()])
        ->groupBy("mes", "nombre_mes")
        ->orderBy("mes");
    }

    public function proyectosSeguimientoAbiertos()
    {
        return Proyecto::join('users', 'users.id', '=', 'proyectos.experto_id')
        ->join('nodos', 'nodos.id', '=', 'proyectos.nodo_id')
        ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
        ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
        ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
        ->join('fases', 'fases.id', '=', 'proyectos.fase_id')
        ->whereIn('fases.nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre']);
    }

    /**
     * Consulta de indicadores
     *
     * @return Builder
     * @author dum
     **/
    public function indicadoresProyectos()
    {
        $sede = Sede::class;
        $user = User::class;
        $grupo = GrupoInvestigacion::class;
        return $this->proyectosIndicadoresSeparados_Repository()->selectRaw('GROUP_CONCAT(empresas.nit, " - ", empresas.nombre, ";") AS empresas')
        ->selectRaw('GROUP_CONCAT(up.nombres, " ",up.apellidos,";") AS personas')
        ->selectRaw('GROUP_CONCAT(gruposinvestigacion.codigo_grupo, " ", eg.nombre, ";") AS grupos')
        ->join('propietarios', 'propietarios.proyecto_id', '=', 'proyectos.id')
        ->leftJoin('sedes', function($q) use ($sede) {$q->on('sedes.id', '=', 'propietarios.propietario_id')->where('propietarios.propietario_type', "$sede");})
        ->leftJoin('empresas', 'empresas.id', '=', 'sedes.empresa_id')
        ->leftJoin('users AS up', function($q) use ($user) {$q->on('up.id', '=', 'propietarios.propietario_id')->where('propietarios.propietario_type', "$user");})
        ->leftJoin('gruposinvestigacion', function($q) use ($grupo) {$q->on('gruposinvestigacion.id', '=', 'propietarios.propietario_id')->where('propietarios.propietario_type', "$grupo");})
        ->leftJoin('entidades AS eg', 'eg.id', '=', 'gruposinvestigacion.entidad_id')
        ->groupBy('proyectos.id');
    }

    /**
     * Retornar el query de proyectos
     *
     * @return Builder
     * @author dum
     */
    public function proyectosIndicadoresSeparados_Repository()
    {
        return Proyecto::select(
            'entidades.nombre AS nombre_nodo', 'lineastecnologicas.nombre AS nombre_linea', 'sublineas.nombre AS nombre_sublinea',
            'ideas.codigo_idea', 'ideas.nombre_proyecto AS nombre_idea', 'codigo_proyecto',
            'areasconocimiento.nombre AS nombre_area_conocimiento', 'otro_areaconocimiento', 'fecha_inicio',
            'fases.nombre AS nombre_fase', 'fecha_cierre', 'proyectos.id', 'proyectos.nombre AS nombre_proyecto'
        )
        ->selectRaw('concat(users.nombres, " ", users.apellidos) AS experto')
        ->selectRaw('IF(trl_esperado = '.Proyecto::IsTrl6Esperado().', "TRL 6", "TRL 7 - TRL 8") AS trl_esperado')
        ->selectRaw('IF(fases.nombre = "'.Proyecto::IsFinalizado().'", IF(trl_obtenido = 0, "TRL 6", IF(trl_obtenido = 1, "TRL 7", "TRL 8")), "El proyecto no se ha cerrado ó se ha cancelado") AS trl_obtenido')
        ->selectRaw('IF(fabrica_productividad = 0, "No", "Si") AS fabrica_productividad')
        ->selectRaw('IF(reci_ar_emp = 0, "No", "Si") AS reci_ar_emp')
        ->selectRaw('IF(economia_naranja = 0, "No", "Si") AS economia_naranja')
        ->selectRaw('IF(economia_naranja = 0, "No aplica", tipo_economianaranja) AS tipo_economianaranja')
        ->selectRaw('IF(dirigido_discapacitados = 0, "No", "Si") AS dirigido_discapacitados')
        ->selectRaw('IF(dirigido_discapacitados = 0, "No aplica", tipo_discapacitados) AS tipo_discapacitados')
        ->selectRaw('IF(art_cti = 0, "No", "Si") AS art_cti')
        ->selectRaw('IF(art_cti = 0, "No aplica", nom_act_cti) AS nom_act_cti')
        ->selectRaw('IF(fases.nombre = "'.Proyecto::IsFinalizado().'", IF(diri_ar_emp = 0, "No", "Si"), "El proyecto no se ha cerrado") AS diri_ar_emp')
        ->selectRaw('DATE_FORMAT(fecha_cierre, "%Y") AS anho')
        ->selectRaw('DATE_FORMAT(fecha_cierre, "%m") AS mes')
        ->join('nodos', 'nodos.id', '=', 'proyectos.nodo_id')
        ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
        ->join('ideas', 'ideas.id', '=', 'proyectos.idea_id')
        ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
        ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
        ->join('areasconocimiento', 'areasconocimiento.id', '=', 'proyectos.areaconocimiento_id')
        ->join('fases', 'fases.id', '=', 'proyectos.fase_id')
        ->join('users', 'users.id', '=', 'proyectos.experto_id')
        ->orderBy('entidades.nombre');
    }

    /**
     * Retornar el query para mostrar las empresas asociadas a proyectos
     *
     * @return Builder
     * @author dum
     **/
    public function indicadoresEmpresas()
    {
        $sede = Sede::class;
        return $this->proyectosIndicadoresSeparados_Repository()->selectRaw('nit, codigo_ciiu, empresas.nombre AS nombre_empresa, fecha_creacion, sectores.nombre AS nombre_sector,
            sedes.direccion AS direccion_empresa, empresas.email AS email_empresa, tamanhos_empresas.nombre AS tamanho_empresa,
            tipos_empresas.nombre AS tipo_empresa, fecha_creacion, concat(ciudades.nombre, " - ", departamentos.nombre) AS ciudad_empresa')
        ->join('propietarios', 'propietarios.proyecto_id', '=', 'proyectos.id')
        ->join('sedes', function($q) use ($sede) {$q->on('sedes.id', '=', 'propietarios.propietario_id')->where('propietarios.propietario_type', "$sede");})
        ->join('empresas', 'empresas.id', '=', 'sedes.empresa_id')
        ->leftJoin('ciudades', 'ciudades.id', '=', 'sedes.ciudad_id')
        ->leftJoin('departamentos', 'departamentos.id', '=', 'ciudades.departamento_id')
        ->leftJoin('sectores', 'sectores.id', '=', 'empresas.sector_id')
        ->leftJoin('tamanhos_empresas', 'tamanhos_empresas.id', '=', 'empresas.tamanhoempresa_id')
        ->leftJoin('tipos_empresas', 'tipos_empresas.id', '=', 'empresas.tipoempresa_id');
    }

    /**
     * Retornar el query para mostrar los grupos de investigación asociadas a proyectos
     *
     * @return Builder
     * @author dum
     **/
    public function indicadoresGrupos()
    {
        $grupo = GrupoInvestigacion::class;
        return $this->proyectosIndicadoresSeparados_Repository()->selectRaw('
            codigo_grupo, eg.nombre AS nombre_grupo, IF(tipogrupo=1,"SENA","Externo") AS tipogrupo, gruposinvestigacion.institucion AS institucion_grupo, clasificacionescolciencias.nombre AS nombre_clasificacion,
            eg.email_entidad AS email_grupo, concat(cg.nombre, " - ", dg.nombre) AS ciudad_grupo
        ')
        ->join('propietarios', 'propietarios.proyecto_id', '=', 'proyectos.id')
        ->join('gruposinvestigacion', function($q) use ($grupo) {$q->on('gruposinvestigacion.id', '=', 'propietarios.propietario_id')->where('propietarios.propietario_type', "$grupo");})
        ->join('entidades AS eg', 'eg.id', '=', 'gruposinvestigacion.entidad_id')
        ->join('clasificacionescolciencias', 'clasificacionescolciencias.id', '=', 'gruposinvestigacion.clasificacioncolciencias_id')
        ->join('ciudades AS cg', 'cg.id', '=', 'eg.ciudad_id')
        ->join('departamentos AS dg', 'dg.id', '=', 'cg.departamento_id');
    }

    /**
     * Retornar el query para mostrar las personas dueñas de la propiedad intelectual asociadas a proyectos
     *
     * @return Builder
     * @author dum
     **/
    public function indicadoresUsers()
    {
        $user = User::class;
        return $this->proyectosIndicadoresSeparados_Repository()->selectRaw('up.informacion_user->>"$.talento.tipo_talento" AS tipo_talento,
            up.documento, up.nombres, up.apellidos, up.email, up.celular, up.telefono, gruposanguineos.nombre AS nombre_gruposanguineo, up.estrato,
            IF(up.genero=0,"Femenino",IF(up.genero=1,"Masculino","No binario")) as genero, concat(cr.nombre, " - ", dr.nombre) AS ciudad_residencia, up.direccion,
            up.barrio, up.fechanacimiento, eps.nombre AS nombre_eps, IF(eps.nombre="Otra",up.otra_eps,"No aplica") AS otra_eps, etnias.nombre AS etnia,
            IF(up.grado_discapacidad=1,"Si","No") AS grado_discapacidad, IF(up.grado_discapacidad=1,up.descripcion_grado_discapacidad,"No aplica") AS descripcion_grado_discapacidad,
            IF(up.mujerCabezaFamilia=1,"Si","No") AS mujerCabezaFamilia, IF(up.desplazadoPorViolencia=1,"Si","No") AS desplazadoPorViolencia, up.institucion,
            up.titulo_obtenido, up.fecha_terminacion
        ')
        ->join('propietarios', 'propietarios.proyecto_id', '=', 'proyectos.id')
        ->join('users AS up', function($q) use ($user) {$q->on('up.id', '=', 'propietarios.propietario_id')->where('propietarios.propietario_type', "$user");})
        ->leftjoin('gruposanguineos', 'gruposanguineos.id', '=', 'up.gruposanguineo_id')
        ->leftjoin('ciudades AS cr', 'cr.id', '=', 'up.ciudad_id')
        ->leftjoin('departamentos AS dr', 'dr.id', '=', 'cr.departamento_id')
        ->leftjoin('eps', 'eps.id', '=', 'up.eps_id')
        ->leftjoin('etnias', 'etnias.id', '=', 'up.etnia_id');
    }

    /**
     * Retornar el query para mostrar los talentos ejectuores asociados a proyectos
     *
     * @return Builder
     * @author dum
     **/
    public function indicadoresUsersEjecutores()
    {
        return $this->proyectosIndicadoresSeparados_Repository()->selectRaw('ue.informacion_user->>"$.talento.tipo_talento" AS tipo_talento,
            ue.documento, ue.nombres, ue.apellidos, ue.email, ue.celular, ue.telefono, gruposanguineos.nombre AS nombre_gruposanguineo, ue.estrato,
            IF(ue.genero=0,"Femenino",IF(ue.genero=1,"Masculino","No binario")) as genero, concat(cr.nombre, " - ", dr.nombre) AS ciudad_residencia, ue.direccion,
            ue.barrio, ue.fechanacimiento, eps.nombre AS nombre_eps, IF(eps.nombre="Otra",ue.otra_eps,"No aplica") AS otra_eps, etnias.nombre AS etnia,
            IF(ue.grado_discapacidad=1,"Si","No") AS grado_discapacidad, IF(ue.grado_discapacidad=1,ue.descripcion_grado_discapacidad,"No aplica") AS descripcion_grado_discapacidad,
            IF(ue.mujerCabezaFamilia=1,"Si","No") AS mujerCabezaFamilia, IF(ue.desplazadoPorViolencia=1,"Si","No") AS desplazadoPorViolencia, ue.institucion,
            ue.titulo_obtenido, ue.fecha_terminacion
        ')
        ->selectRaw(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(ue.informacion_user,  '$.talento.tipo_talento')) as tipo_talento"))
        ->selectRaw(DB::raw(
            "CASE
                WHEN JSON_CONTAINS(ue.informacion_user, '\"Aprendiz SENA con apoyo de sostenimiento\"',  '$.talento.tipo_talento') THEN CONCAT(JSON_UNQUOTE(JSON_EXTRACT(ue.informacion_user,  '$.talento.regional')), ', ', JSON_UNQUOTE(JSON_EXTRACT(ue.informacion_user,  '$.talento.centro_formacion')), ', ', JSON_UNQUOTE(JSON_EXTRACT(ue.informacion_user,  '$.talento.programa_formacion')))
                WHEN JSON_CONTAINS(ue.informacion_user, '\"Aprendiz SENA sin apoyo de sostenimiento\"',  '$.talento.tipo_talento') THEN CONCAT(JSON_UNQUOTE(JSON_EXTRACT(ue.informacion_user,  '$.talento.regional')), ', ', JSON_UNQUOTE(JSON_EXTRACT(ue.informacion_user,  '$.talento.centro_formacion')), ', ', JSON_UNQUOTE(JSON_EXTRACT(ue.informacion_user,  '$.talento.programa_formacion')))
                WHEN JSON_CONTAINS(ue.informacion_user, '\"Egresado SENA\"',  '$.talento.tipo_talento') THEN CONCAT(JSON_UNQUOTE(JSON_EXTRACT(ue.informacion_user,  '$.talento.regional')), ', ', JSON_UNQUOTE(JSON_EXTRACT(ue.informacion_user,  '$.talento.centro_formacion')), ', ', JSON_UNQUOTE(JSON_EXTRACT(ue.informacion_user,  '$.talento.programa_formacion')), ', ', JSON_UNQUOTE(JSON_EXTRACT(ue.informacion_user,  '$.talento.tipo_formacion')))
                WHEN JSON_CONTAINS(ue.informacion_user, '\"Estudiante Universitario\"',  '$.talento.tipo_talento') THEN CONCAT(JSON_UNQUOTE(JSON_EXTRACT(ue.informacion_user,  '$.talento.tipo_estudio')), ', ', JSON_UNQUOTE(JSON_EXTRACT(ue.informacion_user,  '$.talento.universidad')), ', ', JSON_UNQUOTE(JSON_EXTRACT(ue.informacion_user,  '$.talento.carrera')))
                WHEN JSON_CONTAINS(ue.informacion_user, '\"Funcionario de empresa\"',  '$.talento.tipo_talento') THEN JSON_UNQUOTE(JSON_EXTRACT(ue.informacion_user,  '$.talento.empresa'))
                WHEN JSON_CONTAINS(ue.informacion_user, '\"Funcionario SENA\"',  '$.talento.tipo_talento') THEN CONCAT(JSON_UNQUOTE(JSON_EXTRACT(ue.informacion_user,  '$.talento.regional')), ', ', JSON_UNQUOTE(JSON_EXTRACT(ue.informacion_user,  '$.talento.centro_formacion')), ', ', JSON_UNQUOTE(JSON_EXTRACT(ue.informacion_user,  '$.talento.dependencia')))
                WHEN JSON_CONTAINS(ue.informacion_user, '\"Instrutor SENA\"',  '$.talento.tipo_talento') THEN CONCAT(JSON_UNQUOTE(JSON_EXTRACT(ue.informacion_user,  '$.talento.regional')), ', ', JSON_UNQUOTE(JSON_EXTRACT(ue.informacion_user,  '$.talento.centro_formacion')))
                WHEN JSON_CONTAINS(ue.informacion_user, '\"Propietario Empresa\"',  '$.talento.tipo_talento') THEN JSON_UNQUOTE(JSON_EXTRACT(ue.informacion_user,  '$.talento.empresa'))
                ELSE 'No aplica'
            END as detalle_talento"
    ))
        ->join('proyecto_talento', 'proyecto_talento.proyecto_id', '=', 'proyectos.id')
        ->join('users AS ue', 'ue.id', '=', 'proyecto_talento.user_id')
        ->leftjoin('gruposanguineos', 'gruposanguineos.id', '=', 'ue.gruposanguineo_id')
        ->leftjoin('ciudades AS cr', 'cr.id', '=', 'ue.ciudad_id')
        ->leftjoin('departamentos AS dr', 'dr.id', '=', 'cr.departamento_id')
        ->leftjoin('eps', 'eps.id', '=', 'ue.eps_id')
        ->leftjoin('etnias', 'etnias.id', '=', 'ue.etnia_id');
    }

    /**
     * Consulta los proyectos del talento
     *
     * @param int $id Id del usuario
     * @return Collection
     * @author dum
     */
    public function proyectosDelTalento($id)
    {
        return Proyecto::select('proyectos.id', 'sublineas.nombre as sublinea_nombre', 'codigo_proyecto', 'proyectos.nombre', 'fases.nombre AS nombre_fase')
        ->selectRaw('concat(codigo_idea, " - ", nombre_proyecto) AS nombre_idea')
        ->selectRaw('concat(users.nombres, " ", users.apellidos) AS gestor')
        ->join('nodos', 'nodos.id', '=', 'proyectos.nodo_id')
        ->join('ideas', 'ideas.id', '=', 'proyectos.idea_id')
        ->join('fases', 'fases.id', '=', 'proyectos.fase_id')
        ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
        ->join('proyecto_talento', 'proyecto_talento.proyecto_id', '=', 'proyectos.id')
        // ->join('talentos', 'talentos.id', '=', 'proyecto_talento.talento_id')
        ->join('users AS user_talento', 'user_talento.id', '=', 'proyecto_talento.user_id')
        ->join('users', 'users.id', '=', 'proyectos.experto_id')
        ->where('user_talento.id', $id);
    }

    /**
     * Método que retorna los talentos en un array, para usarlo junto a la funcion sync de laravel
     * @param \Illuminate\Http\Request  $request
     * @return array
     * @author dum
     */
    private function arraySyncTalentosDeUnProyecto($request)
    {
        $syncData = array();
        foreach ($request->get('talentos') as $id => $value) {
        if ($value == request()->get('radioTalentoLider')) {
            $syncData[$id] = array('talento_lider' => 1, 'user_id' => $value);
        } else {
            $syncData[$id] = array('talento_lider' => 0, 'user_id' => $value);
        }
        }
        return $syncData;
    }

    /**
     * Método el cuál actualiza ALGUNOS campos de la tabla de proyecto
     *
     * @param Request request Request con los datos del formulario
     * @param int id - Id del proyecto que se va a modificar
     * @return boolean
     * @author dum
     */
    public function update($request, $id)
    {
        $proyecto = Proyecto::find($id);

        DB::beginTransaction();
        try {
            $proyecto = Proyecto::find($id);

            $trl_esperado = 1;
            $reci_ar_emp = 1;
            $economia_naranja = 1;
            $dirigido_discapacitados = 1;
            $art_cti = 1;
            $fabrica_productividad = 1;

            if (!isset(request()->trl_esperado)) {
                $trl_esperado = 0;
            }

            if (!isset(request()->txtreci_ar_emp)) {
                $reci_ar_emp = 0;
            }

            if (!isset(request()->txteconomia_naranja)) {
                $economia_naranja = 0;
            }

            if (!isset(request()->txtdirigido_discapacitados)) {
                $dirigido_discapacitados = 0;
            }

            if (!isset(request()->txtarti_cti)) {
                $art_cti = 0;
            }

            if (!isset(request()->txtfabrica_productividad)) {
                $fabrica_productividad = 0;
            }

            $proyecto->update([
                'nombre' => request()->txtnombre,
                'objetivo_general' => request()->txtobjetivo,
                'areaconocimiento_id' => request()->txtareaconocimiento_id,
                'otro_areaconocimiento' => request()->txtotro_areaconocimiento,
                'sublinea_id' => request()->txtsublinea_id,
                'trl_esperado' => $trl_esperado,
                'reci_ar_emp' => $reci_ar_emp,
                'economia_naranja' => $economia_naranja,
                'tipo_economianaranja' => request()->txttipo_economianaranja,
                'dirigido_discapacitados' => $dirigido_discapacitados,
                'tipo_discapacitados' => request()->txttipo_discapacitados,
                'art_cti' => $art_cti,
                'nom_act_cti' => request()->txtnom_act_cti,
                'alcance_proyecto' => request()->txtalcance_proyecto,
                'fabrica_productividad' => $fabrica_productividad
            ]);


            $syncData = array();
            $syncData = $this->arraySyncTalentosDeUnProyecto($request);
            $proyecto->talentos()->sync($syncData, true);

            Proyecto::habilitarTalentos($proyecto);

            $proyecto->objetivos_especificos->get(0)->update([
                'objetivo' => request()->txtobjetivo_especifico1
            ]);

            $proyecto->objetivos_especificos->get(1)->update([
                'objetivo' => request()->txtobjetivo_especifico2
            ]);

            $proyecto->objetivos_especificos->get(2)->update([
                'objetivo' => request()->txtobjetivo_especifico3
            ]);

            $proyecto->objetivos_especificos->get(3)->update([
                'objetivo' => request()->txtobjetivo_especifico4
            ]);

            $proyecto->users_propietarios()->detach();
            $proyecto->sedes()->detach();
            $proyecto->gruposinvestigacion()->detach();

            $proyecto->users_propietarios()->attach(request()->propietarios_user);
            $proyecto->sedes()->attach(request()->propietarios_sedes);
            $proyecto->gruposinvestigacion()->attach(request()->propietarios_grupos);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    /**
     * Modifica los datos de cierre de un proyecto
     *
     * @param Request $request
     * @param int $id Id del proyecto
     * @return boolean
     * @author dum
     */
    public function updateCierreProyectoRepository($request, $id)
    {
        DB::beginTransaction();
        try {
            $objetivo1_alcanzado = 1;
            $objetivo2_alcanzado = 1;
            $objetivo3_alcanzado = 1;
            $objetivo4_alcanzado = 1;
            $proyecto = Proyecto::findOrFail($id);

            if (!isset($request->txtobjetivo1_alcanzado)) {
                $objetivo1_alcanzado = 0;
            }

            if (!isset($request->txtobjetivo2_alcanzado)) {
                $objetivo2_alcanzado = 0;
            }

            if (!isset($request->txtobjetivo3_alcanzado)) {
                $objetivo3_alcanzado = 0;
            }

            if (!isset($request->txtobjetivo4_alcanzado)) {
                $objetivo4_alcanzado = 0;
            }

            $proyecto->update([
                'trl_obtenido' => $request->trl_obtenido,
                'diri_ar_emp' => $request->txtdiri_ar_emp,
                'trl_prototipo' => $request->txttrl_prototipo,
                'trl_pruebas' => $request->txttrl_pruebas,
                'trl_modelo' => $request->txttrl_modelo,
                'trl_normatividad' => $request->txttrl_normatividad,
                'conclusiones' => $request->txtconclusiones
            ]);

            $proyecto->objetivos_especificos->get(0)->update([
                'cumplido' => $objetivo1_alcanzado
            ]);

            $proyecto->objetivos_especificos->get(1)->update([
                'cumplido' => $objetivo2_alcanzado
            ]);

            $proyecto->objetivos_especificos->get(2)->update([
                'cumplido' => $objetivo3_alcanzado
            ]);

            $proyecto->objetivos_especificos->get(3)->update([
                'cumplido' => $objetivo4_alcanzado
            ]);


            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }

    /**
     * Cambia el gestor de un proyecto
     *
     * @param Request $request
     * @param int $id id del proyecto
     * @return boolean
     * @author dum
     **/
    public function updateGestor($request, $id)
    {
        DB::beginTransaction();
        try {
        $proyecto = Proyecto::findOrFail($id);

        if ($proyecto->asesor_id != $request->txtgestor_id) {
            $proyecto->movimientos()->attach(Movimiento::where('movimiento', 'Cambió')->first(), [
            'proyecto_id' => $proyecto->id,
            'user_id' => auth()->user()->id,
            'fase_id' => $proyecto->fase_id,
            'role_id' => Role::where('name', session()->get('login_role'))->first()->id
            ]);
        }


        $proyecto->update([
            'experto_id' => $request->txtgestor_id
        ]);

        DB::commit();
        return true;
        } catch (\Throwable $th) {
        DB::rollBack();
        return false;
        }
    }

    /**
     * Reversa la fase de un proyecto
     *
     * @param Proyecto $proyecto Proyecto
     * @param string $fase Fase a la que se reversa el proyecto
     * @return boolean
     * @author dum
     **/
    public function reversarProyecto(Proyecto $proyecto, string $fase)
    {
        DB::beginTransaction();
        try {
            $proyecto->movimientos()->attach(Movimiento::where('movimiento', 'Reversó')->first(), [
                'proyecto_id' => $proyecto->id,
                'user_id' => auth()->user()->id,
                'fase_id' => $proyecto->fase_id,
                'role_id' => Role::where('name', session()->get('login_role'))->first()->id,
                'comentarios' => $fase
            ]);

            $proyecto->update([
                'fase_id' => Fase::where('nombre', $fase)->first()->id
            ]);

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Modifica los entregables de un proyecto
     * @param Request $request
     * @param int $id Id del proyecto
     * @return boolean
     * @author dum
     */
    public function updateEntregablesInicioProyectoRepository($request, $id)
    {
        DB::beginTransaction();
        try {
            $acc = 1;
            $manual_uso_inf = 1;
            $doc_titular = 1;
            $formulario_inicio = 1;

            if (!isset($request->txtacc)) {
                $acc = 0;
            }

            if (!isset($request->txtmanual_uso_inf)) {
                $manual_uso_inf = 0;
            }

            if (!isset($request->txtdoc_titular)) {
                $doc_titular = 0;
            }

            if (!isset($request->txtformulario_inicio)) {
                $formulario_inicio = 0;
            }

            $proyecto = Proyecto::find($id);

            /**
             * Modifica los datos de la tabla proyectos
             */
            $proyecto->update([
                'acc' => $acc,
                'manual_uso_inf' => $manual_uso_inf,
                'doc_titular' => $doc_titular,
                'formulario_inicio' => $formulario_inicio
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    /**
     * Envia notificación y correo cuando el dinamizador no aprueba una fase del proyecto.
     *
     * @param Request $request
     * @param int $id Id del proyecto
     * @param string $fase Fase que no se está aprobando
     * @return boolean
     * @author dum
     **/
    public function noAprobarFaseProyecto($request, int $id, string $fase)
    {
        DB::beginTransaction();
        try {
            $proyecto = Proyecto::findOrFail($id);
            $proyecto->movimientos()->attach(Movimiento::where('movimiento', 'no aprobó')->first(), [
            'actividad_id' => $proyecto->id,
                'user_id' => auth()->user()->id,
                'fase_id' => Fase::where('nombre', $fase)->first()->id,
                'role_id' => Role::where('name', session()->get('login_role'))->first()->id,
                'comentarios' => $request->motivosNoAprueba
            ]);

            $movimiento = Proyecto::consultarHistoricoProyecto($proyecto->id)->get()->last();
            event(new ProyectoWasntApproved($proyecto, $movimiento));
            Notification::send($proyecto->asesor, new ProyectoNoAprobarFase($proyecto, $movimiento));
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Retornar los emails de los destinatarios en un array
     *
     * @param $users
     * @return array
     * @throws conditon
     **/
    private function returnEmailDestinatariosArray($users)
    {
        $array = array();
        foreach ($users as $id => $user) {
            $array[$id] = array('email' => $user->email);
        }
        return $array;
    }

    /**
     * Aprueba la fase según el rol y fase que se está aprobando
     *
     * @param $request
     * @param $id Id del proyecto
     * @param $fase Fase que se está aprobando
     */
    public function aprobacionFaseInicio($request, $id)
    {
        DB::beginTransaction();
        try {
            $comentario = null;
            $movimiento = null;
            $mensaje = null;
            $title = null;
            $ruta = route('proyecto');
            $destinatarios = array();

            $proyecto = Proyecto::findOrFail($id);
            $dinamizadores = User::ConsultarFuncionarios($proyecto->nodo_id, User::IsDinamizador())->get();
            $destinatarios = $this->returnEmailDestinatariosArray($dinamizadores);
            array_push($destinatarios, ['email' => $proyecto->asesor->email]);
            // $talento_lider = $proyecto->talentos()->wherePivot('talento_lider', 1)->first();
            // $talento_lider = $talento_lider->user;
            $notificacion_act = ControlNotificaciones::find($request->control_notificacion_id);
            if ($notificacion_act->estado != $notificacion_act->IsPendiente()) {
                return [
                    'state' => false,
                    'mensaje' => 'Esta aprobación ya ha sido gestionada.',
                    'title' => 'Aprobación errónea'
                ];
            } else {
                if ($request->decision == 'rechazado') {
                    $title = 'Aprobación rechazada!';
                    $mensaje = 'Se le han notificado al experto los motivos por los cuales no se aprueba el cambio de fase del proyecto';
                    $comentario = $request->motivosNoAprueba;
                    $movimiento = Movimiento::IsNoAprobar();

                    $this->crearMovimiento($proyecto, $proyecto->fase->nombre, $movimiento, $comentario);
                    // Recuperar el útlimo registro de movimientos ya que el método attach no retorna nada
                    $regMovimiento = Proyecto::consultarHistoricoProyecto($proyecto->id)->get()->last();
                    // Envio de un correo informando porque no se aprobó el cambio de fase
                    event(new ProyectoWasntApproved($proyecto, $regMovimiento));

                    Notification::send($proyecto->asesor, new ProyectoNoAprobarFase($proyecto, $regMovimiento));
                    $notificacion_act->update(['estado' => $notificacion_act->IsRechazado()]);

                } else {
                    $title = 'Aprobación Exitosa!';
                    $mensaje = 'Se ha aprobado la fase de ' . $proyecto->fase->nombre . ' de este proyecto';
                    $movimiento = Movimiento::IsAprobar();

                    $this->crearMovimiento($proyecto, $proyecto->fase->nombre, $movimiento, $comentario);
                    $regMovimiento = Proyecto::consultarHistoricoProyecto($proyecto->id)->get()->last();
                    $notificacion_act->update(['fecha_aceptacion' => Carbon::now(), 'estado' => $notificacion_act->IsAceptado()]);

                    event(new ProyectoWasApproved($proyecto, $regMovimiento, $destinatarios));
                    if (Session::get('login_role') == User::IsTalento()) {
                        $notificacion = $proyecto->registerNotifyProject($dinamizadores->last()->id, User::IsDinamizador());
                        // event(new ProyectoApproveWasRequested($notificacion, $destinatarios));
                        Notification::send($dinamizadores, new ProyectoAprobarFase($notificacion));
                    } else {
                        if ($proyecto->fase->nombre == "Inicio") {
                        // Cambiar el proyecto de fase
                        $proyecto->update([
                            'fase_id' => Fase::where('nombre', 'Planeación')->first()->id
                        ]);
                        }
                        if ($proyecto->fase->nombre == "Planeación") {
                        // Cambiar el proyecto de fase
                        $proyecto->update([
                            'fase_id' => Fase::where('nombre', 'Ejecución')->first()->id
                        ]);
                        }
                        if ($proyecto->fase->nombre == "Ejecución") {
                        // Cambiar el proyecto de fase
                        $proyecto->update([
                            'fase_id' => Fase::where('nombre', 'Cierre')->first()->id
                        ]);
                        }
                        if ($proyecto->fase->nombre == "Cierre") {
                        // Cambiar el proyecto de fase y asignar le fecha actual como fecha de cierre
                        $proyecto->update([
                            'fase_id' => Fase::where('nombre', 'Finalizado')->first()->id,
                            'fecha_cierre' => Carbon::now()
                        ]);
                        // Crear el movimiento con el cierre del proyecto
                        $this->crearMovimiento($proyecto, 'Finalizado', 'Cerró', null);
                        // $ruta = route('proyecto.detalle', $id);
                        }
                    }
                }
            }

            DB::commit();
            return [
                'state' => true,
                'mensaje' => $mensaje,
                'title' => $title,
                'route' => $ruta
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            return [
                'state' => false,
                'mensaje' => $th->getMessage(),
                'title' => 'Aprobación errónea'
            ];
        }
    }

    /**
     * Modifica los entregables de la fase de planeación de un proyecto
     * @param int $id Id del proyecto
     * @author dum
     * @return boolean
     * @author dum
     */
    public function updateEntregablesPlaneacionProyectoRepository($request, $id)
    {
        DB::beginTransaction();
        try {
            $cronograma = 1;
            $estado_arte = 1;

            if (!isset($request->txtcronograma)) {
                $cronograma = 0;
            }

            if (!isset($request->txtestado_arte)) {
                $estado_arte = 0;
            }

            $proyecto = Proyecto::findOrFail($id);
            $proyecto->update([
                'estado_arte' => $estado_arte,
                'cronograma' => $cronograma
            ]);

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }

    /**
     * Modifica los entregables de la fase de cierre
     *
     * @param Request $request
     * @param int $id Id del proyecto
     * @return boolean
     * @author dum
     */
    public function updateEntregableCierreProyectoRepository($request, $id)
    {
        DB::beginTransaction();
        try {
            $evidencia_trl = 1;
            $formulario_final = 1;
            $proyecto = Proyecto::findOrFail($id);

            if (!isset($request->txtevidencia_trl)) {
                $evidencia_trl = 0;
            }

            if (!isset($request->txtformulario_final)) {
                $formulario_final = 0;
            }
            $proyecto->update([
                'evidencia_trl' => $evidencia_trl,
                'formulario_final' => $formulario_final
            ]);

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }

    private function crearMovimiento($proyecto, $fase, $movimiento, $comentario)
    {
        $proyecto->movimientos()->attach(Movimiento::where('movimiento', $movimiento)->first(), [
        'proyecto_id' => $proyecto->id,
        'user_id' => auth()->user()->id,
        'fase_id' => Fase::where('nombre', $fase)->first()->id,
        'role_id' => Role::where('name', Session::get('login_role'))->first()->id,
        'comentarios' => $comentario
        ]);
    }

    public function verificarDestinatarioNotificacion($notificacion)
    {
        $rol = null;
        if ($notificacion == null) {
            $rol = User::IsTalento();
        } else {
            if ($notificacion->rol_receptor->name == User::IsTalento()) {
                $rol = User::IsTalento();
            } else {
                $rol = User::IsDinamizador();
            }
        }
        return $rol;
    }

    /**
     * Notifica al dinamizador para que apruebe el proyecto en la fase de inicio
     *
     * @param Proyecto $proyecto Proyecto
     * @return array
     * @author dum
     */
    public function notificarAprobacionDeFase(Proyecto $proyecto, string $fase = null)
    {
        DB::beginTransaction();
        try {
            $notificacion_fase_actual = $this->retornarUltimaNotificacionPendiente($proyecto);
            $msg = 'No se ha podido enviar la solicitud de aprobación, inténtalo nuevamente';
            $conf_envios = false;
            if ($fase == $proyecto->IsSuspendido()) {
                $conf_envios = $this->configuracionNotificacionDinamizador($proyecto);
                $msg = 'Se le ha enviado una notificación al dinamizador para que apruebe la cancelación del proyecto!';
                $notificacion = $proyecto->registerNotifyProject($conf_envios['receptor'], $conf_envios['receptor_role'], $fase);
            } else {
                if ($notificacion_fase_actual == null) {
                    $conf_envios = $this->configuracionNotificacionTalento($proyecto);
                    $msg = 'Se le ha enviado una notificación al talento interlocutor para que apruebe la fase de ' . $proyecto->fase->nombre . ' del proyecto!';
                } else {
                    if ($notificacion_fase_actual->rol_receptor->name == User::IsTalento()) {
                        $conf_envios = $this->configuracionNotificacionTalento($proyecto);
                        $msg = 'Se le ha enviado una notificación al talento interlocutor para que apruebe la fase de ' . $proyecto->fase->nombre . ' del proyecto!';
                    } else {
                        $conf_envios = $this->configuracionNotificacionDinamizador($proyecto);
                        $msg = 'Se le ha enviado una notificación al dinamizador para que apruebe la fase de ' . $proyecto->fase->nombre . ' del proyecto!';
                    }
                }
                // Registra el control de la notificación
                $notificacion = $proyecto->registerNotifyProject($conf_envios['receptor'], $conf_envios['receptor_role']);
            }

            if ($conf_envios != false) {
                // Enviar notificación
                Notification::send($notificacion->receptor, new ProyectoAprobarFase($notificacion));
                // Enviar email
                event(new ProyectoApproveWasRequested($notificacion, $conf_envios['destinatarios']));
                // Registrar el historial
                $this->crearMovimiento($proyecto, $notificacion->fase->nombre, $conf_envios['tipo_movimiento'], null);
            }

            DB::commit();
            return [
                'notificacion' => true,
                'msg' => $msg,
                'notify' => $notificacion
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            return [
                'notificacion' => false,
                'msg' => 'Ha ocurrido un error ' . $th->getMessage()
            ];
        }
    }

    /**
     * Genera la información el talento al que se le enviarán las notificaciones de solicitud de aprobación de fase
     *
     * @param Proyecto $proyecto
     * @return array
     * @author dum
     */
    public function configuracionNotificacionTalento($proyecto)
    {
        $talento_lider = $proyecto->getLeadTalent();
        $destinatarios[] = $talento_lider->email;
        if (Session::get('login_role') != User::IsTalento())
            $destinatarios[] = auth()->user()->email;

        return [
            'receptor' => $talento_lider->id,
            'receptor_role' => User::IsTalento(),
            'tipo_movimiento' => Movimiento::IsSolicitarTalento(),
            'destinatarios' => $destinatarios
        ];
    }

    public function configuracionNotificacionDinamizador($proyecto)
    {

        if (Session::get('login_role') != User::IsTalento())
            $destinatarios[] = auth()->user()->email;
            $dinamizador = User::ConsultarFuncionarios($proyecto->nodo_id, User::IsDinamizador())->get()->last();
            $destinatarios[] = $dinamizador->email;
        return [
            'receptor' => $dinamizador->id,
            'receptor_role' => User::IsDinamizador(),
            'tipo_movimiento' => Movimiento::IsSolicitarDinamizador(),
            'destinatarios' => $destinatarios
        ];
    }

    /**
     * Notifica al dinamizador para que apruebe el proyecto en la fase de suspendido
     *
     * @param int $id Id del proyecto
     * @return boolean
     * @author dum
     */
    public function notificarAlDinamziador_Suspendido(int $id)
    {
        DB::beginTransaction();
        try {
            $proyecto = Proyecto::findOrFail($id);
            $dinamizadores = User::ConsultarFuncionarios($proyecto->nodo_id, User::IsDinamizador())->get();
            $destinatarios = $this->returnEmailDestinatariosArray($dinamizadores);
            Notification::send($dinamizadores, new ProyectoAprobarSuspendido($proyecto));
            $this->crearMovimiento($proyecto, 'Cancelado', 'solicitó al dinamizador', null);
            $movimiento = Proyecto::consultarHistoricoProyecto($proyecto->id)->get()->last();
            event(new ProyectoSuspenderWasRequested($proyecto, $movimiento, $destinatarios));
            DB::commit();
        return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Cambia el estado de aprobacion_dinamizador_suspender para que el gestor pueda suspender un proyecto
     * @param int $id
     * @return boolean
     * @author dum
     **/
    public function updateAprobacionSuspendido(int $id, $request)
    {
        DB::beginTransaction();
        try {
            $proyecto = Proyecto::findOrFail($id);
            $notificacion_act = ControlNotificaciones::find($request->control_notificacion_id);
            $notificacion_act->update(['fecha_aceptacion' => Carbon::now(), 'estado' => $notificacion_act->IsAceptado()]);
            $this->crearMovimiento($proyecto, $proyecto->IsSuspendido(), Movimiento::IsAprobar(), null);
            $proyecto->update([
                'fase_id' => Fase::where('nombre', $proyecto->IsSuspendido())->first()->id,
                'fecha_cierre' => Carbon::now()
            ]);
            Notification::send(User::findOrFail($proyecto->asesor->id), new ProyectoSuspendidoAprobado($proyecto));
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }

    /**
     * Modifica los entregables de un proyecto en la fase de ejecución
     *
     * @param Request $request
     * @param int $id Id de proyecto
     * @return boolean
     * @author dum
     */
    public function updateEntregablesEjecucionProyectoRepository($request, $id)
    {
        DB::beginTransaction();
        try {
            $proyecto = Proyecto::findOrFail($id);
            $seguimiento = 1;
            if (!isset($request->txtseguimiento)) {
                $seguimiento = 0;
            }
            $proyecto->update([
                'seguimiento' => $seguimiento
            ]);
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }

    /**
     * Consulta los proyectos que tiene un gestor por año
     * @param int $idgestor Id del gestor
     * @param string $anho Año por el que se filtra la consulta
     * @return Collection
     * @author dum
     */
    public function ConsultarProyectosPorAnho($anho)
    {
        return Proyecto::select(
            'codigo_proyecto',
            'proyectos.nombre',
            'areasconocimiento.nombre AS nombre_areaconocimiento',
            'sublineas.nombre AS sublinea_nombre',
            'lineastecnologicas.nombre AS nombre_linea',
            'fecha_inicio',
            'fecha_cierre',
            'economia_naranja',
            'fases.nombre AS nombre_fase',
            'proyectos.id',
            'proyectos.experto_id'
        )
        ->selectRaw('concat(users.documento, " - ", users.nombres, " ", users.apellidos) AS gestor')
        ->selectRaw('concat(ideas.codigo_idea, " - ", ideas.nombre_proyecto) as nombre_idea')
        ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
        ->join('users', 'users.id', '=', 'proyectos.experto_id')
        ->join('ideas', 'ideas.id', '=', 'proyectos.idea_id')
        ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
        ->join('areasconocimiento', 'areasconocimiento.id', '=', 'proyectos.areaconocimiento_id')
        ->leftJoin('fases', 'fases.id', '=', 'proyectos.fase_id')
        ->join('nodos', 'nodos.id', '=', 'proyectos.nodo_id')
        ->where(function ($q) use ($anho) {
            $q->where(function ($query) use ($anho) {
            $query->whereYear('fecha_cierre', '=', $anho)
                ->whereIn('fases.nombre', ['Finalizado', 'Cancelado']);
            })
            ->orWhere(function ($query) {
                $query->whereIn('fases.nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre']);
            });
        })
        ->groupBy('proyectos.id');
    }

    /**
     * Genera un código para le proyecto
     * @return string
     * @author dum
     */
    private function generarCodigoDeProyecto($experto)
    {

        $anho = Carbon::now()->isoFormat('YYYY');
        $tecnoparque = sprintf("%02d", $experto->experto->nodo_id);
        $linea = $experto->experto->linea_id;
        $gestor = sprintf("%03d", $experto->experto->id);
        $idProyecto = Proyecto::selectRaw('MAX(id+1) AS max')->get()->last();
        $idProyecto->max == null ? $idProyecto->max = 1 : $idProyecto->max = $idProyecto->max;
        $idProyecto->max = sprintf("%04d", $idProyecto->max);

        return 'P' . $anho . '-' . $tecnoparque . $linea . $gestor . '-' . $idProyecto->max;
    }

    /**
     * Registra un nuevo proyecto en la base de datos
     * @param Request $request Datos del formulario
     * @return boolean
     * @author dum
     */
    public function store($request)
    {
        DB::beginTransaction();
        try {
            if (isset(request()->txtexperto_id_proyecto)) {
                $experto = User::find(request()->txtexperto_id_proyecto);
            } else {
                $experto = User::find(auth()->user()->id);
            }
            $codigo_actividad = $this->generarCodigoDeProyecto($experto);

            $trl_esperado = 1;
            $reci_ar_emp = 1;
            $economia_naranja = 1;
            $dirigido_discapacitados = 1;
            $art_cti = 1;
            $fabrica_productividad = 1;

            $idea = Idea::find(request()->txtidea_id);
            $idea->update([
                'estadoidea_id' => EstadoIdea::where('nombre', EstadoIdea::IsPBT())->first()->id
            ]);

            if (!isset(request()->trl_esperado)) {
                $trl_esperado = 0;
            }

            if (!isset(request()->txtreci_ar_emp)) {
                $reci_ar_emp = 0;
            }

            if (!isset(request()->txteconomia_naranja)) {
                $economia_naranja = 0;
            }

            if (!isset(request()->txtdirigido_discapacitados)) {
                $dirigido_discapacitados = 0;
            }

            if (!isset(request()->txtarti_cti)) {
                $art_cti = 0;
            }

            if (!isset(request()->txtfabrica_productividad)) {
                $fabrica_productividad = 0;
            }

            $proyecto = Proyecto::create([
                'codigo_proyecto' => $codigo_actividad,
                'nombre' => request()->txtnombre,
                'fecha_inicio' => Carbon::now()->isoFormat('YYYY-MM-DD'),
                'objetivo_general' => request()->txtobjetivo,
                'experto_id' => $experto->id,
                'nodo_id' => $experto->experto->nodo_id,
                'fase_id' => Fase::where('nombre', 'Inicio')->first()->id,
                'idea_id' => request()->txtidea_id,
                'areaconocimiento_id' => request()->txtareaconocimiento_id,
                'otro_areaconocimiento' => request()->txtotro_areaconocimiento,
                'sublinea_id' => request()->txtsublinea_id,
                'trl_esperado' => $trl_esperado,
                'reci_ar_emp' => $reci_ar_emp,
                'economia_naranja' => $economia_naranja,
                'tipo_economianaranja' => request()->txttipo_economianaranja,
                'dirigido_discapacitados' => $dirigido_discapacitados,
                'tipo_discapacitados' => request()->txttipo_discapacitados,
                'art_cti' => $art_cti,
                'nom_act_cti' => request()->txtnom_act_cti,
                'alcance_proyecto' => request()->txtalcance_proyecto,
                'fabrica_productividad' => $fabrica_productividad
            ]);
            $syncData = array();
            $syncData = $this->arraySyncTalentosDeUnProyecto($request);
            $proyecto->talentos()->sync($syncData, false);

            Proyecto::habilitarTalentos($proyecto);

            $proyecto->objetivos_especificos()->create([
                'objetivo' => request()->txtobjetivo_especifico1
            ]);

            $proyecto->objetivos_especificos()->create([
                'objetivo' => request()->txtobjetivo_especifico2
            ]);

            $proyecto->objetivos_especificos()->create([
                'objetivo' => request()->txtobjetivo_especifico3
            ]);

            $proyecto->objetivos_especificos()->create([
                'objetivo' => request()->txtobjetivo_especifico4
            ]);

            $proyecto->users_propietarios()->attach(request()->propietarios_user);
            $proyecto->sedes()->attach(request()->propietarios_sedes);
            $proyecto->gruposinvestigacion()->attach(request()->propietarios_grupos);
            $proyecto->idea->registrarHistorialIdea(Movimiento::IsRegistrar(), Session::get('login_role'), null, 'como un PBT asociado con el código ' . $proyecto->codigo_proyecto);

            DB::commit();
            return ['state' => true, 'id' => $proyecto->id];
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'state' => false,
                'ex' => $e
            ];
        }
    }

    /**
     * Retonar la última notificacion pendiente para el proyecto
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function retornarUltimaNotificacionPendiente($proyecto)
    {
        return $proyecto->notificaciones()->where('fase_id',  $proyecto->fase_id)->where('estado', ControlNotificaciones::IsPendiente())->get()->last();
    }

    public function getProjectsForFaseById(array $relations, array $fase = [])
    {
        return Proyecto::with($relations)->whereHas(
        'fase',
            function ($query) use ($fase) {
                $query->whereIn('id', $fase);
            }
        );
    }
}
