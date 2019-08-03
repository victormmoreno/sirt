<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Session};
use App\Repositories\Repository\{ArticulacionRepository};
use App\{User, Models\Gestor};

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
    // $gestor = array_column($datos->toArray(), 'gestor');
    foreach ($gestor as $key => $value) {
      $res2[$value] = true;
    }
    $res2 = array_keys($res2);
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
      $gestoresDelNodo = Gestor::ConsultarGestoresPorNodo($id)->get();
      // dd($gestoresDelNodo);
      $tipos_articulacion = array('gestores' => [0 => ['gestor' => 'Ramiro', 'grupos' => 5, 'empresas' => 8, 'emprendedores' => 5], 1 => ['gestor' => 'Julian', 'grupos' => 7, 'empresas' => 2, 'emprendedores' => 3]]);
      $datosCompletos = array();
      // $tipos_articulacion = array('gestores' => [0 => ['gestor' => 'Ramiro', 'grupos' => 5, 'empresas' => 8, 'emprendedores' => 5], 1 => ['gestor' => 'Julian', 'grupos' => 7, 'empresas' => 2, 'emprendedores' => 3]]);
      $tipos2 = array('Grupos de Investigación', 'Empresas', 'Emprendedores');
      $gestor = array();

      foreach ($gestoresDelNodo as $key => $value) {
        $array = array('gestor' => $value->nombres_gestor);
        array_push($datosCompletos, $array);
        for ($i=0; $i < 3 ; $i++) {
          $articulaciones = $this->articulacionRepository->consultarCantidadDeArticulacionesPorTipoDeArticulacionYGestor($value->id, $i);
          if ($articulaciones != null) {
            array_merge($datosCompletos, $articulaciones->toArray());

          }
        }
      }
      $grupos = 0;
      $empresas = 0;
      $emprendedores = 0;
    }
  }

}
