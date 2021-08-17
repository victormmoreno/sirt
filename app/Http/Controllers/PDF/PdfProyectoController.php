<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyecto;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\CostoController;

class PdfProyectoController extends Controller
{
    public function __construct(CostoController $costoController)
    {
        $this->costoController = $costoController;
    }

    public function printFormularioCierre($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $costo = $this->costoController->costosDeUnaActividad($proyecto->articulacion_proyecto->actividad->id);
        $pdf = PDF::loadView('pdf.proyecto.form_cierre', ['proyecto' => $proyecto, 'costo' => $costo]);
        return $pdf->stream();
    }

    public function printFormularioAcuerdoDeInicio($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $pdf = PDF::loadView('pdf.proyecto.form_inicio', ['proyecto' => $proyecto]);
        return $pdf->stream();
    }

    public function printCartaCertificacionPbt(Request $request, $id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $dato = explode(',', $request->txtentidad_id);
        $entidad = [];
        if ($dato[1] == 'empresa') {
            $empresa = $proyecto->sedes()->where('sedes.empresa_id', $dato[0])->first();
            $empresa = $empresa->empresa;
            $entidad['nombre'] = $empresa->nombre;
            $entidad['tipo'] = 'Empresa';
            $entidad['codigo'] = $empresa->nit;
        } else {
            $grupo = $proyecto->gruposinvestigacion()->where('gruposinvestigacion.id', $dato[0])->first();
            $entidad['nombre'] = $grupo->entidad->nombre;
            $entidad['tipo'] = 'Grupo';
            $entidad['codigo'] = $grupo->codigo_grupo;
        }

        $pdf = PDF::loadView('pdf.proyecto.carta_certificacion', ['proyecto' => $proyecto, 'request' => $request, 'entidad' => $entidad]);
        return $pdf->stream();
    }

    public function printActaCatergorizacion($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $pdf = PDF::loadView('pdf.proyecto.acta_consultoria', ['proyecto' => $proyecto]);
        return $pdf->stream();
    }
}
