<?php

namespace App\Http\Controllers\PDF;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;

class PdfComiteController extends Controller
{
  // public static function printPDF($informacion)
  // {
  //   $pdf = PDF::loadView('pdf.csibt.pdf_idea_aceptada', $informacion);
  //   return $pdf->stream();
  // }

  public function printPDF()
  {
    $pdf = PDF::loadView('pdf.csibt.plantilla');
    return $pdf->download('plantilla');
  }

  public static function printPDFNoAceptado($informacion)
  {
    // dd($informacion);
    $pdf = PDF::loadView('pdf.csibt.pdf_idea_rechazada', $informacion);
    // dd($pdf);
    return $pdf->stream();
  }

  // public static function printPDF()
  // {
  //   // dd($informacion);
  //   // This  $data array will be passed to our PDF blade
  //   $data = [
  //     'title' => 'First PDF for Medium',
  //     'heading' => 'Hello from 99Points.info',
  //     'content' => '2'
  //   ];
  //
  //   $pdf = PDF::loadView('pdf.csibt.pdf_idea_rechazada', $data);
  //   // dd($pdf);
  //   return $pdf->stream();
  // }
}
