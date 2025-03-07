<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyecto;
use App\Models;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\CostoController;

class PdfProyectoController extends Controller
{
    public $costoController;
    
    public function __construct(CostoController $costoController)
    {
        $this->costoController = $costoController;
    }

    public function formularioDocumento($model, $type, $id) {
        $proyecto = Proyecto::findOrFail($id);
        if(!request()->user()->can('generar_docs', $proyecto)) {
            alert('No autorizado', 'No puedes generar documentos de este proyecto', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        return view('pdf.formulario_actas', [
            'tipo' => $type,
            'model' => $model
        ]);
    }

    public function printFormularioCierre($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        if(!request()->user()->can('generar_docs', $proyecto)) {
            alert('No autorizado', 'No puedes generar documentos de este proyecto', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $costo = $this->costoController->costoProject($proyecto->id);
        $pdf = PDF::loadView('pdf.proyecto.compromiso_cierre', ['proyecto' => $proyecto, 'costo' => $costo]);
        return $pdf->stream();
    }

    public function printFormularioAcuerdoDeInicio($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        if(!request()->user()->can('generar_docs', $proyecto)) {
            alert('No autorizado', 'No puedes generar documentos de este proyecto', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $pdf = PDF::loadView('pdf.proyecto.compromiso_inicio', ['proyecto' => $proyecto]);
        return $pdf->stream();
    }

    public function printCartaCertificacionPbt(Request $request, $id)
    {
        $proyecto = Proyecto::findOrFail($id);
        if(!request()->user()->can('generar_docs', $proyecto)) {
            alert('No autorizado', 'No puedes generar documentos de este proyecto', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
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
        if(!request()->user()->can('generar_docs', $proyecto)) {
            alert('No autorizado', 'No puedes generar documentos de este proyecto', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $pdf = PDF::loadView('pdf.proyecto.acta_categorizacion', ['proyecto' => $proyecto]);
        return $pdf->stream();
    }
}
