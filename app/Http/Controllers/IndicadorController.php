<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Session};
use App\{User, Models\Nodo, Models\Fase, Models\Proyecto};
use Repositories\Repository\NodoRepository;
use App\Repositories\Repository\ProyectoRepository;
use Carbon\Carbon;

class IndicadorController extends Controller
{
  private $nodoRepository;
  private $proyectoRepository;
  public function __construct(NodoRepository $nodoRepository, ProyectoRepository $proyectoRepository)
  {
      $this->nodoRepository = $nodoRepository;
      $this->proyectoRepository = $proyectoRepository;
  }

  public function nodo_pagination(Request $request)
  {
      $nodos_g = Nodo::SelectNodo()->paginate(6);
      return view('indicadores.componentes.nodo_pagination', compact('nodos_g'))->render();
  }

  public function index()
  {
    $year_now = Carbon::now()->format('Y');

    if (session()->get('login_role') == User::IsDinamizador()) {
      $nodos = [auth()->user()->dinamizador->nodo_id];
    } elseif (session()->get('login_role') == User::IsInfocenter()) {
      $nodos = [auth()->user()->infocenter->nodo_id];
    } else {
      $nodos_temp = Nodo::SelectNodo()->get()->toArray();
      foreach($nodos_temp as $nodo) {
        $nodos[] = $nodo['id'];
      }
    }

    $metas = $this->nodoRepository->consultarMetasDeTecnoparque()->whereIn('nodo_id', $nodos);
    $pbts_trl6 = $this->proyectoRepository->consultarTrl('trl_obtenido', 'fecha_cierre', $year_now, [Proyecto::IsTrl6Obtenido()])->whereIn('nodos.id', $nodos)->get();
    $pbts_trl7_8 = $this->proyectoRepository->consultarTrl('trl_obtenido', 'fecha_cierre', $year_now, [Proyecto::IsTrl7Obtenido(), Proyecto::IsTrl8Obtenido()])->whereIn('nodos.id', $nodos)->get();
    $activos = $this->proyectoRepository->proyectosIndicadoresSeparados_Repository()->select('nodo_id')->selectRaw('count(id) as cantidad')->whereHas('fase', function ($query) {
      $query->whereIn('nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre']);
    })->whereIn('nodo_id', $nodos)->groupBy('nodo_id')->get();
    $metas = $this->retornarTodasLasMetasArray($metas, $pbts_trl6, $pbts_trl7_8, $activos);

    return view('indicadores.index', [
      'nodos' => Nodo::SelectNodo()->get(),
      'nodos_g' => Nodo::SelectNodo()->paginate(6),
      'metas' => $metas
    ]);
  }

  public function retornarTodasLasMetasArray($metas, $trl6, $trl7_8, $activos)
  {
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

      $meta['progreso_total'] = round(100*($meta->trl7_8_obtenido+$meta->trl6_obtenido)/($meta->trl6+$meta->trl7_trl8), 2);
    }

    return $metas;
  }

  public function form_import_metas()
  {
    return view('indicadores.register_metas');
  }

}
