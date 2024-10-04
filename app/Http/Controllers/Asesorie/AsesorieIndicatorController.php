<?php

namespace App\Http\Controllers\Asesorie;

use App\Http\Controllers\Controller;
use App\Repositories\Repository\{ProyectoRepository,  AsesorieRepository};
use App\Repositories\Repository\Articulation\ArticulationRepository;
use App\User;
use App\Models\UsoInfraestructura;
use App\Models\Fase;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Asesorie\AsesorieRequest;
use App\Models\{Proyecto, Articulation, Idea, Nodo};
use Illuminate\Support\Str;

class AsesorieIndicatorController extends Controller
{
    private $asesorieRepository;
    private $projectRepository;
    private $articulationRepository;
    private $lineRepository;
    private $bandera;
    private $nodo;

    public function __construct(AsesorieRepository $asesorieRepository, ProyectoRepository $projectRepository, ArticulationRepository $articulationRepository) {
        $this->asesorieRepository = $asesorieRepository;
        $this->projectRepository = $projectRepository;
        $this->articulationRepository = $articulationRepository;
        if (isset(request()->consultar_por)) {
            $this->bandera = request()->consultar_por == 'por_funcionario' ? false : true;
        } else {
            $this->bandera = true;
        }
        
        // dd($this->nodo);
    }

    /**
     * Index para mostrar los indicadores de las asesorias
     *
     * @return Response
     * @author dum
     **/
    public function showIndicadores()
    {
        $nodo = request()->user()->getNodoUser();
        $nodos = null;
        if (Str::contains(session()->get('login_role'), [User::IsAuxiliar(), User::IsActivador(), User::IsAdministrador()])) {
            $nodos = Nodo::SelectNodo()->get();
        }
        return view('asesorias.indicators', [
            'nodos' => $nodos,
            'expertos' => $this->getExpertosToIndicadoresAsesoria($nodo),
            'apoyos' => $this->getApoyosToIndicadoresAsesoria($nodo),
            'articuladores' => $this->getArticuladoresToIndicadoresAsesoria($nodo)
        ]);
    }

    private function getExpertosToIndicadoresAsesoria($nodo) {
        if (Str::contains(session()->get('login_role'), [User::IsExperto()])) {
            return User::SelectUserFuncionario()->FuncionarioJoin()->where('users.id', request()->user()->id)->get();
        } else {
            if (Str::contains(session()->get('login_role'), [User::IsDinamizador()])) {
                return User::ConsultarFuncionarios($nodo, User::IsExperto())->get();
            } else {
                return collect([]);
            }
        }
    }

    private function getApoyosToIndicadoresAsesoria($nodo) {
        if (Str::contains(session()->get('login_role'), [User::IsApoyoTecnico()])) {
            return User::SelectUserFuncionario()->FuncionarioJoin()->where('users.id', request()->user()->id)->get();
        } else {
            if (Str::contains(session()->get('login_role'), [User::IsDinamizador()])) {
                return User::ConsultarFuncionarios($nodo, User::IsApoyoTecnico())->get();
            } else {
                return collect([]);
            }
        }
    }

    private function getArticuladoresToIndicadoresAsesoria($nodo) {
        if (Str::contains(session()->get('login_role'), [User::IsArticulador()])) {
            return User::SelectUserFuncionario()->FuncionarioJoin()->where('users.id', request()->user()->id)->get();
        } else {
            if (Str::contains(session()->get('login_role'), [User::IsDinamizador()])) {
                return User::ConsultarFuncionarios($nodo, User::IsArticulador())->get();
            } else {
                return collect([]);
            }
        }
    }

    /**
     * Retorna los costos y horas de asesorias de un proyecto
     *
     * @param Request $request
     * @return json
     * @author dum
     **/
    public function getCostoProyecto(Request $request)
    {
        $this->setNodo($request);
        $parametros = $this->ordenarDatosFormulario($request);
        $asesorias = $this->getAsesorias($parametros['funcionario'], $parametros['desde'], $parametros['hasta'], $this->nodo)
        ->groupBy('asesores.id')
        ->orderBy('asesor')
        ->get();
        $equipos = $this->getEquipos($parametros['desde'], $parametros['hasta'], $this->nodo)
        ->groupBy('equipo_id')
        ->orderBy('lineastecnologicas.nombre')
        ->get();
        $materiales = $this->getMateriales($parametros['desde'], $parametros['hasta'], $this->nodo)
        ->groupBy('material_id')
        ->orderBy('lineastecnologicas.nombre')
        ->get();
        $totales = $this->getTotales($asesorias, $equipos, $materiales);
        return response()->json([
            'request' => $request->all(),
            'datos' => [
                'asesorias' => $asesorias,
                'equipos' => $this->bandera ? $equipos : null,
                'materiales' => $this->bandera ? $materiales : null
            ],
            'totales' => [
                'total_horas_asesoria' => $totales['total_horas_asesoria'],
                'total_costo_asesoria' => $totales['total_costo_asesoria'],
                'total_horas_uso_equipos' => $totales['total_horas_uso_equipos'],
                'total_costo_uso_equipos' => $totales['total_costo_uso_equipos'],
                'total_costo_materiales' => $totales['total_costo_materiales'],
                'total_costos' => $totales['total_costos']
            ]
        ]);
    }

