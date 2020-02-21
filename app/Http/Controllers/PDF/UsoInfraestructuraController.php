<?php

namespace App\Http\Controllers\PDF;

use App\Repositories\Repository\ProyectoRepository;
use App\Http\Controllers\{Controller, ProyectoController};
use Illuminate\Http\Request;
use App\Models\{Proyecto, Fase};
use Carbon\Carbon;
use PDF;

class UsoInfraestructuraController extends Controller
{

  /**
   * @var ProyectoController
   */
  private $proyectoController;

  public function __construct(ProyectoController $proyectoController)
  {
    $this->setProyectoController($proyectoController);
  }

  /**
  * Descarga un pdf con los detalles de los usos de infraestructura de un proyecto
  * @return Response
  * @author dum
  */
  public function downloadPDFUsosInfraestructura(int $idProyecto)
  {
    // $proyecto = $this->getProyectoController()->consultarDetallesDeUnProyecto($idProyecto);
    $proyecto = Proyecto::findOrFail($idProyecto);
    $usos = Proyecto::with('articulacion_proyecto.actividad.usoinfraestructuras')->find($idProyecto);
    $talentos = Proyecto::with('articulacion_proyecto.talentos.user')->find($idProyecto);
    // dd($talentos);

    $pdf = PDF::loadView('pdf.usos.seguimiento', [
      'proyecto' => $proyecto,
      'usos' => $usos,
      'talentos' => $talentos
    ]);
    $pdf->setPaper(strtolower('LETTER'), $orientacion = 'landscape');
    return $pdf->stream('Seguimiento_Proyecto_' . $proyecto['codigo_proyecto'] . '.pdf');
  }

  /**
   * Asigna un valor a $proyectoController
   * @param ProyectoController $proyectoController
   * @return void
   * @author dum
   */
  private function setProyectoController(ProyectoController $proyectoController)
  {
    $this->proyectoController = $proyectoController;
  }

  /**
   * Retorna el valor de $proyectoController
   *
   * @return proyectoController
   * @author dum
   */
  private function getProyectoController($value='')
  {
    return $this->proyectoController;
  }

}
