<?php

namespace App\Http\Controllers\Excel;

use App\Exports\Proyectos\ProyectoTrazabilidadExport;
use App\Repositories\Repository\ProyectoRepository;
use App\Http\Controllers\Controller;
use App\Models\Actividad;
use Excel;

class ProyectoController extends Controller
{
    private $query;
    private $proyectoRepository;

    public function __construct(ProyectoRepository $proyectoRepository)
    {
        $this->proyectoRepository = $proyectoRepository;
    }

    public function exportTrazabilidadProyecto(int $id)
    {
        $historial = Actividad::consultarHistoricoActividad($id)->get();
        $proyecto = Actividad::find($id);
        $proyecto = $proyecto->articulacion_proyecto->proyecto;
        return Excel::download(new ProyectoTrazabilidadExport($historial, $proyecto), 'Trazabalidad '.$proyecto->articulacion_proyecto->actividad->codigo_actividad.'.xlsx');
    }

}
