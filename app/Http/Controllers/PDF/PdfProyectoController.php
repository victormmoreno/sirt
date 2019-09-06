<?php

namespace App\Http\Controllers\PDF;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;
use App;

class PdfProyectoController extends Controller
{

    public static function printAcuerdoConfidencialidadCompromiso()
    {
      $pdf = PDF::loadView('pdf.invoice');
      return $pdf->download('invoice.pdf');
      // $pdf = App::make('dompdf.wrapper');
      // $pdf->loadHTML('<h1>Test</h1>');
      // return $pdf->stream();
      // dd(App::make('dompdf.wrapper'));
    }
}
