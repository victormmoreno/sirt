<?php

namespace App\Http\Controllers\Excel;

use App\Exports\Indicadores\Indicadores2020Export;
use App\Repositories\Repository\{ProyectoRepository};
use Repositories\Repository\NodoRepository;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\User;
use App\Imports\MigracionMetasImport;
use Illuminate\Http\Request;
use App\Models\Proyecto;
use Maatwebsite\Excel\Facades\Excel;

class IndicadorController extends Controller
{

    private $proyectoRepository;
    private $nodoRepository;

    public function __construct(ProyectoRepository $proyectoRepository, NodoRepository $nodoRepository)
    {
        $this->setProyectoRepository($proyectoRepository);
        $this->nodoRepository = $nodoRepository;
    }

    /**
     * Genera excel con el detalle de los proyectos de tecnoparque
     * @param int $idnodo Id del nodo
     * @param string $fecha_inicio Primera fecha para relizar el filtro
     * @param string $fecha_fin Segunda fecha para realizar el filtro
     * @return Response
     * @author dum
     */
    public function exportIndicadores2020($idnodo, string $fecha_inicio, string $fecha_fin, string $hoja = null)
    {
        $query = null;

        if (Session::get('login_role') == User::IsAdministrador()) {

        if ($idnodo == 'all') {
            $query = $this->getProyectoRepository()->proyectosIndicadores_Repository($fecha_inicio, $fecha_fin)->get();
        } else {
            $query = $this->getProyectoRepository()->proyectosIndicadores_Repository($fecha_inicio, $fecha_fin)->whereHas('nodo', function($query) use ($idnodo) {
            $query->where('id', $idnodo);
            })->get();
        }
        } else if (Session::get('login_role') == User::IsDinamizador()) {
            $query = $this->getProyectoRepository()->proyectosIndicadores_Repository($fecha_inicio, $fecha_fin)->whereHas('nodo', function($query) {
                $query->where('id', auth()->user()->dinamizador->nodo_id);
            })->get();
        } else if (Session::get('login_role') == User::IsInfocenter()) {
            $query = $this->getProyectoRepository()->proyectosIndicadores_Repository($fecha_inicio, $fecha_fin)->whereHas('nodo', function($query) {
                $query->where('id', auth()->user()->infocenter->nodo_id);
            })->get();
        } else {
            $query = $this->getProyectoRepository()->proyectosIndicadores_Repository($fecha_inicio, $fecha_fin)->whereHas('asesor', function($query) {
                $query->where('id', auth()->user()->gestor->id);
            })->get();

        }
        return Excel::download(new Indicadores2020Export($query, $hoja), 'Indicadores_'.$fecha_inicio.'_a_'.$fecha_fin.'.xlsx');
    }


