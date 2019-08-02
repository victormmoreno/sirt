<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Session};
use App\Repositories\Repository\{ArticulacionRepository};
use App\{User};

class GraficoController extends Controller
{

  private $articulacionRepository;

  public function __construct(ArticulacionRepository $articulacionRepository)
  {
    $this->articulacionRepository = $articulacionRepository;
  }
  /**
  * Página inicial de gráficos
  * @return Response
  */
  public function index()
  {
    if ( Session::get('login_role') == User::IsDinamizador() ) {
      return view('grafico.dinamizador.index');
    }
  }

  /**
   * Vista de gráficos para las articulaciones
   * @return Response
   */
  public function articulacionesGraficos()
  {
    if ( Session::get('login_role') == User::IsDinamizador() ) {
      return view('grafico.dinamizador.articulacion');
    }
  }


  /**
  * @param array $datos
  * @return array
  */
  private function agruparGestoresArray($datos) {
    $gestor = array();
    // $gestor = (object) $gestor;
    // foreach ($datos as $key => $value) {
    //   $gestor2 = $value->gestor;
    //   array_push($gestor, $value->gestor);
    // }


    // $res2 = (object) $res2;
    //
    //
    $gestor = array_column($datos->toArray(), 'gestor');
    // $res2 = array();
    foreach ($gestor as $key => $value) {
      $res2[$value] = true;
    }
    $res2 = array_keys($res2);
    // $res2 = array_diff_key($res2, $res2);


    return $res2;
  }

  /**
   *
   * @param int $id Id del nodo
   * @return Response
   */
  public function articulacionesNodoGrafico($id)
  {
    if ( request()->ajax() ) {
      $datos = $this->articulacionRepository->tiposArticulacionesPorGestorYNodo($id);
      $tipos_articulacion = array('gestores' => [0 => ['gestor' => 'Ramiro', 'grupos' => 5, 'empresas' => 8, 'emprendedores' => 5], 1 => ['gestor' => 'Julian', 'grupos' => 7, 'empresas' => 2, 'emprendedores' => 3]]);
      $tipos2 = array('Grupos de Investigación', 'Empresas', 'Emprendedores');
      // $tipos_articulacion = array_chunk($tipos_articulacion, true);
      // $tipos_articulacion = array_values($tipos_articulacion);
      $grupos = 0;
      $empresas = 0;
      $emprendedores = 0;
      // dd($datos);
      $gestor = $this->agruparGestoresArray($datos);
      // return $gestor;
      return response()->json([
        'datos' => $datos,
        'controlador' => $gestor,
        'tipos' => $tipos_articulacion,
        'tipos2' => $tipos2
      ]);
    }
  }
}
