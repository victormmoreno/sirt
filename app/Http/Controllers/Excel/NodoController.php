<?php

namespace App\Http\Controllers\Excel;

use App\Exports\Nodo\NodoExport;
use App\Models\Nodo;
use App\Exports\Nodo\{NodoInfoExport};
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Repositories\Repository\NodoRepository;

class NodoController extends Controller
{
    private $query;
    private $nodoRepository;

    public function __construct(NodoRepository $nodoRepository)
    {
        $this->setNodoRepository($nodoRepository);
    }

    /**
     * Asigna un valor a $nodoRepository
     *
     * @param object $nodoRepository
     * @return void
     * @author devjul
     */
    private function setNodoRepository($nodoRepository)
    {
        $this->nodoRepository = $nodoRepository;
    }

    /**
     * Retorna el valor de $nodoRepository
     *
     * @return object
     * @author devjul
     */
    private function getNodoRepository()
    {
        return $this->nodoRepository;
    }

    /**
     * Asgina un valor a $query
     *
     * @param Collection $query
     * @return void
     * @author dum
     */
    private function setQuery($query)
    {
        $this->query = $query;
    }

    /**
     * Retorna el valor de $query
     *
     * @return Collection
     * @author dum
     */
    private function getQuery()
    {
        return $this->query;
    }

    /**
     * Genera el excel de todos los nodos
     *
     * @author devjul
     * @return Response
     */
    public function exportQueryAllNodo()
    {
        if(request()->user()->can('downloadAll', Nodo::class))
        {
            $query = $this->getNodoRepository()->getTeamTecnoparque()->get();
            $this->setQuery($query);
            return Excel::download(new NodoExport($this->getQuery()), 'Nodos ' . config('app.name') . '.xlsx');
        }
        alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
        return redirect()->back();
    }

    /**
     * Genera el excel de todos los nodos
     *
     * @param string $id Id del nodo
     * @param string $anho Año para realizar el filtro
     * @return Response
     */
    public function exportQueryForNodo($nodo)
    {
        $query = $this->getNodoRepository()->findNodoForShow($nodo);
        if(request()->user()->can('downloadOne', $query)) {
            $queryLineas = $query->lineas;
            $queryDinamizadores = $query->dinamizador->where('user.estado', 1)->where('user.deleted_at', null)->values()->all();
            $queryInfocenters = $query->infocenter->where('user.estado', 1)->where('user.deleted_at', null)->values()->all();
            $queryIngresos = $query->ingresos->where('user.estado', 1)->where('user.deleted_at', null)->values()->all();
            $queryGestores = $query->gestores->where('user.estado', 1)->where('user.deleted_at', null)
                ->values()
                ->all();
            return Excel::download(new NodoInfoExport($query, $queryDinamizadores, $queryGestores, $queryInfocenters, $queryIngresos, $queryLineas), 'Tecnoparque Nodo ' . $query->entidad->nombre . '.xlsx');
        }
        alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
        return redirect()->back();

    }
}
