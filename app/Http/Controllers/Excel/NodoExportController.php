<?php

namespace App\Http\Controllers\Excel;

use App\Exports\Nodo\NodoExport;
use App\Models\Nodo;
use App\User;
use App\Exports\Nodo\{NodoShowExport};
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Repositories\Repository\NodoRepository;

class NodoExportController extends Controller
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
        ->leftJoin('lineastecnologicas', function ($join) {
            $join->on('lineastecnologicas.id', '=', 'user_nodo.linea_id');
        })
        ->select('users.id', 'tiposdocumentos.nombre as tipodocumento',
        'users.documento','users.nombres', 'users.apellidos',
        'users.email','users.celular',
        'users.telefono','users.fechanacimiento',
        'users.created_at', 'users.deleted_at',
        'entidades.nombre as nodo', 'lineastecnologicas.nombre as linea',
        'user_nodo.honorarios')
        ->selectRaw('if(users.genero = 1, "Masculino", if(users.genero = 0, "Femenino", "No binario")) as nombre_genero')
        ->selectRaw('if(users.estado = 1, "Habilidado", "Inhabilitado") as estado')
        ->selectRaw('GROUP_CONCAT(DISTINCT roles.name SEPARATOR "; ") as roles')
        ->selectRaw('if(user_nodo.vinculacion = 0, "Contratista", "Planta") as vinculacion')
        ->where(function($query){
            $query->where("users.estado", User::IsActive())
            ->whereNull("users.deleted_at");
        })
        ->where(function($query){
            $query->whereIn('roles.name', [User::IsDinamizador(), User::IsExperto(), User::IsArticulador(), User::IsInfocenter(), User::IsApoyoTecnico()])
                    ->whereIn('user_nodo.role', [User::IsDinamizador(), User::IsExperto(), User::IsArticulador(), User::IsInfocenter(), User::IsApoyoTecnico()]);
        })
        ->nodoFuncionario($node->id)
        ->groupBy('users.documento')
        ->orderBy("roles.name", "ASC")
        ->get();
        return Excel::download(new NodoShowExport($users), "Tecnoparque {$node->entidad->nombre}" . '.xlsx');
    }
}
