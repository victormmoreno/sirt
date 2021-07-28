<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use App\Models\Articulacion;
use Barryvdh\DomPDF\Facade as PDF;
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
