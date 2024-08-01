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
        if($model == class_basename(Proyecto::class)){
            $data = Proyecto::findOrFail($id);
        }elseif($model == class_basename(Articulation::class)){
            $data = Articulation::findOrFail($id);
        }
        else{
            alert('No autorizado', 'No puedes generar documentos', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }

        if(!request()->user()->can('generar_docs', $data)) {
            alert('No autorizado', 'No puedes generar documentos', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        return view('pdf.formulario_actas', [
            'tipo' => $type,
            'model' => $model,
            'data' => $data
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
                if(!request()->user()->can('generar_docs', $data)) {
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

}