    /**
     * Retorna los totales de los costos
     *
     * @param $asesorias Asesoria
     * @param $equipos Uso de equipos
     * @param $materiales Gasto de materiales
     * @return array
     * @author dum
     **/
    private function getTotales($asesorias, $equipos, $materiales)
    {
        $total_horas_asesoria = $asesorias->sum('horas_asesoria');
        $total_costo_asesoria = $asesorias->sum('costo_asesoria');
        $total_horas_uso_equipos = $this->bandera ? round($equipos->sum('tiempo_uso'), 2) : null;
        $total_costo_uso_equipos = $this->bandera ? round($equipos->sum('costo_uso_equipo'), 2) : null;
        $total_costo_materiales = $this->bandera ? $materiales->sum('costo_material') : null;
        $total_costos = round($total_costo_asesoria+$total_costo_uso_equipos+$total_costo_materiales, 2);
        return [
            'total_horas_asesoria' => $total_horas_asesoria,
            'total_costo_asesoria' => $total_costo_asesoria,
            'total_horas_uso_equipos' => $total_horas_uso_equipos,
            'total_costo_uso_equipos' => $total_costo_uso_equipos,
            'total_costo_materiales' => $total_costo_materiales,
            'total_costos' => $total_costos
        ];
    }


    /**
     * Retornar los datos para hacer los filtros
     *
     * @param Request $request
     * @return array
     * @author dum
     **/
    private function ordenarDatosFormulario($request)
    {
        return [
            'desde' => $request->txtasesorias_desde,
            'hasta' => $request->txtasesorias_hasta,
            'funcionario' => $request->consultar_por == 'por_funcionario' ? $request->slct_funcionario : null
        ];
    }

    /**
     * Filtra por fecha de proyecto o fecha de asesoria 
     *
     * @param $query
     * @param $desde
     * @param $hasta
     * @return Builder
     * @author dum
     **/
    private function filtrar_proyectos_finalizados($query, $desde, $hasta)
    {
        // dd(request()->consultar_por);
        if (request()->consultar_por == 'por_proyecto_finalizado') {
            $query = $query->whereBetween('proyectos.fecha_cierre', [$desde, $hasta])->whereIn('fases.nombre', [Proyecto::IsFinalizado()]);
        } else {
            $query = $query->BetweenDate($desde, $hasta);
        }
        return $query;
    }

    /**
     * Retorna las asesorias
     *
     * @param Request $request
     * @return Builder
     * @author dum
     **/
    public function getAsesorias($asesor = null, $desde, $hasta, $nodo = null)
    {
        $proyecto = Proyecto::class;
        $articulacion = Articulation::class;
        $idea = Idea::class;
        $query = $this->asesorieRepository->getListAsesoriesIndicators()
        ->select('asesores.id AS asesor_id', 'usoinfraestructuras.fecha', 'usoinfraestructuras.codigo', 'proyectos.codigo_proyecto', 'articulations.code AS codigo_articulacion', 'ideas.codigo_idea')
        ->selectRaw('CONCAT(asesores.nombres, " ", asesores.apellidos) AS asesor, SUM(asesoria_directa+asesoria_indirecta) AS horas_asesoria, ROUND(SUM(costo_asesoria), 2) AS costo_asesoria')
        ->leftJoin('proyectos', function($q) use ($proyecto) {$q->on('proyectos.id', '=', 'usoinfraestructuras.asesorable_id')->where('usoinfraestructuras.asesorable_type', "$proyecto");})
        ->leftJoin('fases', 'fases.id', '=', 'proyectos.fase_id')
        ->leftJoin('articulations', function($q) use ($articulacion) {$q->on('articulations.id', '=', 'usoinfraestructuras.asesorable_id')->where('usoinfraestructuras.asesorable_type', "$articulacion");})
        ->leftJoin('ideas', function($q) use ($idea) {$q->on('ideas.id', '=', 'usoinfraestructuras.asesorable_id')->where('usoinfraestructuras.asesorable_type', "$idea");})
        ->OnlyAsesor($asesor)
        ->OnlyNode($nodo, $this->bandera ? true : false);

        $query = $this->filtrar_proyectos_finalizados($query, $desde, $hasta);

        return $query;
    }

