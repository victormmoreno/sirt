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

  public function index()
  {
    $year_now = Carbon::now()->format('Y');
    if ( Session::get('login_role') == User::IsDinamizador() ) {
      $metas = $this->nodoRepository->consultarMetasDeTecnoparque()->where('nodo_id', auth()->user()->dinamizador->nodo_id);
      $pbts_trl6 = $this->proyectoRepository->consultarTrl('trl_obtenido', 'fecha_cierre', $year_now, [Proyecto::IsTrl6Obtenido()])->where('nodos.id', auth()->user()->dinamizador->nodo_id)->get();
      $pbts_trl7_8 = $this->proyectoRepository->consultarTrl('trl_obtenido', 'fecha_cierre', $year_now, [Proyecto::IsTrl7Obtenido(), Proyecto::IsTrl8Obtenido()])->where('nodos.id', auth()->user()->dinamizador->nodo_id)->get();
      $metas = $this->retornarTodasLasMetasArray($metas, $pbts_trl6, $pbts_trl7_8);
      return view('indicadores.dinamizador.index', [
        'metas' => $metas,
        'metas_graph' => $metas->first()
      ]);
    } else if ( Session::get('login_role') == User::IsAdministrador() ) {
      $metas = $this->nodoRepository->consultarMetasDeTecnoparque();
      $pbts_trl6 = $this->proyectoRepository->consultarTrl('trl_obtenido', 'fecha_cierre', $year_now, [Proyecto::IsTrl6Obtenido()])->get();
      $pbts_trl7_8 = $this->proyectoRepository->consultarTrl('trl_obtenido', 'fecha_cierre', $year_now, [Proyecto::IsTrl7Obtenido(), Proyecto::IsTrl8Obtenido()])->get();
      $metas = $this->retornarTodasLasMetasArray($metas, $pbts_trl6, $pbts_trl7_8);
      return view('indicadores.administrador.index', [
        'nodos' => Nodo::SelectNodo()->get(),
        'metas' => $metas
        ]);
    } else if (Session::get('login_role') == User::IsInfocenter()) {
      return view('indicadores.infocenter.index');
    } else {
      return view('indicadores.gestor.index');
    }
  }

  public function retornarTodasLasMetasArray($metas, $trl6, $trl7_8)
  {
    foreach ($metas as $meta) {
      $cantidad_trl6 = $trl6->where('nodo', $meta->nodo_id)->first();
      $cantidad_trl7_8 = $trl7_8->where('nodo', $meta->nodo_id)->first();
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

      $meta['progreso_total'] = round(100*($meta->trl7_8_obtenido+$meta->trl6_obtenido)/($meta->trl6+$meta->trl7_trl8), 2);
    }

    return $metas;
  }

  public function form_import_metas()
  {
    return view('indicadores.administrador.register_metas');
  }

}
