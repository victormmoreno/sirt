<?php

namespace App\Http\Controllers\Excel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Exports\{ArticulacionesExport, ArticulacionesNodoExport};
use App\Repositories\Repository\{ArticulacionRepository, EmpresaRepository, GrupoInvestigacionRepository, ArticulacionProyectoRepository, UserRepository\GestorRepository};
use Excel;

class ArticulacionController extends Controller
{

  private $articulacionRepository;

  public function __construct(ArticulacionRepository $articulacionRepository)
  {
    $this->articulacionRepository = $articulacionRepository;
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

}
