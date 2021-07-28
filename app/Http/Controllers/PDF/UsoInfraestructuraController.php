<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\{Controller, ProyectoController};
use App\Models\{Proyecto, ArticulacionPbt};
use Barryvdh\DomPDF\Facade as PDF;

class UsoInfraestructuraController extends Controller
{
    /**
     * @var ProyectoController
     */
    private $proyectoController;

    public function __construct(ProyectoController $proyectoController)
    {
        $this->setProyectoController($proyectoController);
    }

    /**
     * Descarga un pdf con los detalles de los usos de infraestructura de un proyecto ó articulación
    * @param int $idActividad Id del proyecto o articulación
    * @param string $tipoActividad Indica si es proyecto o actividad
    * @return Response
    * @author dum
    */
    public function downloadPDFUsosInfraestructura(int $idActividad, string $tipoActividad)
    {
        if ($tipoActividad == 'proyecto') {
            $actividad = Proyecto::findOrFail($idActividad);
            $usos = Proyecto::with('articulacion_proyecto.actividad.usoinfraestructuras')->find($idActividad);
            $talentos = Proyecto::with('articulacion_proyecto.talentos.user')->find($idActividad);

            $pdf = PDF::loadView('pdf.usos.seguimiento', [
                'actividad' => $actividad,
                'usos' => $usos,
                'talentos' => $talentos,
                'tipo_actividad' => $tipoActividad
            ]);

            $pdf->setPaper(strtolower('LETTER'), $orientacion = 'landscape');
            return $pdf->stream('Seguimiento_' . $actividad->articulacion_proyecto->actividad->present()->actividadCode() . '.pdf');

        } else if($tipoActividad == 'articulacion'){
            $actividad = ArticulacionPbt::findOrFail($idActividad);
            $usos = ArticulacionPbt::with(['actividad.usoinfraestructuras'])->find($idActividad);
            $talentos = ArticulacionPbt::with('talentos.user')->find($idActividad);

            $pdf = PDF::loadView('pdf.usos.seguimiento', [
                'actividad' => $actividad,
                'usos' => $usos,
                'talentos' => $talentos,
                'tipo_actividad' => $tipoActividad
            ]);

            $pdf->setPaper(strtolower('LETTER'), $orientacion = 'landscape');
            return $pdf->stream('Seguimiento_' . $actividad->actividad->codigo_actividad . '.pdf');
        }else{
            return abort('404');
        }
    }

    /**
     * Asigna un valor a $proyectoController
     * @param ProyectoController $proyectoController
     * @return void
     * @author dum
     */
    private function setProyectoController(ProyectoController $proyectoController)
    {
        $this->proyectoController = $proyectoController;
    }

    /**
     * Retorna el valor de $proyectoController
     *
     * @return proyectoController
     * @author dum
     */
    private function getProyectoController($value='')
    {
        return $this->proyectoController;
    }

}
