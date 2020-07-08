<?php

namespace App\Http\Controllers\PDF;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Nodo;
use PDF;

class PdfComiteController extends Controller
{
  public static function printPDF($idea, $comite)
  {
    $nodo =\NodoHelper::returnNameNodoUsuario();
    $comite['nodoNombre'] = $nodo;
    $pdf = PDF::loadView('pdf.csibt.pdf_idea_aceptada', ['idea' => $idea, 'comite' => $comite]);
    return $pdf->stream();
  }

  public static function printPDFNoAceptado($idea, $comite, $extensiones)
  {
    $pdf = PDF::loadView('pdf.csibt.pdf_idea_rechazada', [
      'idea' => $idea,
      'comite' => $comite,
      'extensiones' => $extensiones
    ]);
    return $pdf->stream();
  }

}
