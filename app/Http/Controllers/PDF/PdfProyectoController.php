<?php

namespace App\Http\Controllers\PDF;

use App\Repositories\Repository\ProyectoRepository;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Proyecto, Fase};
use Carbon\Carbon;
use PDF;
use App;

class PdfProyectoController extends Controller
{

  /**
   * Genera el archivo pdf del acuerdo de confidencial y compromiso
   *
   * @param object $proyectoRepository
   * @param string $route Ruta donde se guarda el archivo
   * @param int $id Id del proyecto
   * @return array
   * @author dum
   */
  public static function printAcuerdoConfidencialidadCompromiso(ProyectoRepository $proyectoRepository, $id)
  {
    $proyecto = Proyecto::find($id);
    $talento_lider = $proyectoRepository->consultarTalentoLiderDeUnProyecto($id)->first();
    // dd($talento_lider);
    // exit();
    $gestor = $proyectoRepository->pivotAprobaciones($id)->where('roles.name', 'Gestor')->first();
    // dd($proyecto->articulacion_proyecto->actividad->gestor_id);
    $dinamizador = $proyectoRepository->pivotAprobaciones($id)->where('roles.name', 'Dinamizador')->first();
    $pdf = PDF::loadView('pdf.proyecto.acc', [
      'proyecto' => $proyecto,
      'talento_lider' => $talento_lider,
      'gestor' => $gestor,
      'dinamizador' => $dinamizador
    ]);
    $route = "";
    // Nombre del archivo pdf
    $nombreArchivo = 'Acuerdo de Confidencialidad y Compromiso - ' . $proyecto->articulacion_proyecto->actividad->codigo_actividad . '.pdf';
    // Nodo del gestor a cargo de proyecto
    $nodo = sprintf("%02d", $proyecto->articulacion_proyecto->actividad->gestor->nodo_id);
    // Año de inicio del proyecto
    $anho = Carbon::parse($proyecto->fecha_inicio)->isoFormat('YYYY');
    // Línea del gestor a cargo del proyecto
    $linea = $proyecto->sublinea->lineatecnologica_id;
    // Id del gestor a cargo del proyecto
    $gestor = sprintf("%03d", $proyecto->articulacion_proyecto->actividad->gestor_id);
    // Fase donde se guarda el archivo del proyecto.
    $fase = Fase::select('id', 'nombre')->where('nombre', 'Inicio')->first();
    // Ruta del archivo
    $route = 'public/' . $nodo . '/' . $anho . '/Proyectos' . '/' . $linea . '/' . $gestor . '/' . $id . '/' . $fase->nombre . '/' . $nombreArchivo;
    // Almacena el archivo pdf en el servidor
    Storage::put($route, $pdf->output());
    return [
      'articulacion_proyecto_id' => $proyecto->articulacion_proyecto_id,
      'fase_id' => $fase->id,
      'ruta' => Storage::url($route)
    ];
    // dd(Storage::url($route));
  }

}
