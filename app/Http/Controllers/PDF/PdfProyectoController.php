<?php

namespace App\Http\Controllers\PDF;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;

class PdfProyectoController extends Controller
{

    public static function printAcuerdoConfidencialidadCompromiso()
    {
      $pdf = PDF::loadView('pdf.invoice');
      return $pdf->download('invoice.pdf');
    }
}
