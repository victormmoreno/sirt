<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyecto;
use App\Models;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\CostoController;
use App\Models\Articulation;

class PdfController extends Controller
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
            'model' => $model,
            'data' => $proyecto
        ]);
    }

    public function printDocumentoCompromiso(Request $request, $id)
    {
        $data = null;
        switch ($request->hddmodel) {
            case class_basename(Proyecto::class):
                $data = Proyecto::findOrFail($id);
                if(!request()->user()->can('generar_docs', $data)) {
                    alert('No autorizado', 'No puedes generar documentos de este proyecto', 'error')->showConfirmButton('Ok', '#3085d6');
                    return back();
                }
                $pdf = $this->pdfParaProyectos($request, $data);
                break;
            
            case class_basename(Articulation::class):
                $data = Articulation::query()->FindById($id)->first();
                if(!request()->user()->can('downloadCertificateStart', $data)) {
                    alert('No autorizado', 'No puedes generar documentos de esta articulación', 'error')->showConfirmButton('Ok', '#3085d6');
                    return back();
                }
                $pdf = $this->pdfParaArticulaciones($request, $data);
                break;
            default:
                # code...
                break;

        }
        
        return $pdf->stream();
    }

    /**
     * Casos en los que el archivo que se generará es para proyectos
     *
     * @param Request $requesst
     * @param $data
     * @return Response
     * @author dum
     **/
    private function pdfParaProyectos($request, $data)
    {
        switch ($request->hddtipo) {
            case 'inicio':
                return PDF::loadView('pdf.proyecto.compromiso_inicio', [
                    'data' => $data,
                    'request' => $request
                ]);
            break;
            case 'cierre':
                $costo = $this->costoController->costoProject($data->id);
                return PDF::loadView('pdf.proyecto.compromiso_cierre', [
                    'data' => $data,
                    'request' => $request,
                    'costo' => $costo
                ]);
            break;
            
            default:
                abort('404');
            break;
        }
    }

    /**
     * Casos en los que el archivo que se generará es para articulaciones
     *
     * @param Request $requesst
     * @param $data
     * @return Response
     * @author dum
     **/
    private function pdfParaArticulaciones($request, $data)
    {
        switch ($request->hddtipo) {
            case 'inicio':
                return PDF::loadView('pdf.articulation.compromiso_inicio', [
                    'data' => $data,
                    'request' => $request
                ]);
            break;
            case 'cierre':
                // $data = Proyecto::find(15121);
                return PDF::loadView('pdf.articulation.compromiso_cierre', [
                    'data' => $data,
                    'request' => $request
                ]);
            break;
            
            default:
                abort('404');
            break;
        }
    }

    // public function printFormularioCierre($id)
    // {
    //     $proyecto = Proyecto::findOrFail($id);
    //     if(!request()->user()->can('generar_docs', $proyecto)) {
    //         alert('No autorizado', 'No puedes generar documentos de este proyecto', 'error')->showConfirmButton('Ok', '#3085d6');
    //         return back();
    //     }
    //     $costo = $this->costoController->costoProject($proyecto->id);
    //     $pdf = PDF::loadView('pdf.proyecto.compromiso_cierre', ['proyecto' => $proyecto, 'costo' => $costo]);
    //     return $pdf->stream();
    // }

    // public function printCartaCertificacionPbt(Request $request, $id)
    // {
    //     $proyecto = Proyecto::findOrFail($id);
    //     if(!request()->user()->can('generar_docs', $proyecto)) {
    //         alert('No autorizado', 'No puedes generar documentos de este proyecto', 'error')->showConfirmButton('Ok', '#3085d6');
    //         return back();
    //     }
    //     $dato = explode(',', $request->txtentidad_id);
    //     $entidad = [];
    //     if ($dato[1] == 'empresa') {
    //         $empresa = $proyecto->sedes()->where('sedes.empresa_id', $dato[0])->first();
    //         $empresa = $empresa->empresa;
    //         $entidad['nombre'] = $empresa->nombre;
    //         $entidad['tipo'] = 'Empresa';
    //         $entidad['codigo'] = $empresa->nit;
    //     } else {
    //         $grupo = $proyecto->gruposinvestigacion()->where('gruposinvestigacion.id', $dato[0])->first();
    //         $entidad['nombre'] = $grupo->entidad->nombre;
    //         $entidad['tipo'] = 'Grupo';
    //         $entidad['codigo'] = $grupo->codigo_grupo;
    //     }

    //     $pdf = PDF::loadView('pdf.proyecto.carta_certificacion', ['proyecto' => $proyecto, 'request' => $request, 'entidad' => $entidad]);
    //     return $pdf->stream();
    // }

    // public function printActaCatergorizacion($id)
    // {
    //     $proyecto = Proyecto::findOrFail($id);
    //     if(!request()->user()->can('generar_docs', $proyecto)) {
    //         alert('No autorizado', 'No puedes generar documentos de este proyecto', 'error')->showConfirmButton('Ok', '#3085d6');
    //         return back();
    //     }
    //     $pdf = PDF::loadView('pdf.proyecto.acta_categorizacion', ['proyecto' => $proyecto]);
    //     return $pdf->stream();
    // }
}
