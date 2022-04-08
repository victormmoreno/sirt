<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Session};
use App\{User, Models\Nodo, Models\Fase, Models\Proyecto};
use Repositories\Repository\NodoRepository;
use Carbon\Carbon;

class IndicadorController extends Controller
{
  private $nodoRepository;
  public function __construct(NodoRepository $nodoRepository)
  {
      $this->nodoRepository = $nodoRepository;
  }

  public function index()
  {

    if ( Session::get('login_role') == User::IsDinamizador() ) {
      return view('indicadores.dinamizador.index');
    } else if ( Session::get('login_role') == User::IsAdministrador() ) {
      $metas = $this->nodoRepository->consultarMetasDeTecnoparque();
      // dd($metas->first()->nodo->ProyectosFinalizadosTrl6('2021')->count());
      return view('indicadores.administrador.index', [
        'nodos' => Nodo::SelectNodo()->get(),
        'metas' => $metas,
        // 'finalizado_id' => Fase::where('nombre', Proyecto::IsFinalizado())->first()->id
        ]);
    } else if (Session::get('login_role') == User::IsInfocenter()) {
      return view('indicadores.infocenter.index');
    } else {
      return view('indicadores.gestor.index');
    }

  }

  public function form_import_metas()
  {
    return view('indicadores.administrador.register_metas');
  }

}
