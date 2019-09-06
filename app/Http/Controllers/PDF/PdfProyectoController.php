<?php

namespace App\Http\Controllers\PDF;
use App\Repositories\Repository\ProyectoRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyecto;
use PDF;
use App;

class PdfProyectoController extends Controller
{

  private $proyectoRepository;
  public function __construct(ProyectoRepository $proyectoRepository)
  {
    $this->setProyectoRepository($proyectoRepository);
  }

  /**
   * Genera el archivo pdf del acuerdo de confidencial y compromiso
   *
   * @param int $id Id del proyecto
   * @return Response
   * @author dum
   */
  public function printAcuerdoConfidencialidadCompromiso($id)
  {
    $proyecto = Proyecto::find($id);
    $talento_lider = $this->getProyectoRepository()->consultarTalentoLiderDeUnProyecto($id)->first();
    $pdf = PDF::loadView('pdf.proyecto.acc', [
      'proyecto' => $proyecto,
      'talento_lider' => $talento_lider
    ]);
    return $pdf->stream();
  }

  /**
   * Asigna un valor a $proyectoRepository
   * @param object $proyectoRepository
   * @return void
   * @author dum
   */
  private function setProyectoRepository($proyectoRepository)
  {
    $this->proyectoRepository  = $proyectoRepository;
  }

  /**
   * Retorna el valor de $proyectoRepository
   * @return object
   * @author dum
   */
  private function getProyectoRepository()
  {
    return $this->proyectoRepository;
  }

}
