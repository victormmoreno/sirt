<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade as PDF;

class PdfComiteController extends Controller
{
    public static function printPDF($idea, $comite)
    {
        $nodo = $idea->nodo->entidad->nombre;
        $comite['nodoNombre'] = $nodo;
        $pdf = PDF::loadView('pdf.csibt.pdf_idea_aceptada', ['idea' => $idea, 'comite' => $comite]);
        return $pdf->stream();
    }

    public static function printPDFNoAceptado($idea, $comite)
    {
        $pdf = PDF::loadView('pdf.csibt.pdf_idea_rechazada', [
        'idea' => $idea,
        'comite' => $comite
        ]);
        return $pdf->stream();
    }
}
