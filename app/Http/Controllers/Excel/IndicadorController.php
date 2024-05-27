<?php

namespace App\Http\Controllers\Excel;

use App\Exports\Indicadores\IndicadoresExport;
use App\Exports\Indicadores\IndicadorArticulacionesExport;
use App\Exports\Indicadores\MetasToImport;
use App\Exports\Metas\MetasExport;
use App\Exports\Metas\MetasArticulationExport;
use App\Exports\Idea\IdeasIndicadorExport;
use App\Exports\Proyectos\{ProyectosExport};
use App\Exports\Empresas\EmpresasExport;
use App\Exports\Encuestas\ResultadosEncuesta;
use App\Exports\Encuestas\ResultadosEncuestaExport;
use App\Exports\GruposInvestigacion\GruposExport;
use App\Exports\User\Talento\TalentoUserExport;
use App\Repositories\Repository\{IdeaRepository, ProyectoRepository};
use Repositories\Repository\NodoRepository;
use App\Repositories\Repository\Articulation\ArticulationRepository;
use App\Http\Controllers\Controller;
use App\User;
use App\Imports\MigracionMetasImport;
use Illuminate\Http\Request;
use App\Models\{Articulation, Proyecto, Nodo, ResultadoEncuesta};
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class IndicadorController extends Controller
{

    private $proyectoRepository;
    private $articulationRepository;
    private $nodoRepository;
    private $ideaRepository;
    private $year_now;
    private $type;

    public function __construct(ProyectoRepository $proyectoRepository, ArticulationRepository $articulationRepository, NodoRepository $nodoRepository, IdeaRepository $ideaRepository)
    {
        $this->setProyectoRepository($proyectoRepository);
        $this->articulationRepository = $articulationRepository;
        $this->nodoRepository = $nodoRepository;
        $this->ideaRepository = $ideaRepository;
        $this->year_now = Carbon::now()->format('Y');
    }

    /**
     * Descagar el listado de equipos de un nodo
     *
     * @return Excel
     * @author dum
     */
    public function download_metas()
    {
        // if(!request()->user()->can('import', Equipo::class)) {
        //     alert('No autorizado', 'No puedes descargar la información de los equipos de este nodo', 'error')->showConfirmButton('Ok', '#3085d6');
        //     return back();
        // }
        $year = Carbon::now()->format('Y');
        $metas = $this->nodoRepository->consultarMetasDeTecnoparque()->where('anho', $year)->get();
        $nodos = Nodo::all();
        $metas_temp = null;
        foreach ($nodos as $key => $nodo) {
            $meta = $metas->where('nodo_id', $nodo->id)->first();
            if ($meta == null) {
                $metas_temp[$key]['nodo'] = $nodo->entidad->nombre;
                $metas_temp[$key]['articulaciones'] = 0;
                $metas_temp[$key]['trl6'] = 0;
                $metas_temp[$key]['tr7_trl8'] = 0;
                $metas_temp[$key]['metas_pbts_finalizados'] = 0;
            } else {
                $metas_temp[$key]['nodo'] = $meta->nodo;
                $metas_temp[$key]['articulaciones'] = $meta->articulaciones;
                $metas_temp[$key]['trl6'] = $meta->trl6;
                $metas_temp[$key]['tr7_trl8'] = $meta->trl7_trl8;
                $metas_temp[$key]['metas_pbts_finalizados'] = $meta->metas_pbts_finalizados;
            }
        }

        $metas_download = new Collection();

        foreach ($metas_temp as $key => $meta) {
            $metas_download->push((object)[
                'nodo' => $meta['nodo'],
                'articulaciones' => $meta['articulaciones'],
                'trl6' => $meta['trl6'],
                'trl7_trl8' => $meta['tr7_trl8'],
                'metas_pbts_finalizados' => $meta['metas_pbts_finalizados']
            ]);
        }
        return Excel::download(new MetasToImport($metas_download), 'Importar metas.xlsx');
    }

    public function exportIndicadoresProyectos(Request $request)
    {
        try {
            $this->type = $request->type;
            $query = null;
            $query = $this->retornarQueryAExportar($request);
            return $this->generarExcel($request, $query);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function exportResultadosEncuesta(Request $request)
    {
        try {
            $query = null;
            $query = ResultadoEncuesta::query()->getResultados();
            // $query = $this->proyectoRepository->indicadoresProyectos();
            $query = $this->nodos($request, $query);
            return Excel::download(new ResultadosEncuestaExport($query->get()), 'Resultados_encuesta_'.Carbon::now().'.xlsx');
        } catch (\Throwable $th) {
            throw $th;
        }
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
            $ideas = $ideas->where('ideas.asesor_id', request()->user()->id);
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
        $metas = $this->nodoRepository->consultarMetasDeTecnoparque($nodos)->where('anho', Carbon::now()->format('Y'))->get();
        $pbts_trl6 = $this->proyectoRepository->consultarTrl('trl_obtenido', 'fecha_cierre', $this->year_now, [Proyecto::IsTrl6Obtenido()])
            ->whereIn('nodos.id', $nodos)
            ->groupBy('mes')
            ->get();


        $pbts_trl7_8 = $this->proyectoRepository->consultarTrl('trl_obtenido', 'fecha_cierre', $this->year_now, [Proyecto::IsTrl7Obtenido(), Proyecto::IsTrl8Obtenido()])
            ->whereIn('nodos.id', $nodos)
            ->groupBy('mes')
            ->get();
        $activos = $this->proyectoRepository->proyectosIndicadoresSeparados_Repository()->select('proyectos.nodo_id')->selectRaw('count(proyectos.id) as cantidad')
            ->whereIn('fases.nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre'])
            ->groupBy('proyectos.nodo_id')->get();
        $metas = $this->retornarTodasLasMetasToExcel($metas, $pbts_trl6, $pbts_trl7_8, $activos);
        return Excel::download(new MetasExport($metas), 'Metas.xlsx');
    }

    public function downloadMetasArticulaciones(Request $request)
    {

        try {
            if ($request->txtnodo_meta_articulaticion[0] != 'all') {
                if (Str::contains(session()->get('login_role'), [User::IsActivador(), User::IsAdministrador()])) {
                    $nodos = $request->txtnodo_meta_articulaticion;
                } else {
                    $nodos = [request()->user()->getNodoUser()];
                }
            } else {
                $nodos_temp = Nodo::SelectNodo()->get();
                foreach ($nodos_temp as $nodo) {
                    $nodos[] = $nodo->id;
                }
            }
            $metas = $this->nodoRepository->consultarMetasDeTecnoparque($nodos)->where('anho', Carbon::now()->format('Y'))->get();
            $year_now = Carbon::now()->format('Y');
            $articulations_start = $this->articulationRepository->articulationsForPhase('fases.nombre', null, $year_now, [Articulation::IsInicio()])
                ->selectRaw('count(articulations.id) as cantidad')
                ->whereIn('nodos.id', $nodos)
                ->groupBy('nodo')
                ->get();
            $articulations_execution = $this->articulationRepository->articulationsForPhase('fases.nombre', null, $year_now, [Articulation::IsEjecucion()])->whereIn('nodos.id', $nodos)->get();
            $articulations_closing = $this->articulationRepository->articulationsForPhase('fases.nombre', null, $year_now, [Articulation::IsCierre()])->whereIn('nodos.id', $nodos)->get();
            $articulations_finish = $this->articulationRepository->articulationsForPhase('fases.nombre', 'articulations.end_date', $year_now, [Articulation::IsFinalizado()])
                ->whereIn('nodos.id', $nodos)
                ->groupBy('mes')
                ->get();
            $articulations_canceled = $this->articulationRepository->articulationsForPhase('fases.nombre', 'articulations.end_date', $year_now, [Articulation::IsCancelado()])
                ->whereIn('nodos.id', $nodos)
                ->groupBy('mes')
                ->get();
            $metas = $this->retornarTodasLasMetasArticulacionesToExcel($metas, $articulations_start, $articulations_execution, $articulations_closing, $articulations_finish, $articulations_canceled);
            toast('Reporte generado con éxito!', 'success')->autoClose(2000)->position('top-end');
            return Excel::download(new MetasArticulationExport($metas), 'Metas Articulaciones.xlsx');
        } catch (\Exception $e) {
            toast('No se pudo exportar el reporte', 'danger')->autoClose(2000)->position('top-end');
            return back();
        }
    }



    private function pushValueToCollect($progreso_mes, $meta, $mes, $key)
    {
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
        $meses = CarbonPeriod::create($this->year_now . '-01-01', '1 month', $this->year_now . '-12-31');
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

    public function retornarTodasLasMetasArticulacionesToExcel($metas,  $articulations_start, $articulations_execution, $articulations_closing, $articulations_finish, $articulations_canceled)
    {
        // dd($articulations_start);
        $meses = CarbonPeriod::create($this->year_now . '-01-01', '1 month', $this->year_now . '-12-31');
        foreach ($metas as $meta) {
            $articulation_start = $articulations_start->where('nodo', $meta->nodo_id)->first();
            $articulation_execution = $articulations_execution->where('nodo', $meta->nodo_id)->first();
            $articulation_closing = $articulations_closing->where('nodo', $meta->nodo_id)->first();
            $articulation_canceled = $articulations_canceled->where('nodo', $meta->nodo_id)->first();

            $meta['month_articulation_finish'] = collect([]);

            $progreso_articulation_finish = $articulations_finish->where('nodo', $meta->nodo_id);
            foreach ($meses as $mes) {
                $progreso_mes = $progreso_articulation_finish->where('mes', $mes->monthName);
                $meta = $this->pushValueToCollect($progreso_mes, $meta, $mes, 'month_articulation_finish');
            }
            if ($articulation_start == null) {
                $meta['count_articulation_start']  = 0;
            } else {
                $meta['count_articulation_start'] = $articulation_start->cantidad;
            }

            if ($articulation_execution == null) {
                $meta['count_articulation_execution']  = 0;
            } else {
                $meta['count_articulation_execution'] = $articulation_execution->cantidad;
            }

            if ($articulation_closing == null) {
                $meta['count_articulation_closing']  = 0;
            } else {
                $meta['count_articulation_closing'] = $articulation_closing->cantidad;
            }
            if ($articulation_canceled == null) {
                $meta['count_articulation_canceled']  = 0;
            } else {
                $meta['count_articulation_canceled'] = $articulation_canceled->cantidad;
            }
        }

        return $metas;
    }

    public function exportIndicadorArticulacionesInscritas($nodo, string $fecha_inicio, string $fecha_fin, string $hoja = null)
    {
        if (request()->ajax() && request()->user()->cannot('showIndicadoresArticulacions', Model::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        if (isset($nodo) && $nodo != 'all') {
            $nodo = $this->checkRoleAuth($nodo);
        }
        $query = $this->articulationRepository->getListArticulacions()
            ->where(function ($query) use ($nodo) {
                if (isset($nodo) && $nodo != 'all') {
                    $query->where('articulation_stages.node_id', $nodo);
                }
            })
            ->where(function ($query) use ($fecha_inicio, $fecha_fin) {
                if (isset($fecha_inicio) && isset($fecha_fin)) {
                    $query->whereBetween('articulations.start_date', [$fecha_inicio, $fecha_fin]);
                }
            });
        return Excel::download(new IndicadorArticulacionesExport($query, $hoja), "Indicador Articulaciones Inscritas {$fecha_inicio} a {$fecha_fin}.xlsx");
    }

    public function exportIndicadoresArticulacionesFinalizadas($nodo, string $fecha_inicio, string $fecha_fin, string $hoja = null)
    {
        if (request()->ajax() && request()->user()->cannot('showIndicadoresArticulacions', Model::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        if (isset($nodo) && $nodo != 'all') {
            $nodo = $this->checkRoleAuth($nodo);
        }
        $query = $this->articulationRepository->getListArticulacions()
            ->where(function ($query) use ($nodo) {
                if (isset($nodo) && $nodo != 'all') {
                    $query->where('articulation_stages.node_id', $nodo);
                }
            })
            ->where(function ($query) use ($fecha_inicio, $fecha_fin) {
                if (isset($fecha_inicio) && isset($fecha_fin)) {
                    $query->whereBetween('articulations.end_date', [$fecha_inicio, $fecha_fin]);
                }
            })->whereIn('fases.nombre', ['Finalizado', 'Cancelado']);
        return Excel::download(new IndicadorArticulacionesExport($query, $hoja), "Indicadores_Articulaciones_Finalizadas_{$fecha_inicio}_a_{$fecha_fin}.xlsx");
    }

    public function exportIndicadoresArticulacionesActivas($nodo, string $hoja = null)
    {
        if (request()->ajax() && request()->user()->cannot('showIndicadoresArticulacions', Model::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        if (isset($nodo) && $nodo != 'all') {
            $nodo = $this->checkRoleAuth($nodo);
        }
        $query = $this->articulationRepository->getListArticulacions()
            ->where(function ($query) use ($nodo) {
                if (isset($nodo) && $nodo != 'all') {
                    $query->where('articulation_stages.node_id', $nodo);
                }
            })->whereIn('fases.nombre', [Articulation::IsInicio(), Articulation::IsEjecucion(), Articulation::IsCierre()]);

        return Excel::download(new IndicadorArticulacionesExport($query, $hoja), 'Indicadores_Articulaciones_Activas.xlsx');
    }

    public function exportIndicatorArticulations($nodo, string $fecha_inicio, string $fecha_fin, string $hoja = null)
    {
        if (request()->ajax() && request()->user()->cannot('showIndicadoresArticulacions', Model::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        if (isset($nodo) && $nodo != 'all') {
            $nodo = $this->checkRoleAuth($nodo);
        }
        $query = $this->articulationRepository->getListArticulacions()
            ->where(function ($query) use ($nodo) {
                if (isset($nodo) && $nodo != 'all') {
                    $query->where('articulation_stages.node_id', $nodo);
                }
            })
            ->where(function ($query) use ($fecha_inicio, $fecha_fin) {
                if (isset($fecha_inicio) && isset($fecha_fin)) {
                    $query->whereBetween('articulations.start_date', [$fecha_inicio, $fecha_fin])
                        ->orWhereBetween('articulations.end_date', [$fecha_inicio, $fecha_fin])
                        ->orWhere(function ($query) {
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
            case 'empresas_duenhas':
                return Excel::download(new EmpresasExport($query->get(), 'propetarias'), 'file.xlsx');
                break;
            case 'grupos_duenhos':
                return Excel::download(new GruposExport($query->get(), 'propetarios'), 'file.xlsx');
                break;
            case 'personas_duenhas':
                return Excel::download(new TalentoUserExport($query->get(), 'Propetarios'), 'file.xlsx');
                break;
            case 'tal_ejecutores':
                return Excel::download(new TalentoUserExport($query->get(), 'Ejecutores'), 'file.xlsx');
                break;
            case 'all':
                return Excel::download(new IndicadoresExport($query, $request->hoja), 'file.xlsx');
                break;

            default:
                abort('404');
                break;
        }
    }

    /**
     * Retonar las condiciones del query según el tipo de indicador que se va a exportar
     *
     * @param Request $request
     * @param $query Query
     * @return Builder
     * @author dum
     **/
    public function agregarCondicionales($request, $query)
    {
        switch ($this->type) {
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
                return $query->where(function ($q) use ($request) {
                    $q->whereBetween('fecha_cierre', [$request->fecha_inicio, $request->fecha_fin])
                        ->orWhere(function ($query) use ($request) {
                            $query->whereBetween('fecha_inicio', [$request->fecha_inicio, $request->fecha_fin])
                                ->orWhereIn('fases.nombre', [Proyecto::IsInicio(), Proyecto::IsPlaneacion(), Proyecto::IsEjecucion(), Proyecto::IsCierre()]);
                        });
                });
                break;

            default:

                break;
        }
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
                $query = $this->consultarIndicadoresProyecto($request);
                break;
            case 'empresas_duenhas':
                $query = $this->consultarIndicadoresEmpresas($request);
                break;
            case 'grupos_duenhos':
                $query = $this->consultarIndicadoresGrupos($request);
                break;
            case 'personas_duenhas':
                $query = $this->consultarIndicadoresUsers($request);
                break;
            case 'tal_ejecutores':
                $query = $this->consultarIndicadoresUsersEjecutores($request);
                break;
            case 'all':
                return [
                    'proyectos' => $this->agregarCondicionales($request, $this->consultarIndicadoresProyecto($request)),
                    'talentos_ejecutores' => $this->agregarCondicionales($request, $this->consultarIndicadoresUsersEjecutores($request)),
                    'empresas_duenhas' => $this->agregarCondicionales($request, $this->consultarIndicadoresEmpresas($request)),
                    'grupos_duenhos' => $this->agregarCondicionales($request, $this->consultarIndicadoresGrupos($request)),
                    'personas_duenhas' => $this->agregarCondicionales($request, $this->consultarIndicadoresUsers($request))
                ];
                break;

            default:

                break;
        }
        return $this->agregarCondicionales($request, $query);
    }

    /**
     * Retornar el query de empresas que se exportará
     *
     * @param Request $request
     * @return \Builder
     * @author dum
     **/
    public function consultarIndicadoresEmpresas(Request $request)
    {
        $query = null;
        $query = $this->proyectoRepository->indicadoresEmpresas();
        $query = $this->nodos($request, $query);
        $query = $this->experto($query);
        return $query;
    }

    /**
     * Retornar el query de los usuarios/talentos ejecutores de oriyecti que se exportará
     *
     * @param Request $request
     * @return Builder
     * @author dum
     **/
    public function consultarIndicadoresUsersEjecutores(Request $request)
    {
        $query = null;
        $query = $this->proyectoRepository->indicadoresUsersEjecutores();
        $query = $this->nodos($request, $query);
        $query = $this->experto($query);
        return $query;
    }

    /**
     * Retornar el query de los usuarios dueños que se exportará
     *
     * @param Request $request
     * @return Builder
     * @author dum
     **/
    public function consultarIndicadoresUsers(Request $request)
    {
        $query = null;
        $query = $this->proyectoRepository->indicadoresUsers();
        $query = $this->nodos($request, $query);
        $query = $this->experto($query);
        return $query;
    }

    /**
     * Retornar el query de grpos de investigación que se exportará
     *
     * @param Request $request
     * @return Builder
     * @author dum
     **/
    public function consultarIndicadoresGrupos(Request $request)
    {
        $query = null;
        $query = $this->proyectoRepository->indicadoresGrupos();
        $query = $this->nodos($request, $query);
        $query = $this->experto($query);
        return $query;
    }

    /**
     * Retornar el query de proyectos que se exportará
     *
     * @param Request $request
     * @param string $type El tipo de excel que se va a exportar
     * @return type
     * @throws conditon
     **/
    public function consultarIndicadoresProyecto(Request $request)
    {
        $query = null;
        $query = $this->proyectoRepository->indicadoresProyectos();
        $query = $this->nodos($request, $query);
        $query = $this->experto($query);
        return $query;
    }

    /**
     * Retorna la condición para los expertos de los que se generarán los indicadores
     *
     * @param Request $request
     * @param Builder $query
     * @return Builder
     * @author dum
     **/
    public function experto($query)
    {
        if (session()->get('login_role') == User::IsExperto()) {
            return $query->where('proyectos.experto_id', request()->user()->id);
        }
        return $query;
    }

    /**
     * Retornar la condicion para los nodos de los que se generarán los indicadores
     *
     * @param Request $request
     * @param Builder $query
     * @return Builder
     * @author dum
     **/
    private function nodos($request, $query)
    {
        if ($request->nodos[0] != 'all' && $request->nodos[0] != null && $request->nodos[0] != 0) {
            return $query->whereIn('nodos.id', is_array($request->nodos) ? $request->nodos : [$request->nodos]);
        }
        return $query;
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
                $node = auth()->user()->experto->nodo_id;
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
