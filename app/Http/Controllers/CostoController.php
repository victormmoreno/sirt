<?php

namespace App\Http\Controllers;

use App\Models\{Actividad};
use App\Repositories\Repository\{ActividadRepository, ProyectoRepository};
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\User;

class CostoController extends Controller
{

  /**
   * Objeto para la clase ActividadRepository
   *
   * @var ActividadRepository
   */
  private $actividadRepository;

  /**
   * Objeto para la clase ProyectoRepository
   *
   * @var ProyectoRepository
   */
  private $proyectoRepository;

  public function __construct(ActividadRepository $actividadRepository, ProyectoRepository $proyectoRepository) {
    $this->setActividadRepository($actividadRepository);
    $this->setProyectoRepository($proyectoRepository);
  }

  /**
  * Index principal para los costos de actividades
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    if ( Session::get('login_role') == User::IsGestor() ) {
      $actividades = Actividad::ConsultarActividades()->where('gestor_id', auth()->user()->gestor->id)->get()->pluck('proyecto', 'id');
      return view('costos.gestor.index', [
        'actividades' => $actividades
      ]);
    } else if ( Session::get('login_role') == User::IsDinamizador() ) {
      $actividades = Actividad::ConsultarActividades()->where('nodo_id', auth()->user()->dinamizador->nodo_id)->get()->pluck('proyecto', 'id');
      return view('costos.dinamizador.index', [
        'actividades' => $actividades
      ]);
    } else {
      abort('403');
    }
  }

  /**
   * Retorna los costos de un proyecto
   *
   * @param int $id Id de la actividad
   * @return Response
   * @author dum
   */
  public function costosDeUnaActividad($id)
  {
    // Actividad
    $actividad = $this->getActividadRepository()->getActividad_Repository($id);
    // Usos de infraestructuras de la actividad
    $usos = $actividad->usoinfraestructuras;
    // Costos en pesos
    $costosEquipos = $this->calcularCostosDeEquipos($usos);
    $costosAsesorias = $this->calcularCostosDeAsesorias($usos);
    $costosAdministrativos = $this->calcularCostosAdministrativos($usos);
    $costosMateriales = $this->calcularCostosDeMateriales($usos);
    $costosTotales = $this->calcularCostosTotales($costosEquipos, $costosAsesorias, $costosAdministrativos, $costosMateriales);
    // Tiempos
    $horasEquipos = $this->calcularHorasDeUsoDeEquipos($usos);
    $horasAsesorias = $this->calcularHorasDeAsesorias($usos);
    // Gestor
    $gestor = $this->getGestorActividad($actividad);
    // Linea
    $linea = $this->getLineaActividad($actividad);
    // C贸digo
    $codigo = $this->getCodigoActividad($actividad);

    return response()->json([
      'costosEquipos' => $costosEquipos,
      'costosAsesorias' => $costosAsesorias,
      'costosAdministrativos' => $costosAdministrativos,
      'costosMateriales' => $costosMateriales,
      'costosTotales' => $costosTotales,
      'horasEquipos' => $horasEquipos,
      'horasAsesorias' => $horasAsesorias,
      'gestorActividad' => $gestor,
      'lineaActividad' => $linea,
      'codigoActividad' => $codigo
    ]);
  }

  /**
  * Obtiene el c贸digo de la actividad
  *
  * @param Collection $actividad
  * @return string
  * @author dum
  */
  private function getCodigoActividad($actividad)
  {
    return $actividad->codigo_actividad;
  }

  /**
  * Obtiene la linea del gestor a cargo de la actividad
  *
  * @param Collection $actividad
  * @return string
  * @author dum
  */
  private function getLineaActividad($actividad)
  {
    return $actividad->gestor->lineatecnologica->nombre;
  }

