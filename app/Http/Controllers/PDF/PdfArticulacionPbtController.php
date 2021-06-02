<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArticulacionPbt;
use PDF;
use App\Http\Controllers\CostoController;

class PdfArticulacionPbtController extends Controller
{
  
    public function __construct(CostoController $costoController)
    {
      $this->costoController = $costoController;
    }

    public function downloadFormInicio($id)
    {
      $articulacion = ArticulacionPbt::findOrFail($id);
      $pdf = PDF::loadView('pdf.articulacionpbt.form-inicio', ['articulacion' => $articulacion]);
      return $pdf->stream();
    }

    public function downloadFormCierre($id)
    {
      $articulacion = ArticulacionPbt::findOrFail($id);
      $pdf = PDF::loadView('pdf.articulacionpbt.form-cierre', ['articulacion' => $articulacion]);
      return $pdf->stream();
    }


}
