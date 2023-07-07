<?php

namespace App\Http\Controllers\Excel;

use App\Repositories\Repository\{ProyectoRepository};
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Models\{Proyecto};
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Proyectos\{ProyectosExport};
use Carbon\Carbon;
use Illuminate\Support\Str;

class SeguimientoController extends Controller
{

    private $proyectoRepository;
    private $year_now;

    public function __construct(ProyectoRepository $proyectoRepository)
    {
        $this->proyectoRepository = $proyectoRepository;
    }

    /**
     * Exporta el archivo con el seguimiento de un nodo/experto
     *
     * @param Request $request
     * @return Excel
     * @author dum
     **/
    public function download_seguimiento(Request $request)
    {
        try {
            $query = null;
            $query = $this->getSeguimiento($request);
            return $this->generarExcel($query);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Retornar la consulta que se exportará
     *
     * @param Request $request
     * @return Builder
     * @author dum
     **/
    public function getSeguimiento($request)
    {
        $abiertos = $this->seguimientoActivos()->get();
        $cerrados = $this->seguimientoCerrados()->get();
        $merged = $abiertos->merge($cerrados);
        return $merged;
    }

    /**
     * Genera el código del archivo de excel
     *
     * @param $query
     * @return Excel
     * @author dum
     **/
    public function generarExcel($query)
    {
        return Excel::download(new ProyectosExport($query), 'file.xlsx');
    }

    /**
     * Agregar la condición para mostrar proyectos cerrados
     *
     * @param Request $request
     * @param Builder $query
     * @return Builder
     * @author dum
     **/
    public function seguimientoCerrados()
    {
        $query = $this->proyectoRepository->indicadoresProyectos()->where('nodos.id', request()->user()->getNodoUser());
        $query = $this->experto($query);
        return $query->whereIn('fases.nombre', [Proyecto::IsFinalizado(), Proyecto::IsSuspendido()])->whereYear('fecha_cierre', Carbon::now()->isoFormat('YYYY'));
    }

    /**
     * Agregar la condición para mostrar proyectos activos
     *
     * @param Request $request
     * @param Builder $query
     * @return Builder
     * @author dum
     **/
    public function seguimientoActivos()
    {
        $query = $this->proyectoRepository->indicadoresProyectos()->where('nodos.id', request()->user()->getNodoUser());
        $query = $this->experto($query);
        return $query->whereIn('fases.nombre', [Proyecto::IsInicio(), Proyecto::IsPlaneacion(), Proyecto::IsEjecucion(), Proyecto::IsCierre()]);
    }

    /**
     * Retorna la condición para los expertos de los que se generarán los indicadores
     *
     * @param Request $request
     * @param Builder $query
     * @return Builder
     * @author dum
     **/
    public function experto($query)
    {
        if (session()->get('login_role') == User::IsExperto()) {
            return $query->where('proyectos.experto_id', request()->user()->id);
        }
        return $query;
    }

}