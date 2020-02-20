<?php

namespace App\Http\Controllers\PDF;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Nodo;
use PDF;

class PdfComiteController extends Controller
{
  public static function printPDF($informacion)
  {
    $nodo =\NodoHelper::returnNameNodoUsuario();
    $informacion['nodoNombre'] = $nodo;
    $pdf = PDF::loadView('pdf.csibt.pdf_idea_aceptada', $informacion);
    return $pdf->stream();
  }

  // public function printPDF()
  // {
  //   $pdf = PDF::loadView('pdf.csibt.plantilla');
  //   return $pdf->download('plantilla');
  // }

  public static function printPDFNoAceptado($informacion)
  {
    // dd($informacion);
    $nodo = Nodo::find( auth()->user()->infocenter->nodo_id );
    $informacion['telefonoNodo'] = $nodo->telefono;
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
