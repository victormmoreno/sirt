<?php

namespace App\Http\Controllers\Excel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Exports\Articulaciones\{ArticulacionesExport, ArticulacionesNodoExport, ArticulacionesUnicaExport};
use App\Repositories\Repository\{ArticulacionRepository, EmpresaRepository, GrupoInvestigacionRepository, ArticulacionProyectoRepository, UserRepository\GestorRepository};
use Excel;

class ArticulacionController extends Controller
{

  private $articulacionProyectoRepository;
  private $grupoInvestigacionRepository;
  private $articulacionRepository;
  private $empresaRepository;

  public function __construct(ArticulacionRepository $articulacionRepository, EmpresaRepository $empresaRepository, GrupoInvestigacionRepository $grupoInvestigacionRepository, ArticulacionProyectoRepository $articulacionProyectoRepository)
  {
    $this->articulacionProyectoRepository = $articulacionProyectoRepository;
    $this->grupoInvestigacionRepository = $grupoInvestigacionRepository;
    $this->articulacionRepository = $articulacionRepository;
    $this->empresaRepository = $empresaRepository;
  }

  /**
   * Genera el excel de las articulaciones que tiene un gestor
   * @param int $id Id del gestor
   * @return Response
   * @author dum
   */
  public function articulacionesDeUnGestor($id)
  {
    return Excel::download(new ArticulacionesExport($this->articulacionRepository, $id), 'Datos.xls');
  }

  /**
   * General el excel de las articulaciones de un nodo
   * @param int $id Id del nodo
   * @return Response
   * @author dum
   */
  public function articulacionesDeUnNodo($id)
  {
    return Excel::download(new ArticulacionesNodoExport($this->articulacionRepository, $id), 'Articulaciones.xls');
  }

  /**
   * Genera excel con la información de una articulación por su id
   * @param int $id Id de la articulación
   * @return Response
   * @author dum
   */
  public function articulacionPorId($id)
  {
    $articulacion = $this->articulacionRepository->consultarArticulacionPorId($id)->last();
    return Excel::download(new ArticulacionesUnicaExport($this->articulacionRepository, $id, $articulacion, $this->articulacionProyectoRepository, $this->grupoInvestigacionRepository, $this->empresaRepository), 'Articulacion ' . $articulacion->codigo_articulacion . '.xls');
  }

  // /**
  //  * Genera el excel de todas las articulaciones de tecnoparque
  //  * @return Response
  //  * @author dum
  //  */
  // public function articulacionesDeTecnoparque()
  // {
  //   return Excel::download(new ArticulacionesTecnoparqueExport($this->articulacionRepository, $id, $articulaciones), 'Articulaciones de Tecnoparque.xls');
  // }

}
