<?php

namespace App\Repositories\Repository;


use App\Models\{Proyecto, Entidad, Fase, ControlNotificaciones, Movimiento, Role, Idea, EstadoIdea, Sede, GrupoInvestigacion};
use Illuminate\Support\Facades\{DB, Notification, Storage, Session};
use App\Notifications\Proyecto\{ProyectoCierreAprobado, ProyectoAprobarFase, ProyectoAprobarSuspendido, ProyectoSuspendidoAprobado, ProyectoNoAprobarFase};
use Carbon\Carbon;
use App\Events\Proyecto\{ProyectoWasntApproved, ProyectoWasApproved, ProyectoApproveWasRequested, ProyectoSuspenderWasRequested};
use App\User;
use App\Repositories\Repository\UserRepository\DinamizadorRepository;
use Illuminate\Support\Arr;
use App\Repositories\Repository\Repository;

class ProyectoRepository extends Repository
{

    private $ideaRepository;

    public function __construct(IdeaRepository $ideaRepository)
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
     * Método que retorna el directorio de los archivos que tiene un proyecto en el servidor
     * @param int $id Id de la articulacion_proyecto
     * @return mixed
     * @author dum
     */
    // private function returnDirectoryProyectoFiles($id)
    // {
    //     // consulta los archivos de un proyecto (registro de la base de datos)
    //     $tempo = ArchivoArticulacionProyecto::where('articulacion_proyecto_id', $id)->first();

    //     if ($tempo == null) {
    //         return false;
    //     } else {
    //     // Función para dividir la cadena en un array (Partiendolos con el delimitador /)
    //     $route = preg_split("~/~", $tempo->ruta, 9);
    //     // Extrae el último elemento del array
    //     array_pop($route);
    //     // Une el array en un string, dicho string se separa por /
    //     $route = implode("/", $route);
    //     // Reemplaza storage por public en la routa
    //     $route = str_replace('storage', 'public', $route);
    //     return $route;
    //     }
    // }

    // public function horasAsesoriaPorExperto(int $id)
    // {
    //     $horas_exp = null;
    //     $proyecto = Proyecto::find($id);
    //     $asesorias = $proyecto->asesorias;
    //     foreach ($asesorias as $key => $asesoria) {
    //         echo $asesoria->usogestores->sum('pivot.asesoria_directa') . '<br>';
    //         // foreach ($asesoria->usogestores as $key => $horas) {
    //         //     $horas_exp[] = $horas->pivot->asesoria_directa;
    //         // }
    //         // echo $asesoria->usogestores->asesoria_indirecta . '<br>';
    //     }
    //     return $proyecto;
    // }

    // public function horasAsesoriaPorExperto($id)
    // {
    //     $proyecto = Proyecto::find($id);
    //     foreach ($proyecto->asesorias as $key => $asesoria) {
    //         foreach ($asesoria->usogestores as $key => $value) {
    //             echo $value->sum('pivot.asesoria_directa') . '<br>';

