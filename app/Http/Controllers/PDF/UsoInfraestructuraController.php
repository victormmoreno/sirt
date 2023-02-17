<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use App\Models\Articulation;
use App\Repositories\Repository\{ProyectoRepository};
use Barryvdh\DomPDF\Facade as PDF;

class UsoInfraestructuraController extends Controller
{

    public $proyectoRepository;

    public function __construct(ProyectoRepository $proyectoRepository)
    {
        $this->proyectoRepository = $proyectoRepository;
    }

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
            // $data = Proyecto::findOrFail($id);
            $data = $this->proyectoRepository->selectProyecto()->where('proyectos.id', $id)->first();
            if(!request()->user()->can('generar_docs', $data)) {
                alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
                return redirect()->route('home');
            }
            $pdf = PDF::loadView('pdf.usos.seguimiento', ['data' => $data, 'tipo_actividad' => $tipoActividad]);
            $pdf->setPaper(strtolower('LETTER'), $orientacion = 'landscape');
            return $pdf->stream('Seguimiento_' . $data->articulacion_proyecto->actividad->present()->actividadCode() . '.pdf');

        }else if ($tipoActividad == 'articulacion') {
            $data = Articulation::findOrFail($id);
            $pdf = PDF::loadView('pdf.usos.seguimiento', ['data' => $data, 'tipo_actividad' => $tipoActividad]);
            $pdf->setPaper(strtolower('LETTER'), $orientacion = 'landscape');
            return $pdf->stream('Seguimiento_' . $data->code . '.pdf');
        }else{
            return abort('404');
        }
    }
}
