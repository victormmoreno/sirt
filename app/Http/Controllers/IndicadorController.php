<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{User, Models\Nodo, Models\Proyecto, Models\Articulation};
use Repositories\Repository\NodoRepository;
use App\Repositories\Repository\ProyectoRepository;
use App\Repositories\Repository\Articulation\ArticulationRepository;
use Carbon\Carbon;

class IndicadorController extends Controller
{
  private $nodoRepository;
  private $proyectoRepository;
  private $articulationRepository;
  public function __construct(NodoRepository $nodoRepository, ProyectoRepository $proyectoRepository, ArticulationRepository $articulationRepository)
  {
      $this->nodoRepository = $nodoRepository;
      $this->proyectoRepository = $proyectoRepository;
      $this->articulationRepository = $articulationRepository;
  }

public function nodo_pagination(Request $request)
{
    $nodos_g = Nodo::SelectNodo()->paginate(6);
    return view('indicadores.componentes.nodo_pagination', compact('nodos_g'))->render();
}

public function index()
{
    $year_now = Carbon::now()->format('Y');
    $expertos = null;

    if(!request()->user()->can('index_indicadores', Illuminate\Database\Eloquent\Model::class)) {
    alert('No autorizado', 'No puedes acceder a los indicadores', 'error')->showConfirmButton('Ok', '#3085d6');
    return back();
    }
    if (session()->get('login_role') == User::IsAdministrador() || session()->get('login_role') == User::IsActivador()) {
        $nodos_temp = Nodo::SelectNodo()->get()->toArray();
        foreach($nodos_temp as $nodo) {
            $nodos[] = $nodo['id'];
        }
    } else {
        $expertos = User::ConsultarFuncionarios(request()->user()->getNodoUser(), User::IsExperto())->get();
        $nodos = [request()->user()->getNodoUser()];
    }
    $metas = $this->nodoRepository->consultarMetasDeTecnoparque($nodos)->where('anho', $year_now)->get();
 
    $pbts_trl6 = $this->proyectoRepository->consultarTrl('trl_obtenido', 'fecha_cierre', $year_now, [Proyecto::IsTrl6Obtenido()])->whereIn('nodos.id', $nodos)->get();
    $pbts_trl7_8 = $this->proyectoRepository->consultarTrl('trl_obtenido', 'fecha_cierre', $year_now, [Proyecto::IsTrl7Obtenido(), Proyecto::IsTrl8Obtenido()])->whereIn('nodos.id', $nodos)->get();
    $activos = $this->proyectoRepository->proyectosIndicadoresSeparados_Repository()->select('proyectos.nodo_id')->selectRaw('count(proyectos.id) as cantidad')->whereIn('fases.nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre'])->whereIn('proyectos.nodo_id', $nodos)->groupBy('proyectos.nodo_id')->get();
    $articulations_start = $this->articulationRepository->articulationsForPhase('fases.nombre', null, $year_now, [Articulation::IsInicio()])->whereIn('nodos.id', $nodos)->get();
    $articulations_execution = $this->articulationRepository->articulationsForPhase('fases.nombre', null, $year_now, [Articulation::IsEjecucion()])->whereIn('nodos.id', $nodos)->get();
    $articulations_closing = $this->articulationRepository->articulationsForPhase('fases.nombre', null, $year_now, [Articulation::IsCierre()])->whereIn('nodos.id', $nodos)->get();
    $articulations_finish = $this->articulationRepository->articulationsForPhase('fases.nombre', 'articulations.end_date', $year_now, [Articulation::IsFinalizado()])->whereIn('nodos.id', $nodos)->get();
    $articulations_canceled = $this->articulationRepository->articulationsForPhase('fases.nombre', 'articulations.end_date', $year_now, [Articulation::IsCancelado()])->whereIn('nodos.id', $nodos)->get();