    /**
     * Retorna los equipos usados en las asesorias
     *
     * @param Request $request
     * @return Builder
     * @author dum
     **/
    public function getEquipos($desde, $hasta, $nodo = null)
    {
        $proyecto = Proyecto::class;
        $articulacion = Articulation::class;
        $idea = Idea::class;
        $query = $this->asesorieRepository->getListDevices()
        ->select('equipos.id AS equipo_id', 'usoinfraestructuras.fecha', 'usoinfraestructuras.codigo', 'proyectos.codigo_proyecto', 'articulations.code AS codigo_articulacion', 'ideas.codigo_idea')
        ->selectRaw('CONCAT(lineastecnologicas.nombre, " - ", equipos.nombre) AS equipo, ROUND(SUM(costo_equipo+costo_administrativo), 2) AS costo_uso_equipo, SUM(tiempo) AS tiempo_uso')
        ->leftJoin('proyectos', function($q) use ($proyecto) {$q->on('proyectos.id', '=', 'usoinfraestructuras.asesorable_id')->where('usoinfraestructuras.asesorable_type', "$proyecto");})
        ->leftJoin('fases', 'fases.id', '=', 'proyectos.fase_id')
        ->leftJoin('articulations', function($q) use ($articulacion) {$q->on('articulations.id', '=', 'usoinfraestructuras.asesorable_id')->where('usoinfraestructuras.asesorable_type', "$articulacion");})
        ->leftJoin('ideas', function($q) use ($idea) {$q->on('ideas.id', '=', 'usoinfraestructuras.asesorable_id')->where('usoinfraestructuras.asesorable_type', "$idea");})
        ->OnlyNode($nodo);
        $query = $this->filtrar_proyectos_finalizados($query, $desde, $hasta);

        return $query;

    }

    /**
     * Retorna los materiales usados en las asesorias
     *
     * @param boolean $bandera
     * @param string $desde
     * @param string $hasta
     * @param int $nodo
     * @return Builder
     * @author dum
     **/
    public function getMateriales($desde, $hasta, $nodo = null)
    {
        $proyecto = Proyecto::class;
        $articulacion = Articulation::class;
        $idea = Idea::class;
        $query = $this->asesorieRepository->getListMaterials()
        ->select('materiales.id AS material_id', 'medidas.nombre AS medida', 'usoinfraestructuras.fecha', 'usoinfraestructuras.codigo', 'proyectos.codigo_proyecto', 'articulations.code AS codigo_articulacion', 'ideas.codigo_idea')
        ->selectRaw('CONCAT(lineastecnologicas.nombre, " - ", materiales.nombre) AS material, ROUND(SUM(costo_material), 2) AS costo_material, SUM(unidad) AS unidad')
        ->leftJoin('proyectos', function($q) use ($proyecto) {$q->on('proyectos.id', '=', 'usoinfraestructuras.asesorable_id')->where('usoinfraestructuras.asesorable_type', "$proyecto");})
        ->leftJoin('fases', 'fases.id', '=', 'proyectos.fase_id')
        ->leftJoin('articulations', function($q) use ($articulacion) {$q->on('articulations.id', '=', 'usoinfraestructuras.asesorable_id')->where('usoinfraestructuras.asesorable_type', "$articulacion");})
        ->leftJoin('ideas', function($q) use ($idea) {$q->on('ideas.id', '=', 'usoinfraestructuras.asesorable_id')->where('usoinfraestructuras.asesorable_type', "$idea");})
        ->OnlyNode($nodo);
        $query = $this->filtrar_proyectos_finalizados($query, $desde, $hasta);
        
        return $query;
    }

    /**
     * Retorna la asesorias que hace un asesor
     *
     * @param $data
     * @return Response
     * @author dum
     **/
    public function getDetallesAsesoria(Request $request)
    {
        $asesorias = $this->getAsesorias($request->asesor_id, $request->desde, $request->hasta)
        ->groupBy('usoinfraestructuras.id')
        ->orderBy('codigo')
        ->get();
        return response()->json(['asesorias' => $asesorias]);
    }

    /**
     * Retorna la asesorias que hace un asesor
     *
     * @param $data
     * @return Response
     * @author dum
     **/
    public function getDetallesEquipo(Request $request)
    {
        $equipos = $this->getEquipos($request->desde, $request->hasta, $this->nodo)
        ->where('equipos.id', $request->equipo_id)
        ->groupBy('usoinfraestructuras.id')
        ->orderBy('codigo')
        ->get();
        // dd($equipos);
        return response()->json(['equipos' => $equipos]);
    }

    /**
     * Retorna la asesorias que hace un asesor
     *
     * @param $data
     * @return Response
     * @author dum
     **/
    public function getDetallesMaterial(Request $request)
    {
        $materiales = $this->getMateriales($request->desde, $request->hasta, $this->nodo)
        ->where('materiales.id', $request->material_id)
        ->groupBy('usoinfraestructuras.id')
        ->orderBy('codigo')
        ->get();
        return response()->json(['materiales' => $materiales]);
    }

    /**
     * Asigna un valor al nodo
     *
     * @param Request $request
     * @return void
     * @author dum
     **/
    private function setNodo(Request $request)
    {
        if ( isset($request->slct_nodo) ) {
            $this->nodo = $request->slct_nodo;
        } else {
            $this->nodo = request()->user()->getNodoUser();
        }
    }
}
