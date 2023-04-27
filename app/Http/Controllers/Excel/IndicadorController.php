<?php

namespace App\Http\Controllers\Excel;

use App\Exports\Indicadores\{Indicadores2020Export, IndicadorArticulacionesExport};
use App\Exports\Metas\MetasExport;
use App\Exports\Idea\IdeasIndicadorExport;
use App\Repositories\Repository\{IdeaRepository, ProyectoRepository, Articulation\ArticulationRepository};
use Repositories\Repository\NodoRepository;
use App\Http\Controllers\Controller;
use App\User;
use App\Imports\MigracionMetasImport;
use Illuminate\Http\Request;
use App\Models\{Proyecto, Nodo};
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;

class IndicadorController extends Controller
{

    private $proyectoRepository;
    private $articulationRepostory;
    private $nodoRepository;
    private $ideaRepository;
    private $year_now;

    public function __construct(ProyectoRepository $proyectoRepository, ArticulationRepository $articulationRepostory, NodoRepository $nodoRepository, IdeaRepository $ideaRepository)
    {
        $this->setProyectoRepository($proyectoRepository);
        $this->articulationRepostory = $articulationRepostory;
        $this->nodoRepository = $nodoRepository;
        $this->ideaRepository = $ideaRepository;
        $this->year_now = Carbon::now()->format('Y');
    }

    /**
     * Genera excel con el detalle de los proyectos de tecnoparque
     * @param int $idnodo Id del nodo
     * @param string $fecha_inicio Primera fecha para relizar el filtro
     * @param string $fecha_fin Segunda fecha para realizar el filtro
     * @return Response
     * @author dum
     */
    public function exportIndicadores2020($idnodo, string $fecha_inicio, string $fecha_fin, string $hoja = null)
    {
        $query = null;

        if (session()->get('login_role') == User::IsActivador() || session()->get('login_role') == User::IsAdministrador()) {

        if ($idnodo == 'all') {
            $query = $this->getProyectoRepository()->proyectosIndicadores_Repository($fecha_inicio, $fecha_fin)->get();
        } else {
            $query = $this->getProyectoRepository()->proyectosIndicadores_Repository($fecha_inicio, $fecha_fin)->whereHas('nodo', function($query) use ($idnodo) {
            $query->where('id', $idnodo);
            })->get();
        }
        } else if (session()->get('login_role') == User::IsDinamizador()) {
            $query = $this->getProyectoRepository()->proyectosIndicadores_Repository($fecha_inicio, $fecha_fin)->whereHas('nodo', function($query) {
                $query->where('id', auth()->user()->dinamizador->nodo_id);
            })->get();
        } else if (session()->get('login_role') == User::IsInfocenter()) {
            $query = $this->getProyectoRepository()->proyectosIndicadores_Repository($fecha_inicio, $fecha_fin)->whereHas('nodo', function($query) {
                $query->where('id', auth()->user()->infocenter->nodo_id);
            })->get();
        } else {
            $query = $this->getProyectoRepository()->proyectosIndicadores_Repository($fecha_inicio, $fecha_fin)->whereHas('asesor', function($query) {
                $query->where('id', auth()->user()->gestor->id);
            })->get();

        }
        return Excel::download(new Indicadores2020Export($query, $hoja), 'Indicadores_'.$fecha_inicio.'_a_'.$fecha_fin.'.xlsx');
    }


