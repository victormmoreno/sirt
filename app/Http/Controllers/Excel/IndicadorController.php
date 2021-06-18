<?php

namespace App\Http\Controllers\Excel;

use App\Exports\Indicadores\Indicadores2020Export;
use App\Repositories\Repository\{ProyectoRepository};
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Proyecto;
use Excel;

class IndicadorController extends Controller
{

  private $proyectoRepository;

  public function __construct(ProyectoRepository $proyectoRepository)
  {
    $this->setProyectoRepository($proyectoRepository);
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
    $query = '';

    if (Session::get('login_role') == User::IsAdministrador()) {

      if ($idnodo == 'all') {
        $query = $this->getProyectoRepository()->proyectosIndicadores_Repository($fecha_inicio, $fecha_fin)->get();
      } else {
        $query = $this->getProyectoRepository()->proyectosIndicadores_Repository($fecha_inicio, $fecha_fin)->whereHas('articulacion_proyecto.actividad.nodo', function($query) use ($idnodo) {
          $query->where('id', $idnodo);
        })->get();
      }
    } else if (Session::get('login_role') == User::IsDinamizador()) {
      $query = $this->getProyectoRepository()->proyectosIndicadores_Repository($fecha_inicio, $fecha_fin)->whereHas('articulacion_proyecto.actividad.nodo', function($query) {
        $query->where('id', auth()->user()->dinamizador->nodo_id);
      })->get();
    } else {
      $query = $this->getProyectoRepository()->proyectosIndicadores_Repository($fecha_inicio, $fecha_fin)->whereHas('articulacion_proyecto.actividad.gestor', function($query) {
        $query->where('id', auth()->user()->gestor->id);
      })->get();
    }
    return Excel::download(new Indicadores2020Export($query, $hoja), 'Indicadores_'.$fecha_inicio.'_a_'.$fecha_fin.'.xlsx');
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