    public function exportIndicadoresProyectosFinalizados($idnodo, string $fecha_inicio, string $fecha_fin, string $hoja = null)
    {
        $query = null;

        if (Session::get('login_role') == User::IsAdministrador()) {

        if ($idnodo == 'all') {
            $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('articulacion_proyecto.actividad', function ($query) use ($fecha_inicio, $fecha_fin) {
            $query->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin]);
            })
            ->whereHas('fase', function ($query) {
            $query->whereIn('nombre', ['Finalizado', 'Suspendido']);
            })->get();
        } else {
            $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('articulacion_proyecto.actividad', function ($query) use ($fecha_inicio, $fecha_fin) {
            $query->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin]);
            })
            ->whereHas('fase', function ($query) {
            $query->whereIn('nombre', ['Finalizado', 'Suspendido']);
            })->whereHas('nodo', function($query) use ($idnodo) {
            $query->where('id', $idnodo);
            })->get();
        }
        } else if (Session::get('login_role') == User::IsDinamizador()) {
        $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('articulacion_proyecto.actividad', function ($query) use ($fecha_inicio, $fecha_fin) {
            $query->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin]);
        })
        ->whereHas('fase', function ($query) {
            $query->whereIn('nombre', ['Finalizado', 'Suspendido']);
        })->whereHas('nodo', function($query) {
            $query->where('id', auth()->user()->dinamizador->nodo_id);
        })->get();
        } else if (Session::get('login_role') == User::IsInfocenter()) {
        $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('articulacion_proyecto.actividad', function ($query) use ($fecha_inicio, $fecha_fin) {
            $query->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin]);
        })
        ->whereHas('fase', function ($query) {
            $query->whereIn('nombre', ['Finalizado', 'Suspendido']);
        })->whereHas('nodo', function($query) {
            $query->where('id', auth()->user()->infocenter->nodo_id);
        })->get();
        } else {
        $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('articulacion_proyecto.actividad', function ($query) use ($fecha_inicio, $fecha_fin) {
            $query->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin]);
        })
        ->whereHas('fase', function ($query) {
            $query->whereIn('nombre', ['Finalizado', 'Suspendido']);
        })->whereHas('asesor', function($query) {
            $query->where('id', auth()->user()->gestor->id);
        })->get();
        }
        return Excel::download(new Indicadores2020Export($query, $hoja), 'Indicadores_Finalizados_'.$fecha_inicio.'_a_'.$fecha_fin.'.xlsx');
    }

    public function exportIndicadoresProyectosInscritos($idnodo, string $fecha_inicio, string $fecha_fin, string $hoja = null)
    {
        $query = null;

        if (Session::get('login_role') == User::IsAdministrador()) {

        if ($idnodo == 'all') {
            $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('articulacion_proyecto.actividad', function ($query) use ($fecha_inicio, $fecha_fin) {
            $query->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin]);
            })->get();
        } else {
            $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('articulacion_proyecto.actividad', function ($query) use ($fecha_inicio, $fecha_fin) {
            $query->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin]);
            })->whereHas('nodo', function($query) use ($idnodo) {
            $query->where('id', $idnodo);
            })->get();
        }
        } else if (Session::get('login_role') == User::IsDinamizador()) {
        $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('articulacion_proyecto.actividad', function ($query) use ($fecha_inicio, $fecha_fin) {
            $query->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin]);
        })->whereHas('nodo', function($query) {
            $query->where('id', auth()->user()->dinamizador->nodo_id);
        })->get();
        } else if (Session::get('login_role') == User::IsInfocenter()) {
        $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('articulacion_proyecto.actividad', function ($query) use ($fecha_inicio, $fecha_fin) {
            $query->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin]);
        })->whereHas('nodo', function($query) {
            $query->where('id', auth()->user()->infocenter->nodo_id);
        })->get();
        } else {
        $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('articulacion_proyecto.actividad', function ($query) use ($fecha_inicio, $fecha_fin) {
            $query->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin]);
        })->whereHas('asesor', function($query) {
            $query->where('id', auth()->user()->gestor->id);
        })->get();
        }
        return Excel::download(new Indicadores2020Export($query, $hoja), 'Indicadores_Inscritos_'.$fecha_inicio.'_a_'.$fecha_fin.'.xlsx');
    }

    public function exportIndicadoresProyectosActuales($idnodo, string $hoja = null)
    {
        $query = null;

        if (Session::get('login_role') == User::IsAdministrador()) {

        if ($idnodo == 'all') {
            $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('fase', function ($query) {
            $query->whereIn('nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre']);
            })->get();
        } else {
            $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('fase', function ($query) {
            $query->whereIn('nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre']);
            })->whereHas('nodo', function($query) use ($idnodo) {
            $query->where('id', $idnodo);
            })->get();
        }
        } else if (Session::get('login_role') == User::IsDinamizador()) {
        $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('fase', function ($query) {
            $query->whereIn('nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre']);
        })->whereHas('nodo', function($query) {
            $query->where('id', auth()->user()->dinamizador->nodo_id);
        })->get();
        } else if (Session::get('login_role') == User::IsInfocenter()) {
        $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('fase', function ($query) {
            $query->whereIn('nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre']);
        })->whereHas('nodo', function($query) {
            $query->where('id', auth()->user()->infocenter->nodo_id);
        })->get();
        } else {
        $query = $this->getProyectoRepository()->proyectosIndicadoresSeparados_Repository()->whereHas('fase', function ($query) {
            $query->whereIn('nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre']);
        })->whereHas('asesor', function($query) {
            $query->where('id', auth()->user()->gestor->id);
        })->get();
        }
        return Excel::download(new Indicadores2020Export($query, $hoja), 'Indicadores_Actuales.xlsx');
    }

    public function importIndicadoresAll(Request $request)
    {
        session()->put('errorMigracion', null);
        Excel::import(new MigracionMetasImport(), $request->file('nombreArchivo'));
        if (Session::get('errorMigracion') == null) {
            alert()->success('Migración Exitosa!', 'La información se ha migrado exitósamente!')->showConfirmButton('Ok', '#3085d6');
        } else {
            alert()->error('Migración Errónea!', Session::get('errorMigracion'))->showConfirmButton('Ok', '#3085d6');
        }
        session()->put('errorMigracion', null);
        return back();
    }

    public function downloadMetas(Request $request)
    {
        $query = null;
        $metas = $this->nodoRepository->consultarMetasDeTecnoparque($request->txtnodo_metas_id)->get();
        // dd($metas);
        // dd($metas);
    }

    private function setProyectoRepository($proyectoRepository)
    {
        $this->proyectoRepository = $proyectoRepository;
    }

    private function getProyectoRepository()
    {
        return $this->proyectoRepository;
    }

}
