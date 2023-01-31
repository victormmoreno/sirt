<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Support\Facades\Session;
use App\User;

class CostoController extends Controller
{
    /**
     * Index principal para los costos de actividades
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        switch (Session::get('login_role')) {
            case User::IsArticulador():
                abort('403');
                break;
            case User::IsExperto():
                $projects = Proyecto::where('asesor_id', auth()->user()->gestor->id)->get()->pluck('proyecto', 'id');
                break;
            case User::IsDinamizador():
                $projects = Proyecto::with(['articulacion_proyecto.actividad'])->where('nodo_id', auth()->user()->dinamizador->nodo_id)->get()->pluck('articulacion_proyecto.actividad.nombre', 'id');
                break;

            default:
                abort('403');
                break;
        }

        return view('costos.index', [
            'projects' => $projects,
            // 'articulaciones' => $articulaciones
        ]);

    }

    /**
     * Retorna los costos de un proyecto
     *
     * @param int $id Id del proyecto
     * @return Response
     * @author devjul
     */
    public function costoProject($id)
    {
        $proyect = Proyecto::find($id);
        $usos = $proyect->usoinfraestructuras;
        // Costos en pesos
        $costosEquipos = $this->calcularCostosDeEquipos($usos);
        $costosAsesorias = $this->calcularCostosDeAsesorias($usos);
        $costosAdministrativos = $this->calcularCostosAdministrativos($usos);
        $costosMateriales = $this->calcularCostosDeMateriales($usos);
        $costosTotales = $this->calcularCostosTotales($costosEquipos, $costosAsesorias, $costosAdministrativos, $costosMateriales);
        // Tiempos
        $horasEquipos = $this->calcularHorasDeUsoDeEquipos($usos);
        $horasAsesorias = $this->calcularHorasDeAsesorias($usos);

        $expert = $proyect->present()->proyectoUserAsesor();
        $line = $proyect->present()->proyectoLinea();
        $codigo = $proyect->present()->proyectoCode();

        return response()->json([
            'costosEquipos' => $costosEquipos,
            'costosAsesorias' => $costosAsesorias,
            'costosAdministrativos' => $costosAdministrativos,
            'costosMateriales' => $costosMateriales,
            'costosTotales' => $costosTotales,
            'horasEquipos' => $horasEquipos,
            'horasAsesorias' => $horasAsesorias,
            'gestorActividad' => $expert,
            'lineaActividad' => $line,
            'codigoActividad' => $codigo
        ]);
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

        foreach ($datos as  $uso) {
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

        foreach ($datos as  $uso) {
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

        foreach ($datos as $uso) {
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
        foreach ($datos as  $uso) {
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
        foreach ($datos as  $uso) {
            $asesorias += $uso->usogestores->sum('pivot.costo_asesoria');
        }
        return $asesorias;
    }
}