    public function exportIndicadoresProyectosFinalizados($idnodo, string $fecha_inicio, string $fecha_fin, string $hoja = null)
    {
        $query = null;

        if (session()->get('login_role') == User::IsActivador() || session()->get('login_role') == User::IsAdministrador()) {

        if ($idnodo == 'all') {
            $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('articulacion_proyecto.actividad', function ($query) use ($fecha_inicio, $fecha_fin) {
            $query->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin]);
            })
            ->whereHas('fase', function ($query) {
            $query->whereIn('nombre', ['Finalizado', 'Concluido sin finalizar']);
            })->get();
        } else {
            $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('articulacion_proyecto.actividad', function ($query) use ($fecha_inicio, $fecha_fin) {
            $query->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin]);
            })
            ->whereHas('fase', function ($query) {
            $query->whereIn('nombre', ['Finalizado', 'Concluido sin finalizar']);
            })->whereHas('nodo', function($query) use ($idnodo) {
            $query->where('id', $idnodo);
            })->get();
        }
        } else if (session()->get('login_role') == User::IsDinamizador()) {
        $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('articulacion_proyecto.actividad', function ($query) use ($fecha_inicio, $fecha_fin) {
            $query->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin]);
        })
        ->whereHas('fase', function ($query) {
            $query->whereIn('nombre', ['Finalizado', 'Concluido sin finalizar']);
        })->whereHas('nodo', function($query) {
            $query->where('id', auth()->user()->dinamizador->nodo_id);
        })->get();
        } else if (session()->get('login_role') == User::IsInfocenter()) {
        $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('articulacion_proyecto.actividad', function ($query) use ($fecha_inicio, $fecha_fin) {
            $query->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin]);
        })
        ->whereHas('fase', function ($query) {
            $query->whereIn('nombre', ['Finalizado', 'Concluido sin finalizar']);
        })->whereHas('nodo', function($query) {
            $query->where('id', auth()->user()->infocenter->nodo_id);
        })->get();
        } else {
        $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('articulacion_proyecto.actividad', function ($query) use ($fecha_inicio, $fecha_fin) {
            $query->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin]);
        })
        ->whereHas('fase', function ($query) {
            $query->whereIn('nombre', ['Finalizado', 'Concluido sin finalizar']);
        })->whereHas('asesor', function($query) {
            $query->where('id', auth()->user()->gestor->id);
        })->get();
        }
        return Excel::download(new Indicadores2020Export($query, $hoja), 'Indicadores_Finalizados_'.$fecha_inicio.'_a_'.$fecha_fin.'.xlsx');
    }

    public function exportIndicadoresProyectosInscritos($idnodo, string $fecha_inicio, string $fecha_fin, string $hoja = null)
    {
        $query = null;

        if (session()->get('login_role') == User::IsActivador() || session()->get('login_role') == User::IsAdministrador()) {
        if ($idnodo == 'all') {
            $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('articulacion_proyecto.actividad', function ($query) use ($fecha_inicio, $fecha_fin) {
            $query->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin]);
            })->get();
        } else {
            $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('articulacion_proyecto.actividad', function ($query) use ($fecha_inicio, $fecha_fin) {
            $query->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin]);
            })->whereHas('nodo', function($query) use ($idnodo) {
            $query->where('id', $idnodo);
            })->get();
        }
        } else if (session()->get('login_role') == User::IsDinamizador()) {
        $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('articulacion_proyecto.actividad', function ($query) use ($fecha_inicio, $fecha_fin) {
            $query->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin]);
        })->whereHas('nodo', function($query) {
            $query->where('id', auth()->user()->dinamizador->nodo_id);
        })->get();
        } else if (session()->get('login_role') == User::IsInfocenter()) {
        $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('articulacion_proyecto.actividad', function ($query) use ($fecha_inicio, $fecha_fin) {
            $query->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin]);
        })->whereHas('nodo', function($query) {
            $query->where('id', auth()->user()->infocenter->nodo_id);
        })->get();
        } else {
        $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('articulacion_proyecto.actividad', function ($query) use ($fecha_inicio, $fecha_fin) {
            $query->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin]);
        })->whereHas('asesor', function($query) {
            $query->where('id', auth()->user()->gestor->id);
        })->get();
        }
        return Excel::download(new Indicadores2020Export($query, $hoja), 'Indicadores_Inscritos_'.$fecha_inicio.'_a_'.$fecha_fin.'.xlsx');
    }

    public function exportIndicadoresProyectosActuales($idnodo, string $hoja = null)
    {
        $query = null;

        if (session()->get('login_role') == User::IsActivador() || session()->get('login_role') == User::IsAdministrador()) {

        if ($idnodo == 'all') {
            $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('fase', function ($query) {
            $query->whereIn('nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre']);
            })->get();
        } else {
            $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('fase', function ($query) {
            $query->whereIn('nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre']);
            })->whereHas('nodo', function($query) use ($idnodo) {
            $query->where('id', $idnodo);
            })->get();
        }
        } else if (session()->get('login_role') == User::IsDinamizador()) {
        $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('fase', function ($query) {
            $query->whereIn('nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre']);
        })->whereHas('nodo', function($query) {
            $query->where('id', auth()->user()->dinamizador->nodo_id);
        })->get();
        } else if (session()->get('login_role') == User::IsInfocenter()) {
        $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('fase', function ($query) {
            $query->whereIn('nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre']);
        })->whereHas('nodo', function($query) {
            $query->where('id', auth()->user()->infocenter->nodo_id);
        })->get();
        } else {
        $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('fase', function ($query) {
            $query->whereIn('nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre']);
        })->whereHas('asesor', function($query) {
            $query->where('id', auth()->user()->gestor->id);
        })->get();
        }
        return Excel::download(new Indicadores2020Export($query, $hoja), 'Indicadores_Actuales.xlsx');
    }

    public function importIndicadoresAll(Request $request)
    {
        session()->put('errorMigracion', null);
        Excel::import(new MigracionMetasImport(), $request->file('nombreArchivo'));
        if (session()->get('errorMigracion') == null) {
            alert()->success('Migración Exitosa!', 'La información se ha migrado exitósamente!')->showConfirmButton('Ok', '#3085d6');
        } else {
            alert()->error('Migración Errónea!', session()->get('errorMigracion'))->showConfirmButton('Ok', '#3085d6');
        }
        session()->put('errorMigracion', null);
        return back();
    }

    public function downloadIdeas(Request $request)
    {
        if ($request->txtnodo_ideas_download[0] != 'all') {
            if (Str::contains(session()->get('login_role'), [User::IsActivador(), User::IsAdministrador()])) {
                $nodos = $request->txtnodo_ideas_download;
            } else {
                $nodos = [request()->user()->getNodoUser()];
            }
        } else {
            $nodos_temp = Nodo::SelectNodo()->get();
            foreach ($nodos_temp as $nodo) {
                $nodos[] = $nodo->id;
            }
        }
        $ideas = $this->ideaRepository->consultarIdeasDeProyecto()->whereHas('estadoIdea', function ($query) use ($request) {
            $query->where('nombre', $request->txtestado_idea_download);
        })->whereIn('nodo_id', $nodos)
        ->orderBy('nodo_id');
        if (session()->get('login_role') == User::IsExperto()) {
            $ideas = $ideas->where('ideas.gestor_id', request()->user()->gestor->id);
        }
        $ideas = $ideas->get();
        return Excel::download(new IdeasIndicadorExport($ideas), 'Ideas.xlsx');
    }

    public function downloadMetas(Request $request)
    {
        if ($request->txtnodo_metas_id[0] != 'all') {
            if (Str::contains(session()->get('login_role'), [User::IsActivador(), User::IsAdministrador()])) {
                $nodos = $request->txtnodo_metas_id;
            } else {
                $nodos = [request()->user()->getNodoUser()];
            }
        } else {
            $nodos_temp = Nodo::SelectNodo()->get();
            foreach ($nodos_temp as $nodo) {
                $nodos[] = $nodo->id;
            }
        }
        $metas = $this->nodoRepository->consultarMetasDeTecnoparque($nodos)->whereYear('anho', Carbon::now()->format('Y'))->get();
        $pbts_trl6 = $this->proyectoRepository->consultarTrl('trl_obtenido', 'fecha_cierre', $this->year_now, [Proyecto::IsTrl6Obtenido()])
        ->whereIn('nodos.id', $nodos)
        ->groupBy('mes')
        ->get();
        $pbts_trl7_8 = $this->proyectoRepository->consultarTrl('trl_obtenido', 'fecha_cierre', $this->year_now, [Proyecto::IsTrl7Obtenido(), Proyecto::IsTrl8Obtenido()])
        ->whereIn('nodos.id', $nodos)
        ->groupBy('mes')
        ->get();
        $activos = $this->proyectoRepository->proyectosIndicadoresSeparados_Repository()->select('nodo_id')->selectRaw('count(id) as cantidad')->whereHas('fase', function ($query) {
            $query->whereIn('nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre']);
        })->groupBy('nodo_id')->get();
        $metas = $this->retornarTodasLasMetasToExcel($metas, $pbts_trl6, $pbts_trl7_8, $activos);
        return Excel::download(new MetasExport($metas), 'Metas.xlsx');
    }

    private function pushValueToCollect($progreso_mes, $meta, $mes, $key) {
        if ($progreso_mes->count() == 0) {
            $valor = 0;
        } else {
            $valor = $progreso_mes->first()->cantidad;
        }
        $meta['progreso_total'] += $valor;
        $meta[$key]->push(["$mes->monthName" => $valor]);
        return $meta;
    }

    public function retornarTodasLasMetasToExcel($metas, $trl6, $trl7_8, $activos)
    {
        $meses = CarbonPeriod::create($this->year_now.'-01-01', '1 month', $this->year_now.'-12-31');
        foreach ($metas as $meta) {
            $meta['meses_trl6'] = collect([]);
            $meta['meses_trl7_trl8'] = collect([]);
            $progreso_trl6_nodo = $trl6->where('nodo', $meta->nodo_id);
            $progreso_trl7_trl8_nodo = $trl7_8->where('nodo', $meta->nodo_id);
            $cantidad_activos = $activos->where('nodo_id', $meta->nodo_id)->first();
            foreach ($meses as $mes) {
                $progreso_mes = $progreso_trl6_nodo->where('mes', $mes->monthName);
                $meta = $this->pushValueToCollect($progreso_mes, $meta, $mes, 'meses_trl6');
                $progreso_mes = $progreso_trl7_trl8_nodo->where('mes', $mes->monthName);
                $meta = $this->pushValueToCollect($progreso_mes, $meta, $mes, 'meses_trl7_trl8');
            }
            if ($cantidad_activos == null) {
              $meta['activos'] = 0;
            } else {
              $meta['activos'] = $cantidad_activos->cantidad;
            }
        }
        return $metas;
    }

    public function exportIndicadorArticulacionesInscritas($idnodo, string $fecha_inicio, string $fecha_fin, string $hoja = null)
    {
        if (session()->get('login_role') == User::IsActivador() || session()->get('login_role') == User::IsAdministrador()) {
            $idnodo = $idnodo;
        } else if (session()->get('login_role') == User::IsDinamizador()) {
            $idnodo = auth()->user()->dinamizador->nodo_id;
        } else if (session()->get('login_role') == User::IsInfocenter()) {
            $idnodo = auth()->user()->infocenter->nodo_id;
        } else {
            $idnodo = auth()->user()->gestor->nodo_id;
        }
        $query = $this->articulationRepostory->getListArticulacions()
            ->select(
                'articulation_stages.*', 'articulations.code as articulation_code',
                'articulations.id as articulation_id',
                'articulations.start_date as articulation_start_date', 'articulations.end_date as articulation_end_date',
                'articulations.name as articulation_name','articulations.description as articulation_description',
                'articulations.expected_end_date as articulation_expected_end_date',
                'articulations.entity as articulation_entity',
                'articulations.contact_name as articulation_contact_name',
                'articulations.email_entity as articulation_email_entity',
                'articulations.summon_name as articulation_summon_name',
                'articulations.objective as articulation_objective',
                'articulations.learned_lessons as articulation_learned_lessons',
                'fases.nombre as articulation_phase',
                'articulation_types.name as articulation_type',
                'articulation_subtypes.name as articulation_subtype',
                'articulation_scopes.name as articulation_scope',
                'entidades.nombre as nodo', 'actividades.codigo_actividad as codigo_proyecto',
                'actividades.nombre as nombre_proyecto', 'proyectos.id as proyecto_id',
                'fasespro.nombre as fase_proyecto'
            )
            ->selectRaw('year(articulations.start_date) as articulation_start_date_year, MONTHNAME(articulations.start_date) as articulation_start_date_month, year(articulations.end_date) as articulation_end_date_year, MONTHNAME(articulations.end_date) as articulation_end_date_month')
            ->selectRaw("if(articulationables.articulationable_type = 'App\\\Models\\\Proyecto', 'Proyecto', if(articulationables.articulationable_type = 'App\\\Models\\\Sede', 'Empresa', if(articulationables.articulationable_type = 'App\\\Models\\\Idea', 'Idea', 'No registra'))) as articulation_state_type, concat(interlocutor.documento, ' - ', interlocutor.nombres, ' ', interlocutor.apellidos) as talent_interlocutor, concat(createdby.documento, ' - ', createdby.nombres, ' ', createdby.apellidos) as created_by")
            ->selectRaw("if(articulationables.articulationable_type = 'App\\\Models\\\Sede',concat(empresas.nit, ' - ', empresas.nombre, ' - ', sedes.nombre_sede), if(articulationables.articulationable_type = 'App\\\Models\\\Idea', concat(ideas.codigo_idea, ' - ', ideas.nombre_proyecto), 'no registra')) as information_type_articulationable")
            ->selectRaw("if(articulations.postulation=1, 'SI', 'NO') articulation_postulation")
            ->selectRaw("CASE WHEN articulations.postulation = 1  THEN if(articulations.approval = 1, 'Aprobado', 'No Aprobado') ELSE 'No Aplica' END AS 'articulation_approval'")
            ->selectRaw("CASE WHEN articulations.postulation = 1  THEN if(articulations.approval = 1, articulations.receive, 'No registra') ELSE 'No Aplica' END AS 'articulation_receive'")
            ->selectRaw("CASE WHEN articulations.postulation = 1  THEN if(articulations.approval = 1, articulations.received_date, 'No registra') ELSE 'No Aplica' END AS 'articulation_received_date'")
            ->selectRaw("CASE WHEN articulations.postulation = 1  THEN if(articulations.approval = 0, articulations.report, 'No registra') ELSE 'No Aplica' END AS 'articulation_report'")
            ->selectRaw("CASE WHEN articulations.postulation = 0  THEN articulations.justification ELSE 'No Aplica' END AS 'articulation_justification'")
            ->selectRaw("GROUP_CONCAT(concat(participant.documento, ' - ', participant.nombres, ' ', participant.apellidos)) AS participants")
            ->where(function($query) use ($idnodo){
                if(isset($idnodo) && $idnodo != 'all'){
                    $query->where('articulation_stages.node_id', $idnodo);
                }
            })
            ->where(function($query) use ($fecha_inicio, $fecha_fin){
                if(isset($fecha_inicio) && isset($fecha_fin)){
                    $query->whereBetween('articulations.start_date', [$fecha_inicio, $fecha_fin]);
                }
            });
        return Excel::download(new IndicadorArticulacionesExport($query, $hoja), "Indicador Articulaciones Inscritas {$fecha_inicio} a {$fecha_fin}.xlsx");
    }

    public function exportIndicadoresArticulacionesFinalizadas($nodo, string $fecha_inicio, string $fecha_fin, string $hoja = null)
    {
        if (session()->get('login_role') == User::IsActivador() || session()->get('login_role') == User::IsAdministrador()) {
            $idnodo = $nodo;
        } else if (session()->get('login_role') == User::IsDinamizador()) {
            $idnodo = auth()->user()->dinamizador->nodo_id;
        } else if (session()->get('login_role') == User::IsInfocenter()) {
            $idnodo = auth()->user()->infocenter->nodo_id;
        } else {
            $idnodo = auth()->user()->gestor->nodo_id;
        }
        $query = $this->articulationRepostory->getListArticulacions()
            ->select(
                'articulation_stages.*', 'articulations.code as articulation_code',
                'articulations.id as articulation_id',
                'articulations.start_date as articulation_start_date', 'articulations.end_date as articulation_end_date',
                'articulations.name as articulation_name','articulations.description as articulation_description',
                'articulations.expected_end_date as articulation_expected_end_date',
                'articulations.entity as articulation_entity',
                'articulations.contact_name as articulation_contact_name',
                'articulations.email_entity as articulation_email_entity',
                'articulations.summon_name as articulation_summon_name',
                'articulations.objective as articulation_objective',
                'articulations.learned_lessons as articulation_learned_lessons',
                'fases.nombre as articulation_phase',
                'articulation_types.name as articulation_type',
                'articulation_subtypes.name as articulation_subtype',
                'articulation_scopes.name as articulation_scope',
                'entidades.nombre as nodo', 'actividades.codigo_actividad as codigo_proyecto',
                'actividades.nombre as nombre_proyecto', 'proyectos.id as proyecto_id',
                'fasespro.nombre as fase_proyecto'
            )
            ->selectRaw('year(articulations.start_date) as articulation_start_date_year, MONTHNAME(articulations.start_date) as articulation_start_date_month, year(articulations.end_date) as articulation_end_date_year, MONTHNAME(articulations.end_date) as articulation_end_date_month')
            ->selectRaw("if(articulationables.articulationable_type = 'App\\\Models\\\Proyecto', 'Proyecto', if(articulationables.articulationable_type = 'App\\\Models\\\Sede', 'Empresa', if(articulationables.articulationable_type = 'App\\\Models\\\Idea', 'Idea', 'No registra'))) as articulation_state_type, concat(interlocutor.documento, ' - ', interlocutor.nombres, ' ', interlocutor.apellidos) as talent_interlocutor, concat(createdby.documento, ' - ', createdby.nombres, ' ', createdby.apellidos) as created_by")
            ->selectRaw("if(articulationables.articulationable_type = 'App\\\Models\\\Sede',concat(empresas.nit, ' - ', empresas.nombre, ' - ', sedes.nombre_sede), if(articulationables.articulationable_type = 'App\\\Models\\\Idea', concat(ideas.codigo_idea, ' - ', ideas.nombre_proyecto), 'no registra')) as information_type_articulationable")
            ->selectRaw("if(articulations.postulation=1, 'SI', 'NO') articulation_postulation")
            ->selectRaw("CASE WHEN articulations.postulation = 1  THEN if(articulations.approval = 1, 'Aprobado', 'No Aprobado') ELSE 'No Aplica' END AS 'articulation_approval'")
            ->selectRaw("CASE WHEN articulations.postulation = 1  THEN if(articulations.approval = 1, articulations.receive, 'No registra') ELSE 'No Aplica' END AS 'articulation_receive'")
            ->selectRaw("CASE WHEN articulations.postulation = 1  THEN if(articulations.approval = 1, articulations.received_date, 'No registra') ELSE 'No Aplica' END AS 'articulation_received_date'")
            ->selectRaw("CASE WHEN articulations.postulation = 1  THEN if(articulations.approval = 0, articulations.report, 'No registra') ELSE 'No Aplica' END AS 'articulation_report'")
            ->selectRaw("CASE WHEN articulations.postulation = 0  THEN articulations.justification ELSE 'No Aplica' END AS 'articulation_justification'")
            ->selectRaw("GROUP_CONCAT(concat(participant.documento, ' - ', participant.nombres, ' ', participant.apellidos)) AS participants")
            ->where(function($query) use ($idnodo){
                if(isset($idnodo) && $idnodo != 'all'){
                    $query->where('articulation_stages.node_id', $idnodo);
                }
            })
            ->where(function($query) use ($fecha_inicio, $fecha_fin){
                if(isset($fecha_inicio) && isset($fecha_fin)){
                    $query->whereBetween('articulations.end_date', [$fecha_inicio, $fecha_fin]);
                }
            })->whereIn('fases.nombre', ['Finalizado', 'Concluido sin finalizar']);
        return Excel::download(new IndicadorArticulacionesExport($query, $hoja), "Indicadores_Articulaciones_Finalizadas_{$fecha_inicio}_a_{$fecha_fin}.xlsx");
    }

    private function setProyectoRepository($proyectoRepository)
    {
        $this->proyectoRepository = $proyectoRepository;
    }

    private function getProyectoRepository()
    {
        return $this->proyectoRepository;
    }

}
