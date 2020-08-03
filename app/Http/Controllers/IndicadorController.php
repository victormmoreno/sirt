<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Session, DB};
use App\{User, Models\Articulacion, Models\GrupoInvestigacion, Models\Nodo};

class IndicadorController extends Controller
{
  /**
   * ProyectoRepository
   *
   * @var ProyectoRepository
   */
  private $proyectoRepository;

  /**
   * CostoController
   *
   * @var CostoController
   */
  private $costoController;

  /**
   * ActividadRepository
   *
   * @var ActividadRepository
   */
  private $actividadRepository;

  /**
   * ArticulacionRepository
   *
   * @var ArticulacionRepository
   */
  private $articulacionRepository;

  /**
   * EdtRepository
   *
   * @var EdtRepository
   */
  private $edtRepository;

  /**
   * UserRepository
   *
   * @var TalentoRepository
   */
  private $talentoRepository;
  /**
   * Index para los indicadores
   *
   * @return Response
   */
  public function index()
  {

    if ( Session::get('login_role') == User::IsDinamizador() ) {
      return view('indicadores.dinamizador.index');
    } else if ( Session::get('login_role') == User::IsAdministrador() ) {
      return view('indicadores.administrador.index', [
        'nodos' => Nodo::SelectNodo()->get()
        ]);
      } else {
        return view('indicadores.gestor.index');
    }

  }

}
