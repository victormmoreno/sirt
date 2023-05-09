<?php

namespace App\Http\Controllers\Excel;

use App\Exports\Indicadores\IndicadoresExport;
use App\Exports\Metas\MetasExport;
use App\Exports\Idea\IdeasIndicadorExport;
use App\Exports\Proyectos\{ProyectosExport};
use App\Exports\Empresas\EmpresasExport;
use App\Exports\GruposInvestigacion\GruposExport;
use App\Exports\User\Talento\TalentoUserExport;
use App\Repositories\Repository\{IdeaRepository, ProyectoRepository};
use Repositories\Repository\NodoRepository;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\User;
use App\Imports\MigracionMetasImport;
use Illuminate\Http\Request;
use App\Models\{Proyecto, Nodo};
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use MyCLabs\Enum\Enum;

class IndicadorController extends Controller
{

    private $proyectoRepository;
    private $nodoRepository;
    private $ideaRepository;
    private $year_now;
    private $type;

    public function __construct(ProyectoRepository $proyectoRepository, NodoRepository $nodoRepository, IdeaRepository $ideaRepository)
    {
        $this->setProyectoRepository($proyectoRepository);
        $this->nodoRepository = $nodoRepository;
        $this->ideaRepository = $ideaRepository;
        $this->year_now = Carbon::now()->format('Y');
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
                return $query->where(function($q) use ($request) {
                    $q->whereBetween('fecha_cierre', [$request->fecha_inicio, $request->fecha_cierre])
                    ->orWhere(function($query) use ($request) {
                        $query->whereBetween('fecha_inicio', [$request->fecha_inicio, $request->fecha_cierre])
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
        if ($request->nodos[0] == 'all' || $request->nodos[0] == null || $request->nodos[0] == 0) {
            return $this->proyectoRepository->indicadoresEmpresas();
        } else {
            return $this->proyectoRepository->indicadoresEmpresas()->whereIn('nodos.id', is_array($request->nodos) ? $request->nodos : [$request->nodos]);
        }
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
        if ($request->nodos[0] == 'all' || $request->nodos[0] == null || $request->nodos[0] == 0) {
            return $this->proyectoRepository->indicadoresUsersEjecutores();
        } else {
            return $this->proyectoRepository->indicadoresUsersEjecutores()->whereIn('nodos.id', is_array($request->nodos) ? $request->nodos : [$request->nodos]);
        }
        // return $query;
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
        if ($request->nodos[0] == 'all' || $request->nodos[0] == null || $request->nodos[0] == 0) {
            return $this->proyectoRepository->indicadoresUsers();
        } else {
            return $this->proyectoRepository->indicadoresUsers()->whereIn('nodos.id', is_array($request->nodos) ? $request->nodos : [$request->nodos]);
        }
        // return $query;
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
        if ($request->nodos[0] == 'all' || $request->nodos[0] == null || $request->nodos[0] == 0) {
            return $this->proyectoRepository->indicadoresGrupos();
        } else {
            return $this->proyectoRepository->indicadoresGrupos()->whereIn('nodos.id', is_array($request->nodos) ? $request->nodos : [$request->nodos]);
        }
        // return $query;
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
        if ($request->nodos[0] == 'all' || $request->nodos[0] == null || $request->nodos[0] == 0) {
            return $this->proyectoRepository->indicadoresProyectos();
        } else {
            return $this->proyectoRepository->indicadoresProyectos()->whereIn('nodos.id', is_array($request->nodos) ? $request->nodos : [$request->nodos]);
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

}