    $metasProyectos = $this->retornarTodasLasMetasArray($metas, $pbts_trl6, $pbts_trl7_8, $activos);
    $metasArticulaciones = $this->retornarTodasLasMetasArticulacionArray($metas, [
        'start' => $articulations_start,
        'execution' => $articulations_execution,
        'closing' => $articulations_closing,
        'finish' => $articulations_finish,
        'canceled' => $articulations_canceled
    ]);
    $nodos = Nodo::SelectNodo()->whereIn('nodos.id', $nodos)->get();
    return view('indicadores.index', [
      'nodos' => $nodos,
      'nodos_g' => $nodos,
      'metas' => $metasProyectos,
      'metasArticulaciones' => $metasArticulaciones,
      'expertos' => $expertos
    ]);
}

    public function retornarTodasLasMetasArray($metas, $trl6, $trl7_8, $activos)
    {
        if ($metas != null) {
            foreach ($metas as $meta) {
                $cantidad_trl6 = $trl6->where('nodo', $meta->nodo_id)->first();
                $cantidad_trl7_8 = $trl7_8->where('nodo', $meta->nodo_id)->first();
                $cantidad_activos = $activos->where('nodo_id', $meta->nodo_id)->first();
                if ($cantidad_trl6 == null) {
                    $meta['trl6_obtenido'] = 0;
                } else {
                    $meta['trl6_obtenido'] = $cantidad_trl6->cantidad;
                }

                if ($cantidad_trl7_8 == null) {
                    $meta['trl7_8_obtenido'] = 0;
                } else {
                    $meta['trl7_8_obtenido'] = $cantidad_trl7_8->cantidad;
                }

                if ($cantidad_activos == null) {
                    $meta['activos'] = 0;
                } else {
                    $meta['activos'] = $cantidad_activos->cantidad;
                }

                $meta['progreso_total_proyectos'] = round(100*($meta->trl7_8_obtenido+$meta->trl6_obtenido)/($meta->trl6+$meta->trl7_trl8), 2);
            }
        }
        return $metas;
    }

    public function retornarTodasLasMetasArticulacionArray($metas, $values)
    {
        foreach ($metas as $meta) {
            $cantidad_inicio = $values['start']->where('nodo', $meta->nodo_id)->first();

            $cantidad_ejecucion = $values['execution']->where('nodo', $meta->nodo_id)->first();
            $cantidad_cierre = $values['closing']->where('nodo', $meta->nodo_id)->first();
            $cantidad_finalizado = $values['finish']->where('nodo', $meta->nodo_id)->first();
            $cantidad_cancelado = $values['canceled']->where('nodo', $meta->nodo_id)->first();
            if ($cantidad_inicio == null) {
                $meta['articulation_start'] = 0;
            } else {
                $meta['articulation_start'] = $cantidad_inicio->cantidad;
            }
            if ($cantidad_ejecucion == null) {
                $meta['articulation_execution'] = 0;
            } else {
                $meta['articulation_execution'] = $cantidad_ejecucion->cantidad;
            }
            if ($cantidad_cierre == null) {
                $meta['articulation_closing'] = 0;
            } else {
                $meta['articulation_closing'] = $cantidad_cierre->cantidad;
            }
            if ($cantidad_finalizado == null) {
                $meta['articulation_finish'] = 0;
            } else {
                $meta['articulation_finish'] = $cantidad_finalizado->cantidad;
            }
            if ($cantidad_cancelado == null) {
                $meta['articulation_canceled'] = 0;
            } else {
                $meta['articulation_canceled'] = $cantidad_cancelado->cantidad;
            }
            if(isset($meta->articulation_finish) && $meta->articulation_finish != 0){
                $meta['progreso_total_articulaciones'] = round(100*($meta->articulation_finish/$meta->articulaciones), 2);
            }else{
                $meta['progreso_total_articulaciones'] = round(0, 2);
            }
        }
        return $metas;
    }
    public function form_import_metas()
    {
        return view('indicadores.register_metas');
    }
}
