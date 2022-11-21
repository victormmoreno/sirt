<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use App\Models\{Proyecto, ArticulacionPbt, UsoInfraestructura};
use Barryvdh\DomPDF\Facade as PDF;

class UsoInfraestructuraController extends Controller
{

    /**
     * Descarga un pdf con los detalles de los usos de infraestructura de un proyecto ó articulación
    * @param int $idActividad Id del proyecto o articulación
    * @param string $tipoActividad Indica si es proyecto o actividad
    * @return Response
    * @author dum
    */
    public function downloadPDFUsosInfraestructura(int $id, string $tipoActividad)
    {
        if ($tipoActividad == 'proyecto') {
            $data = Proyecto::findOrFail($id);
            $pdf = PDF::loadView('pdf.usos.seguimiento', ['data' => $data, 'tipo_actividad' => $tipoActividad]);

            $pdf->setPaper(strtolower('LETTER'), $orientacion = 'landscape');
            return $pdf->stream('Seguimiento_' . $data->articulacion_proyecto->actividad->present()->actividadCode() . '.pdf');

        } else if($tipoActividad == 'articulacion'){
            $data = ArticulacionPbt::findOrFail($id);
            if(request()->user()->cannot('downloadFile', $data))
            {
                alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
                return redirect()->route('home');
            }
            $pdf = PDF::loadView('pdf.usos.seguimiento', ['data' => $data, 'tipo_actividad' => $tipoActividad]);
            $pdf->setPaper(strtolower('LETTER'), $orientacion = 'landscape');
            return $pdf->stream('Seguimiento_' . $data->present()->articulacionCode(). '.pdf');
        }else{
            return abort('404');
        }
    }

}