    //         }
    //     }
    //     exit;
    //     // dd($proyecto->asesorias->pivot);
    // }

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
                return $talentos_nuevos[$i]['talento_id'];
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
            'proyectos.asesor_id'
        )
        ->selectRaw('concat(users.documento, " - ", users.nombres, " ", users.apellidos) AS gestor')
        ->selectRaw('concat(ideas.codigo_idea, " - ", ideas.nombre_proyecto) as nombre_idea')
        ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
        ->join('gestores', 'gestores.id', '=', 'proyectos.asesor_id')
        ->join('users', 'users.id', '=', 'gestores.user_id')
        ->join('ideas', 'ideas.id', '=', 'proyectos.idea_id')
        ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
        ->join('areasconocimiento', 'areasconocimiento.id', '=', 'proyectos.areaconocimiento_id')
        ->leftJoin('fases', 'fases.id', '=', 'proyectos.fase_id')
        ->join('nodos', 'nodos.id', '=', 'proyectos.nodo_id');
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
        ->join('gestores AS g', 'g.id', '=', 'proyectos.asesor_id')
        ->join('nodos', 'nodos.id', '=', 'proyectos.nodo_id')
        ->join('fases', 'fases.id', '=', 'proyectos.fase_id')
        ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
        ->whereYear($field_date, $year)
        ->whereIn($field, $tipos_trl)
        ->where('fases.nombre', Proyecto::IsFinalizado())
        ->groupBy('nodos.id');
    }

    /**
     * Consulta cantidad de proyectos por fechas de cierre
     * @param string $fase Estado del proyecto que se quiere buscar
     * @param string $fecha_inicio Primera fecha oara realizar el filtro
     * @param string $fecha_fin Segunda fecha para realizar el filtro
     * @return Builder
     * @author dum
     */
    public function consultarProyectoCerradosEntreFecha(string $fase, string $fecha_inicio, string $fecha_fin)
    {
        return Proyecto::selectRaw('count(proyectos.id) as cantidad')
        ->join('gestores AS g', 'g.id', '=', 'proyectos.asesor_id')
        ->join('fases', 'fases.id', '=', 'proyectos.fase_id')
        ->join('nodos', 'nodos.id', '=', 'proyectos.nodo_id')
        ->where('fases.nombre', $fase)
        ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin]);
    }

    /**
     * Consulta cantidad de proyecto por fase
     * @param string $fase Fase que se va a filtrar
     * @return Builder
     * @author dum
     **/
    public function consultarProyectosFase()
    {
        return Proyecto::selectRaw('count(proyectos.id) as cantidad')
        ->join('gestores AS g', 'g.id', '=', 'proyectos.asesor_id')
        ->join('fases', 'fases.id', '=', 'proyectos.fase_id')
        ->join('nodos', 'nodos.id', '=', 'proyectos.nodo_id')
        ->whereIn('fases.nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre'])
        ->groupBy('fases.nombre');
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
        ->join('gestores AS g', 'g.id', '=', 'proyectos.asesor_id')
        ->join('fases', 'fases.id', '=', 'proyectos.fase_id')
        ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
        ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
        ->join('nodos', 'nodos.id', '=', 'proyectos.nodo_id')
        ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
        ->whereIn('fases.nombre', ['Finalizado', 'Suspendido'])
        ->groupBy('entidades.nombre', 'fase')
        ->whereYear('fecha_cierre', $year);
    }


    public function proyectosInscritosPorMes($year)
    {
        $this->traducirMeses();
        return Proyecto::selectRaw('MONTH(fecha_inicio) AS mes, COUNT(proyectos.id) AS cantidad, DATE_FORMAT(fecha_inicio, "%M") AS nombre_mes')
        ->join('gestores AS g', 'g.id', '=', 'proyectos.asesor_id')
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
        ->join('gestores AS g', 'g.id', '=', 'proyectos.asesor_id')
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
        return Proyecto::join('gestores AS g', 'g.id', '=', 'proyectos.asesor_id')
        ->join('nodos', 'nodos.id', '=', 'proyectos.nodo_id')
        ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
        ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
        ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
        ->join('fases', 'fases.id', '=', 'proyectos.fase_id')
        ->whereIn('fases.nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre']);
    }

    public function proyectosSeguimientoPorTrl()
    {
        return Proyecto::select('fases.nombre AS fase', 'entidades.nombre')
        ->selectRaw('count(trl_esperado) as trl_esperado')
        ->join('gestores AS g', 'g.id', '=', 'proyectos.asesor_id')
        ->join('nodos', 'nodos.id', '=', 'proyectos.nodo_id')
        ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
        ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
        ->join('fases', 'fases.id', '=', 'proyectos.fase_id')
        ->whereIn('fases.nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre']);
    }

    public function proyectosIndicadores_Repository(string $fecha_inicio, string $fecha_cierre)
    {
        return Proyecto::with([
            'users_propietarios',
            'gruposinvestigacion',
            'gruposinvestigacion.clasificacioncolciencias',
            'gruposinvestigacion.entidad',
            'sedes',
            'sedes.empresa',
            'sedes.empresa.tamanhoempresa',
            'sedes.empresa.tipoempresa',
            'sedes.empresa',
            'sublinea',
            'sublinea.linea',
            'areaconocimiento',
            'fase',
            'talentos',
            'talentos.user' => function($query) {
                $query->withTrashed();
            },
            'talentos.user.grupoSanguineo',
            'talentos.user.eps',
            'talentos.user.etnia',
            'talentos.user.gradoescolaridad',
            'talentos.user.ciudad',
            'talentos.user.ciudad.departamento',
            'asesor',
            'asesor.user'=> function($query) {
                $query->withTrashed();
            },
            'nodo',
            'nodo.entidad',
            'fase',
            'idea',
            ])->where(function($q) use ($fecha_inicio, $fecha_cierre) {
            $q->whereHas('articulacion_proyecto.actividad', function($query) use ($fecha_inicio, $fecha_cierre) {
                $query->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_cierre]);
            })
            ->orWhere(function($query) use ($fecha_inicio, $fecha_cierre) {
                $query->whereHas('articulacion_proyecto.actividad', function($query) use ($fecha_inicio, $fecha_cierre) {
                $query->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_cierre]);
                })
                ->orWhereHas('fase', function ($query) {
                $query->whereIn('fases.nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre']);
                });
            });
            });
    }

    public function asesoriasDeProyecto()
    {
        return Proyecto::with([
            'asesorias',
            'asesor',
            'asesor.user',
            'nodo',
            'nodo.entidad',
            'talentos',
            'talentos.user',
        ]);
    }

    public function proyectosIndicadoresSeparados_Repository()
    {
        $sede = Sede::class;
        $user = User::class;
        $grupo = GrupoInvestigacion::class;
        return Proyecto::select(
            'entidades.nombre AS nombre_nodo', 'lineastecnologicas.nombre AS nombre_linea', 'sublineas.nombre AS nombre_sublinea',
            'ideas.codigo_idea', 'ideas.nombre_proyecto AS nombre_idea', 'codigo_proyecto',
            'areasconocimiento.nombre AS nombre_area_conocimiento', 'otro_areaconocimiento', 'fecha_inicio',
            'fases.nombre AS nombre_fase', 'fecha_cierre', 'proyectos.id', 'proyectos.nombre AS nombre_proyecto'
        )
        ->selectRaw('concat(users.nombres, " ", users.apellidos) AS experto')
        ->selectRaw('IF(trl_esperado = '.Proyecto::IsTrl6Esperado().', "TRL 6", "TRL 7 - TRL 8") AS trl_esperado')
        ->selectRaw('IF(fases.nombre = "'.Proyecto::IsFinalizado().'", IF(trl_obtenido = 0, "TRL 6", IF(trl_obtenido = 1, "TRL 7", "TRL 8")), "El proyecto no se ha cerrado") AS trl_obtenido')
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
        ->selectRaw('GROUP_CONCAT(empresas.nit, " - ", empresas.nombre, ";") AS empresas')
        ->selectRaw('GROUP_CONCAT(up.nombres, " ",up.apellidos,";") AS personas')
        ->selectRaw('GROUP_CONCAT(gruposinvestigacion.codigo_grupo, " ", eg.nombre, ";") AS grupos')
        ->join('nodos', 'nodos.id', '=', 'proyectos.nodo_id')
        ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
        ->join('ideas', 'ideas.id', '=', 'proyectos.idea_id')
        ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
        ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
        ->join('areasconocimiento', 'areasconocimiento.id', '=', 'proyectos.areaconocimiento_id')
        ->join('fases', 'fases.id', '=', 'proyectos.fase_id')
        ->join('gestores', 'gestores.id', '=', 'proyectos.asesor_id')
        ->join('users', 'users.id', '=', 'gestores.user_id')
        ->join('propietarios', 'propietarios.proyecto_id', '=', 'proyectos.id')
        ->leftJoin('sedes', function($q) use ($sede) {$q->on('sedes.id', '=', 'propietarios.propietario_id')->where('propietarios.propietario_type', "$sede");})
        ->leftJoin('empresas', 'empresas.id', '=', 'sedes.empresa_id')
        ->leftJoin('users AS up', function($q) use ($user) {$q->on('up.id', '=', 'propietarios.propietario_id')->where('propietarios.propietario_type', "$user");})
        ->leftJoin('gruposinvestigacion', function($q) use ($grupo) {$q->on('gruposinvestigacion.id', '=', 'propietarios.propietario_id')->where('propietarios.propietario_type', "$grupo");})
        ->leftJoin('entidades AS eg', 'eg.id', '=', 'gruposinvestigacion.entidad_id')
        ->groupBy('proyectos.id')
        ->orderBy('entidades.nombre');
    }


    /**
     * Consulta la cantidad de proyectos que se finalizaron por mes de un nodo
     *
     * @param int $id Id del nodo
     * @return Collection
     * @author dum
     */
    public function proyectosFinalizadosPorMesDeUnNodo_Repository($id)
    {
        $this->traducirMeses();
        return Proyecto::selectRaw('count(proyectos.id) AS cantidad')
        ->selectRaw('MONTH(fecha_cierre) AS meses')
        ->selectRaw('CONCAT(UPPER(LEFT(date_format(fecha_cierre, "%M"), 1)), LOWER(SUBSTRING(date_format(fecha_cierre, "%M"), 2))) AS mes')
        ->join('nodos', 'nodos.id', '=', 'proyectos.nodo_id')
        ->where('nodos.id', $id)
        ->groupBy('meses', 'mes')
        ->orderBy('meses');
    }

    // /**
    //  * Consulta los proyectos
    //  * @param string $fecha_inicio
    //  * @param string $fecha_cierre
    //  * @return Builder
    //  * @author dum
    //  */
    // public function consultarProyectos_Repository(string $fecha_inicio = '', string $fecha_cierre = '')
    // {
    //     return Proyecto::select(
    //     'entidades.nombre AS nodo',
    //     'actividades.codigo_actividad',
    //     'actividades.nombre',
    //     'lineastecnologicas.nombre AS nombre_linea',
    //     'sublineas.nombre AS nombre_sublinea',
    //     'areasconocimiento.nombre AS nombre_areaconocimiento',
    //     'fecha_inicio',
    //     'fases.nombre AS nombre_fase'
    //     )
    //     ->selectRaw('GROUP_CONCAT(propietarios.propietario_type SEPARATOR ",") AS propietarios')
    //     ->selectRaw('concat(ideas.codigo_idea, " - ", ideas.nombre_proyecto) AS nombre_idea')
    //     ->selectRaw('concat(users.documento, " - ", users.nombres, " ", users.apellidos) AS gestor')
    //     ->selectRaw('IF(trl_esperado = '.Proyecto::IsTrl6Esperado().', "TRL 6", "TRL 7 - TRL 8") AS trl_esperado')
    //     ->selectRaw('IF(fases.nombre = "Finalizado", IF(trl_obtenido = 0, "TRL 6", IF(trl_obtenido = 1, "TRL 7", "TRL 8")), "El proyecto no se ha cerrado") AS trl_obtenido')
    //     ->selectRaw('IF(fases.nombre = "Finalizado" || fases.nombre = "Suspendido", fecha_cierre, "El proyecto no se ha cerrado") AS fecha_cierre')
    //     ->selectRaw('IF(areasconocimiento.nombre = "Otro", otro_areaconocimiento, "No aplica") AS otro_areaconocimiento')
    //     ->selectRaw('IF(fabrica_productividad = 0, "No", "Si") AS fabrica_productividad')
    //     ->selectRaw('IF(reci_ar_emp = 0, "No", "Si") AS reci_ar_emp')
    //     ->selectRaw('IF(economia_naranja = 0, "No", "Si") AS economia_naranja')
    //     ->selectRaw('IF(economia_naranja = 0, "No aplica", tipo_economianaranja) AS tipo_economianaranja')
    //     ->selectRaw('IF(dirigido_discapacitados = 0, "No", "Si") AS dirigido_discapacitados')
    //     ->selectRaw('IF(dirigido_discapacitados = 0, "No aplica", tipo_discapacitados) AS tipo_discapacitados')
    //     ->selectRaw('IF(art_cti = 0, "No", "Si") AS art_cti')
    //     ->selectRaw('IF(art_cti = 0, "No aplica", nom_act_cti) AS nom_act_cti')
    //     ->selectRaw('IF(fases.nombre = "Cierre", IF(diri_ar_emp = 0, "No", "Si"), "El proyecto no se ha cerrado") AS diri_ar_emp')
    //     ->selectRaw('DATE_FORMAT(fecha_cierre, "%Y") AS anho')
    //     ->selectRaw('DATE_FORMAT(fecha_cierre, "%m") AS mes')
    //     ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
    //     ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    //     ->join('nodos', 'nodos.id', '=', 'proyectos.nodo_id')
    //     ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
    //     ->join('ideas', 'ideas.id', '=', 'proyectos.idea_id')
    //     ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
    //     ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
    //     ->join('areasconocimiento', 'areasconocimiento.id', '=', 'proyectos.areaconocimiento_id')
    //     ->join('fases', 'fases.id', '=', 'proyectos.fase_id')
    //     ->join('gestores', 'gestores.id', '=', 'proyectos.asesor_id')
    //     ->join('users', 'users.id', '=', 'gestores.user_id')
    //     ->leftJoin('propietarios', 'propietarios.proyecto_id', '=', 'proyectos.id')
    //     ->where(function($q) use ($fecha_inicio, $fecha_cierre) {
    //         $q->where(function($query) use ($fecha_inicio, $fecha_cierre) {
    //         $query->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_cierre]);
    //         })
    //         ->orWhere(function($query) use ($fecha_inicio, $fecha_cierre) {
    //         $query->where(function($query) use ($fecha_inicio, $fecha_cierre) {
    //         $query->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_cierre]);
    //         $query->orWhere(function ($query) {
    //             $query->whereIn('fases.nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre']);
    //         });
    //         });
    //         });
    //     })
    //     ->groupBy('codigo_actividad', 'actividades.nombre')
    //     ->orderBy('entidades.nombre');
    // }

    /**
     * Consulta el talento líder de un proyecto
     * @param int $id Id del proyecto
     * @return Collection
     * @author dum
     */
    public function consultarTalentoLiderDeUnProyecto($id)
    {
        return Proyecto::select('users.documento', 'tiposdocumentos.nombre AS nombre_documento', 'fechanacimiento')
        ->selectRaw('concat(users.nombres, " ", users.apellidos) AS nombre_talento')
        ->selectRaw('concat(ciudades.nombre, " - ", departamentos.nombre) AS ciudad_expedicion')
        ->join('proyecto_talento', 'proyecto_talento.proyecto_id', '=', 'proyecto.id')
        ->join('talentos', 'talentos.id', '=', 'proyecto_talento.talento_id')
        ->join('users', 'users.id', '=', 'talentos.user_id')
        ->join('tiposdocumentos', 'tiposdocumentos.id', '=', 'users.tipodocumento_id')
        ->join('ciudades', 'ciudades.id', '=', 'users.ciudad_expedicion_id')
        ->join('departamentos', 'departamentos.id', '=', 'ciudades.departamento_id')
        ->where('proyectos.id', $id);
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
        return Proyecto::select('proyectos.id', 'sublineas.nombre as sublinea_nombre', 'actividades.codigo_actividad AS codigo_proyecto', 'actividades.nombre', 'fases.nombre AS nombre_fase', 'actividades.id AS actividad_id')
        ->selectRaw('concat(codigo_idea, " - ", nombre_proyecto) AS nombre_idea')
        ->selectRaw('concat(users.nombres, " ", users.apellidos) AS gestor')
        ->join('nodos', 'nodos.id', '=', 'proyectos.nodo_id')
        ->join('ideas', 'ideas.id', '=', 'proyectos.idea_id')
        ->join('gestores', 'gestores.id', '=', 'proyectos.asesor_id')
        ->join('users', 'users.id', '=', 'gestores.user_id')
        ->join('fases', 'fases.id', '=', 'proyectos.fase_id')
        ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
        ->join('proyecto_talento', 'proyecto_talento.proyecto_id', '=', 'proyecto.id')
        ->join('talentos', 'talentos.id', '=', 'proyecto_talento.talento_id')
        ->join('users AS user_talento', 'user_talento.id', '=', 'talentos.user_id')
        ->where('talentos.id', $id)
        ->get();
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
            $syncData[$id] = array('talento_lider' => 1, 'talento_id' => $value);
        } else {
            $syncData[$id] = array('talento_lider' => 0, 'talento_id' => $value);
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
            'asesor_id' => $request->txtgestor_id
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

    public function setPostCierreProyectoRepository(int $id)
    {
        DB::beginTransaction();
        try {
            $proyecto = Proyecto::findOrFail($id);

            $proyecto->movimientos()->attach(Movimiento::where('movimiento', 'Aprobó')->first(), [
                'actividad_id' => $proyecto->id,
                'user_id' => auth()->user()->id,
                'fase_id' => Fase::where('nombre', 'Ejecución')->first()->id,
                'role_id' => Role::where('name', session()->get('login_role'))->first()->id
            ]);

            DB::commit();
            return true;
        } catch (\Throwable $th) {
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
            $ruta = null;

            $proyecto = Proyecto::findOrFail($id);
            $dinamizadorRepository = new DinamizadorRepository;
            $dinamizadores = $dinamizadorRepository->getAllDinamizadoresPorNodo($proyecto->nodo_id)->get();
            $destinatarios = $dinamizadorRepository->getAllDinamizadorPorNodoArray($dinamizadores);
            array_push($destinatarios, ['email' => $proyecto->asesor->user->email]);
            $talento_lider = $proyecto->talentos()->wherePivot('talento_lider', 1)->first();
            $talento_lider = $talento_lider->user;
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

                    Notification::send($proyecto->asesor->user, new ProyectoNoAprobarFase($proyecto, $regMovimiento));
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
                        $ruta = route('proyecto.detalle', $id);
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
                $msg = 'Se le ha enviado una notificación al dinamizador para que apruebe la suspensión del proyecto!';
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
        $destinatarios[] = $talento_lider->user->email;
        if (Session::get('login_role') != User::IsTalento())
            $destinatarios[] = auth()->user()->email;

        return [
            'receptor' => $talento_lider->user->id,
            'receptor_role' => User::IsTalento(),
            'tipo_movimiento' => Movimiento::IsSolicitarTalento(),
            'destinatarios' => $destinatarios
        ];
    }

    public function configuracionNotificacionDinamizador($proyecto)
    {
        $dinamizadorRepository = new DinamizadorRepository;
        if (Session::get('login_role') != User::IsTalento())
            $destinatarios[] = auth()->user()->email;
        $dinamizador = $dinamizadorRepository->getAllDinamizadoresPorNodo($proyecto->nodo_id)->get()->last();
        $destinatarios[] = $dinamizador->email;
        return [
            'receptor' => $dinamizador->id,
            'receptor_role' => User::IsDinamizador(),
            'tipo_movimiento' => Movimiento::IsSolicitarDinamizador(),
            'destinatarios' => $destinatarios
        ];
    }

    /**
     * Consulta las notificaciones generadas para la fase actual de un proyecto
     */
    public function consultarNotificaciones($proyecto)
    {
        return $proyecto->with(['notificaciones', 'notificaciones.fase'])->whereHas(
        'notificaciones.fase',
            function ($query) use ($proyecto) {
                $query->where('nombre', $proyecto->fase->nombre);
            }
        );
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
            $dinamizadorRepository = new DinamizadorRepository;
            $proyecto = Proyecto::findOrFail($id);
            $dinamizadores = $dinamizadorRepository->getAllDinamizadoresPorNodo($proyecto->nodo_id)->get();
            $destinatarios = $dinamizadorRepository->getAllDinamizadorPorNodoArray($dinamizadores);
            Notification::send($dinamizadores, new ProyectoAprobarSuspendido($proyecto));
            $this->crearMovimiento($proyecto, 'Suspendido', 'solicitó al dinamizador', null);
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
     * Cambia el estado de aprobacion_dinamizador, para permitirle al gestor cerrar el proyecto
     */
    public function updateAprobacionDinamizador(int $id)
    {
        DB::beginTransaction();
        try {
        $proyecto = Proyecto::findOrFail($id);

        $proyecto->movimientos()->attach(Movimiento::where('movimiento', 'Aprobó')->first(), [
            'actividad_id' => $proyecto->id,
            'user_id' => auth()->user()->id,
            'fase_id' => Fase::where('nombre', 'Cierre')->first()->id,
            'role_id' => Role::where('name', session()->get('login_role'))->first()->id
        ]);

        Notification::send(User::find($proyecto->asesor->user->id), new ProyectoCierreAprobado($proyecto));
        DB::commit();
        return true;
        } catch (\Throwable $th) {
        DB::rollback();
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
            Notification::send(User::findOrFail($proyecto->asesor->user->id), new ProyectoSuspendidoAprobado($proyecto));
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
            'proyectos.asesor_id'
        )
        ->selectRaw('concat(users.documento, " - ", users.nombres, " ", users.apellidos) AS gestor')
        ->selectRaw('concat(ideas.codigo_idea, " - ", ideas.nombre_proyecto) as nombre_idea')
        ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
        ->join('gestores', 'gestores.id', '=', 'proyectos.asesor_id')
        ->join('users', 'users.id', '=', 'gestores.user_id')
        ->join('ideas', 'ideas.id', '=', 'proyectos.idea_id')
        ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
        ->join('areasconocimiento', 'areasconocimiento.id', '=', 'proyectos.areaconocimiento_id')
        ->leftJoin('fases', 'fases.id', '=', 'proyectos.fase_id')
        ->join('nodos', 'nodos.id', '=', 'proyectos.nodo_id')
        ->where(function ($q) use ($anho) {
            $q->where(function ($query) use ($anho) {
            $query->whereYear('fecha_cierre', '=', $anho)
                ->whereIn('fases.nombre', ['Finalizado', 'Suspendido']);
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
        $tecnoparque = sprintf("%02d", $experto->gestor->nodo_id);
        $linea = $experto->gestor->lineatecnologica_id;
        $gestor = sprintf("%03d", $experto->gestor->id);
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
            $entidad_id = Entidad::all()->where('nombre', 'No Aplica')->last()->id;

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
                'asesor_id' => $experto->gestor->id,
                'nodo_id' => $experto->gestor->nodo_id,
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
            return ['state' => false];
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

    /*========================================================================
    =            metodo para consultar los proyectos de un ususario gestor talento         =
    ========================================================================*/
    public function getProjectsForUser(array $relations, array $estado = [])
    {
        return Proyecto::estadoOfProjects($relations, $estado);
    }

    public function getProjectsActivesByUser(array $relations, array $fase = [])
    {
        return Proyecto::with($relations)->whereHas(
            'fase',
            function ($query) use ($fase) {
                $query->whereIn('nombre', $fase);
            }
        );
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