  /**
  * Obtiene el nombre del gestor a cargo de la actividad
  *
  * @param Collection $actividad
  * @return string
  * @author dum
  */
  private function getGestorActividad($actividad)
  {
    return $actividad->gestor->user()->withTrashed()->first()->nombres . " " . $actividad->gestor->user()->withTrashed()->first()->apellidos;
  }

  /**
  * Calcula las horas de asesorias de un proyecto
  *
  * @param Collection $datos
  * @return int
  * @author dum
  */
  private function calcularHorasDeAsesorias($datos)
  {
    $horasAsesorias = 0;

    foreach ($datos as $key => $uso) {
      $horasAsesorias += $uso->usogestores->sum('pivot.asesoria_directa') + $uso->usogestores->sum('pivot.asesoria_indirecta');
    }

    return $horasAsesorias;
  }

  /**
  * Calcula las horas de uso de equipos
  *
  * @param Collection $datos
  * @return int
  * @author dum
  */
  private function calcularHorasDeUsoDeEquipos($datos)
  {
    $horasEquipos = 0;

    foreach ($datos as $key => $uso) {
      $horasEquipos += $uso->usoequipos->sum('pivot.tiempo');
    }

    return $horasEquipos;
  }

  /**
  * Calcula el costo total
  *
  * @param double $equipos Costos de equipos
  * @param double $asesorias Costos de asesorias
  * @param double $administrativos Costos administrativos
  * @return double
  * @author dum
  */
  public function calcularCostosTotales($equipos, $asesorias, $administrativos, $materiales)
  {
    $totales = 0;
    $totales = $equipos + $asesorias + $administrativos + $materiales;
    return $totales;
  }

  /**
  * Calcula los costos de materiales
  *
  * @param Collection $datos
  * @return double
  * @author dum
  */
  public function calcularCostosDeMateriales($datos)
  {
    $materiales = 0;

    foreach ($datos as $key => $uso) {
      $materiales += $uso->usomateriales->sum('pivot.costo_material');
    }

    return $materiales;

  }

  /**
  * Calcula los costos administrativos
  *
  * @param Collection $datos
  * @return double
  * @author dum
  */
  public function calcularCostosAdministrativos($datos)
  {
    $administrativos = 0;

    foreach ($datos as $key => $uso) {
      $administrativos += $uso->usoequipos->sum('pivot.costo_administrativo');
    }

    return $administrativos;
  }

  /**
  * Calcula los costos de equipos
  *
  * @param Collection $datos
  * @return double
  * @author dum
  */
  public function calcularCostosDeEquipos($datos) {
    $equipos = 0;
    foreach ($datos as $key => $uso) {
      $equipos += $uso->usoequipos->sum('pivot.costo_equipo');
    }

    return $equipos;
  }

  /**
  * Calcula los costos de asesorias
  *
  * @param Collection @datos
  * @return double
  * @author dum
  */
  public function calcularCostosDeAsesorias($datos)
  {
    $asesorias = 0;
    foreach ($datos as $key => $uso) {
      $asesorias += $uso->usogestores->sum('pivot.costo_asesoria');
    }

    return $asesorias;
  }

  /**
   * Asigna un valor a $actividadRepository
   *
   * @param ActividadRepository
   * @return void
   * @author dum
   */
   private function setActividadRepository(ActividadRepository $actividadRepository)
  {
    $this->actividadRepository = $actividadRepository;
  }

  /**
   * Retorna el valor de $actividadRepository
   *
   * @return ActividadRepository
   * @author dum
   */
  public function getActividadRepository()
  {
    return $this->actividadRepository;
  }

  /**
   * Asigna un valor a $proyectoRepository
   *
   * @param ProyectoRepository
   * @return void
   * @author dum
   */
   private function setProyectoRepository(ProyectoRepository $proyectoRepository)
  {
    $this->proyectoRepository = $proyectoRepository;
  }

  /**
   * Retorna el valor de $proyectoRepository
   *
   * @return ProyectoRepository
   * @author dum
   */
  public function getProyectoRepository()
  {
    return $this->proyectoRepository;
  }

}
