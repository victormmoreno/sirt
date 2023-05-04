<?php

namespace App\Http\Controllers\Excel;

use App\Exports\Indicadores\{Indicadores2020Export, IndicadorArticulacionesExport};
use App\Exports\Metas\MetasExport;
use App\Exports\Idea\IdeasIndicadorExport;
use App\Repositories\Repository\{IdeaRepository, ProyectoRepository, Articulation\ArticulationRepository};
use Repositories\Repository\NodoRepository;
use App\Exports\Proyectos\{ProyectosExport};
use App\Http\Controllers\Controller;
use App\User;
use App\Imports\MigracionMetasImport;
use Illuminate\Http\Request;
use App\Models\{Articulation, Proyecto, Nodo};
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;
use MyCLabs\Enum\Enum;

class IndicadorController extends Controller
{

    private $proyectoRepository;
    private $articulationRepostory;
    private $nodoRepository;
    private $ideaRepository;
    private $year_now;
    private $type;

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

    public function exportIndicadoresProyectosInscritos(Request $request)
    {
        try {
            $this->type = 'inscritos';
            $query = null;
            $query = $this->retornarQueryAExportar($request);
            return $this->generarExcel($request, $query);
            // return Excel::download(new ProyectosExport($query->get()), 'Proyectos_'.$this->type.'_'.$request->fecha_inicio.'_a_'.$request->fecha_fin.'.xlsx');
        } catch (\Throwable $th) {
            throw $th;
        }

        // exit;
        // if ($request->hoja == 'proyectos') {
        //     $query = $this->proyectoRepository->proyectosIndicadoresSeparados_Repository()->whereBetween('fecha_inicio', [$request->fecha_inicio, $request->fecha_fin]);
        //     return Excel::download(new ProyectosExport($query->get()), 'Proyectos_Inscritos_'.$request->fecha_inicio.'_a_'.$request->fecha_fin.'.xlsx');
        // }
        // $idnodo, string $fecha_inicio, string $fecha_fin, string $hoja = null
        // dd($request->nodos);
        // $nodo_user = request()->user()->getNodoUser();
        // if (session()->get('login_role') == User::IsActivador() || session()->get('login_role') == User::IsAdministrador()) {
        //     if ($idnodo == 'all') {
        //         $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin]);
        //     } else {
        //         $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin])->where('proyectos.nodo_id', $idnodo);
        //     }
        // } else if (session()->get('login_role') == User::IsDinamizador() || session()->get('login_role') == User::IsInfocenter()) {
        //     $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin])->where('proyectos.nodo_id', $nodo_user);
        // } else {
        //     $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin])->where('id', auth()->user()->gestor->id);
        // }
        // return (new Indicadores2020Export)->download('items.xlsx');
        // return app()->make(Indicadores2020Export::class)->download('items.xlsx');
        // $exporter = new Indicadores2020Export();
        // return $exporter->download();
        // return Excel::download(new Indicadores2020Export($request), 'Indicadores_Inscritos_'.$request->fecha_inicio.'_a_'.$request->fecha_fin.'.xlsx');
        // $query = $this->proyectoRepository->proyectosIndicadoresSeparados_Repository()->whereBetween('fecha_inicio', [$request->fecha_inicio, $request->fecha_fin]);
        // return Excel::download(new ProyectosExport($query->get()), 'Proyectos_Inscritos_'.$request->fecha_inicio.'_a_'.$request->fecha_fin.'.xlsx');

        // if ($request->hoja == 'tal_ejecutores') {
        //     $sheets[] = new TalentoUserExport($this->getQuery(), 'Ejecutores');
        // }
        // if ($request->hoja == 'empresas_duenhas') {
        //     $sheets[] = new EmpresasExport($this->getQuery(), 'propietarias');
        // }
        // if ($request->hoja == 'grupos_duenhos') {
        //     $sheets[] = new GruposExport($this->getQuery(), 'propietarios');
        // }
        // if ($request->hoja == 'personas_duenhas') {
        //     $sheets[] = new TalentoUserExport($this->getQuery(), 'Propietarios');
        // }
        // return Excel::download(new Indicadores2020Export($request), 'Indicadores_Inscritos_'.$request->fecha_inicio.'_a_'.$request->fecha_fin.'.xlsx');
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

    public function exportIndicadorArticulacionesInscritas($nodo, string $fecha_inicio, string $fecha_fin, string $hoja = null)
    {
        if (request()->ajax() && request()->user()->cannot('showIndicadoresArticulacions', Model::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        if(isset($nodo) && $nodo != 'all'){
            $nodo = $this->checkRoleAuth($nodo);
        }
        $query = $this->articulationRepostory->getListArticulacions()
            ->where(function($query) use ($nodo){
                if(isset($nodo) && $nodo != 'all'){
                    $query->where('articulation_stages.node_id', $nodo);
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
        if (request()->ajax() && request()->user()->cannot('showIndicadoresArticulacions', Model::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        if(isset($nodo) && $nodo != 'all'){
            $nodo = $this->checkRoleAuth($nodo);
        }
        $query = $this->articulationRepostory->getListArticulacions()
            ->where(function($query) use ($nodo){
                if(isset($nodo) && $nodo != 'all'){
                    $query->where('articulation_stages.node_id', $nodo);
                }
            })
            ->where(function($query) use ($fecha_inicio, $fecha_fin){
                if(isset($fecha_inicio) && isset($fecha_fin)){
                    $query->whereBetween('articulations.end_date', [$fecha_inicio, $fecha_fin]);
                }
            })->whereIn('fases.nombre', ['Finalizado', 'Concluido sin finalizar']);
        return Excel::download(new IndicadorArticulacionesExport($query, $hoja), "Indicadores_Articulaciones_Finalizadas_{$fecha_inicio}_a_{$fecha_fin}.xlsx");
    }

    public function exportIndicadoresArticulacionesActivas($nodo, string $hoja = null)
    {
        if (request()->ajax() && request()->user()->cannot('showIndicadoresArticulacions', Model::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        if(isset($nodo) && $nodo != 'all'){
            $nodo = $this->checkRoleAuth($nodo);
        }
        $query = $this->articulationRepostory->getListArticulacions()
            ->where(function($query) use ($nodo){
                if(isset($nodo) && $nodo != 'all'){
                    $query->where('articulation_stages.node_id', $nodo);
                }
            })->whereIn('fases.nombre', [Articulation::IsInicio(), Articulation::IsEjecucion(), Articulation::IsCierre()]);

        return Excel::download(new IndicadorArticulacionesExport($query, $hoja), 'Indicadores_Articulaciones_Activas.xlsx');
    }

    public function exportIndicatorArticulations($nodo, string $fecha_inicio, string $fecha_fin, string $hoja = null)
    {
        if (request()->ajax() && request()->user()->cannot('showIndicadoresArticulacions', Model::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        if(isset($nodo) && $nodo != 'all'){
            $nodo = $this->checkRoleAuth($nodo);
        }
        $query = $this->articulationRepostory->getListArticulacions()
            ->where(function($query) use ($nodo){
                if(isset($nodo) && $nodo != 'all'){
                    $query->where('articulation_stages.node_id', $nodo);
                }

            })
            ->where(function($query) use ($fecha_inicio, $fecha_fin){
                if(isset($fecha_inicio) && isset($fecha_fin)){
                    $query->whereBetween('articulations.start_date', [$fecha_inicio, $fecha_fin])
                    ->orWhereBetween('articulations.end_date', [$fecha_inicio, $fecha_fin])
                    ->orWhere(function($query){
                        $query->whereIn('fases.nombre', [Articulation::IsInicio(), Articulation::IsEjecucion(), Articulation::IsCierre()]);
                    });
                }
            });
        return Excel::download(new IndicadorArticulacionesExport($query, $hoja), "Indicadores_Articulaciones_{$fecha_inicio}_a_{$fecha_fin}.xlsx");
    }


    /**
     * Retorna el archivo excel sin generar
     *
     * @param $query Consulta que se generó
     * @return Excel\Excel
     * @author dum
     **/
    public function generarExcel($request, $query)
    {
        switch ($request->hoja) {
            case 'proyectos':
                return Excel::download(new ProyectosExport($query->get()), 'file.xlsx');
                break;

            default:
                # code...
                break;
        }
        return (new ProyectosExport($query->get()));
        // return Excel::download(new ProyectosExport($query->get()), 'Proyectos_Inscritos_'.$request->fecha_inicio.'_a_'.$request->fecha_fin.'.xlsx');

    }

    /**
     * Retonar el query que se va a exportar según el caso
     *
     * @param Request $request
     * @return Builder
     * @author dum
     **/
    private function retornarQueryAExportar(Request $request)
    {

        $query = null;
        switch ($request->hoja) {
            case 'proyectos':
                return $this->consultarIndicadoresProyecto($request, $this->type);
                break;

            default:

                break;
        }
    }

    /**
     * Retornar el query que se exportará
     *
     * @param Request $request
     * @param string $type El tipo de excel que se va a exportar
     * @return type
     * @throws conditon
     **/
    public function consultarIndicadoresProyecto(Request $request, $type)
    {
        if ($request->nodos[0] == 'all' || $request->nodos[0] == null) {
            $query = $this->proyectoRepository->proyectosIndicadoresSeparados_Repository();
        } else {
            $query = $this->proyectoRepository->proyectosIndicadoresSeparados_Repository()->whereIn('nodos.id', $request->nodos);
        }
        switch ($type) {
            case 'inscritos':
                return $query->whereBetween('fecha_inicio', [$request->fecha_inicio, $request->fecha_fin]);
                break;
            case 'finalizados':
            return $query->whereBetween('fecha_cierre', [$request->fecha_inicio, $request->fecha_fin])->whereIn('fases.nombre', [Proyecto::IsFinalizado(), Proyecto::IsSuspendido()]);
                break;
            case 'activos':
            return $query->whereIn('fases.nombre', [Proyecto::IsInicio(), Proyecto::IsPlaneacion(), Proyecto::IsEjecucion(), Proyecto::IsCierre()]);
                break;
            case 'todos':
                return $query->where(function($q) use ($request) {
                    $q->whereBetween('fecha_cierre', [$request->fecha_inicio, $request->fecha_cierre])
                    ->orWhere(function($query) use ($request) {
                        $query->whereBetween('fecha_inicio', [$request->fecha_inicio, $request->fecha_cierre])
                        ->orWhere('fase', function ($query) {
                        $query->whereIn('fases.nombre', [Proyecto::IsInicio(), Proyecto::IsPlaneacion(), Proyecto::IsEjecucion(), Proyecto::IsCierre()]);
                        });
                    });
                });
                break;

            default:

                break;
        }
    }

    private function setProyectoRepository($proyectoRepository)
    {
        $this->proyectoRepository = $proyectoRepository;
    }

    private function getProyectoRepository()
    {
        return $this->proyectoRepository;
    }

    /**
     * method to validate the authenticated role
     * @return void
     */
    private function checkRoleAuth($node)
    {
        switch (\Session::get('login_role')) {
            case User::IsAdministrador():
                $node = isset($node) ? $node : null;
                break;
            case User::IsActivador():
                $node = isset($node) ? $node : null;
                break;
            case User::IsDinamizador():
                $node = auth()->user()->dinamizador->nodo_id;
                break;
            case User::IsArticulador():
                $node = auth()->user()->articulador->nodo_id;
                break;
            case User::IsExperto():
                $node = auth()->user()->gestor->nodo_id;
                break;
            case User::IsInfocenter():
                $node = auth()->user()->infocenter->nodo_id;
                break;
            case User::IsTalento():
                $node = null;
                break;
            default:
                $node = null;
                break;
        }
        return $node;
    }

}
