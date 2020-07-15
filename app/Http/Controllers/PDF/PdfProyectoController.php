<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Proyecto};
use PDF;
use App\Http\Controllers\CostoController;

class PdfProyectoController extends Controller
{
  
  public function __construct(CostoController $costoController)
  {
    $this->costoController = $costoController;
  }

  public function printFormularioCierre($id)
  {
    $proyecto = Proyecto::findOrFail($id);
    $costo = $this->costoController->costosDeUnaActividad($proyecto->articulacion_proyecto->actividad->id);
    $pdf = PDF::loadView('pdf.proyecto.form_cierre', ['proyecto' => $proyecto, 'costo' => $costo]);
    return $pdf->stream();
  }

  public function printFormularioAcuerdoDeInicio($id)
  {
    $proyecto = Proyecto::findOrFail($id);
    $pdf = PDF::loadView('pdf.proyecto.form_inicio', ['proyecto' => $proyecto]);
    return $pdf->stream();
  }


}
