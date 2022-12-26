<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArticulacionPbt;
use Barryvdh\DomPDF\Facade as PDF;
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
        if(request()->user()->cannot('downloadFormInicio', $articulacion))
        {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $pdf = PDF::loadView('pdf.articulacionpbt.form-inicio', ['articulacion' => $articulacion]);
        return $pdf->stream();
    }

    public function downloadFormCierre($id)
    {
        $articulacion = ArticulacionPbt::findOrFail($id);
        if(request()->user()->cannot('downloadFormCierre', $articulacion))
        {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $pdf = PDF::loadView('pdf.articulacionpbt.form-cierre', ['articulacion' => $articulacion]);
        return $pdf->stream();
    }
}
