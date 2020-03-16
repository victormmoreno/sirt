<?php

namespace App\Http\Controllers\PDF;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Articulacion;
use PDF;

class PdfArticulacionController extends Controller
{
    public function printFormularioInicio($id)
    {
      $articulacion = Articulacion::findOrFail($id);
      $pdf = PDF::loadView('pdf.articulacion.form_inicio', ['articulacion' => $articulacion]);
      return $pdf->stream();
    }

    public function printFormularioCierre($id)
    {
      $articulacion = Articulacion::findOrFail($id);
      $pdf = PDF::loadView('pdf.articulacion.form_cierre', ['articulacion' => $articulacion]);
      return $pdf->stream();
    }
}
