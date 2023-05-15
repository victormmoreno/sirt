<?php

namespace App\Http\Controllers\Excel;

use App\Exports\Nodo\NodoExport;
use App\Models\Nodo;
use App\User;
use App\Exports\Nodo\{NodoShowExport};
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
     * @return Response
     */
    public function exportQueryForNodo($nodo)
    {
        $node = $this->getNodoRepository()->findNodoForShow($nodo);
        if(request()->user()->cannot('downloadOne', $node)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->back();
        }
        $users = User::query()
        ->userQuery()
        ->selectRaw("if(roles.name = 'dinamizador', entidaddinamizador.nombre, if(roles.name = 'experto', entidadexperto.nombre, if(roles.name = 'articulador', entidadusernodo.nombre, if(roles.name = 'apoyo técnico', entidadusernodo.nombre, if(roles.name = 'infocenter', entidadinfocenter.nombre, if(roles.name = 'ingreso', entidadingreso.nombre, 'No Aplica')))))) as nodo")
        ->selectRaw("if(roles.name = 'experto', lineastecnologicas.nombre, 'No Aplica') as linea")
        ->selectRaw('roles.name as role, users.documento, users.nombres, users.apellidos, users.email, if(users.telefono!=null,users.telefono, "No registra") as telefono, users.celular')
        ->whereIn("roles.name", ['dinamizador', 'experto', 'articulador', 'apoyo técnico', 'infocenter','ingreso'])
        ->where(function($query){
            $query->where("users.estado", User::IsActive())
            ->whereNull("users.deleted_at");
        })
        ->where(function($query) use($node){
            if(isset($node)){
                $query->where('nodoexperto.id', $node->id)
                ->orWhere('nodoinfocenter.id', $node->id)
                ->orWhere('nodoingreso.id', $node->id)
                ->orWhere('user_nodo.nodo_id', $node->id);
            }
            $query;
        })
        ->groupBy("users.id", "linea")
        ->orderBy("roles.name", "ASC")
        ->get();
        return Excel::download(new NodoShowExport($users), "Tecnoparque {$node->entidad->nombre}" . '.xlsx');
    }
}
