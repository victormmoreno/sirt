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
        $node = $this->getNodoRepository()->findNodoForShow($nodo);
        if(request()->user()->cannot('downloadOne', $node)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->back();
        }

        $users = User::query()

        ->leftJoin("tiposdocumentos", function($join){
            $join->on("tiposdocumentos.id", "=", "users.tipodocumento_id");
        })
        ->leftJoin("ciudades as ciudadexp", function($join){
            $join->on("ciudadexp.id", "=", "users.ciudad_expedicion_id");
        })
        ->leftJoin("departamentos as depexp", function($join){
            $join->on("depexp.id", "=", "ciudadexp.departamento_id");
        })
        ->leftJoin("gruposanguineos as grupsa", function($join){
            $join->on("grupsa.id", "=", "users.gruposanguineo_id");
        })
        ->leftJoin("eps", function($join){
            $join->on("eps.id", "=", "users.eps_id");
        })
        ->leftJoin("etnias", function($join){
            $join->on("etnias.id", "=", "users.etnia_id");
        })
        ->leftJoin("ciudades", function($join){
            $join->on("ciudades.id", "=", "users.ciudad_id");
        })
        ->leftJoin("departamentos as depres", function($join){
            $join->on("depres.id", "=", "ciudades.departamento_id");
        })
        ->leftJoin("gradosescolaridad", function($join){
            $join->on("gradosescolaridad.id", "=", "users.gradoescolaridad_id");
        })
        ->leftJoin("ocupaciones_users", function($join){
            $join->on("ocupaciones_users.user_id", "=", "users.id");
        })
        ->leftJoin("ocupaciones", function($join){
            $join->on("ocupaciones.id", "=", "ocupaciones_users.ocupacion_id");
        })
        ->leftJoin("dinamizador", function($join){
            $join->on("dinamizador.user_id", "=", "users.id");
        })
        ->leftJoin("nodos as dinanodo", function($join){
            $join->on("dinanodo.id", "=", "dinamizador.nodo_id");
        })
        ->leftJoin("entidades as entidinamizador", function($join){
            $join->on("entidinamizador.id", "=", "dinanodo.entidad_id");
        })
        ->leftJoin("gestores", function($join){
            $join->on("gestores.user_id", "=", "users.id");
        })
        ->leftJoin("nodos as gestornodo", function($join){
            $join->on("gestornodo.id", "=", "gestores.nodo_id");
        })
        ->leftJoin("entidades as entigestor", function($join){
            $join->on("entigestor.id", "=", "gestornodo.entidad_id");
        })
        ->leftJoin("lineastecnologicas", function($join){
            $join->on("lineastecnologicas.id", "=", "gestores.lineatecnologica_id");
        })
        ->leftJoin("user_nodo", function($join){
            $join->on("user_nodo.user_id", "=", "users.id");
        })
        ->leftJoin("nodos as nodocont", function($join){
            $join->on("nodocont.id", "=", "user_nodo.nodo_id");
        })
        ->leftJoin("entidades as enticont", function($join){
            $join->on("enticont.id", "=", "nodocont.entidad_id");
        })
        ->leftJoin("infocenter", function($join){
            $join->on("infocenter.user_id", "=", "users.id");
        })
        ->leftJoin("nodos as infonodo", function($join){
            $join->on("infonodo.id", "=", "infocenter.nodo_id");
        })
        ->leftJoin("entidades as entinfocenter", function($join){
            $join->on("entinfocenter.id", "=", "infonodo.entidad_id");
        })
        ->leftJoin("ingresos", function($join){
            $join->on("ingresos.user_id", "=", "users.id");
        })
        ->leftJoin("nodos as ingresonodo", function($join){
            $join->on("ingresonodo.id", "=", "ingresos.nodo_id");
        })
        ->leftJoin("entidades as entingreso", function($join){
            $join->on("entingreso.id", "=", "ingresonodo.entidad_id");
        })
        ->join("model_has_roles as mr", function($join){
            $join->on("mr.model_id", "=", "users.id");
        })
        ->join("roles", function($join){
            $join->on("roles.id", "=", "mr.role_id");
        })

        ->selectRaw("if(roles.name = 'dinamizador', entidinamizador.nombre, if(roles.name = 'experto', entigestor.nombre, if(roles.name = 'articulador', enticont.nombre, if(roles.name = 'apoyo técnico', enticont.nombre, if(roles.name = 'infocenter', entinfocenter.nombre, if(roles.name = 'ingreso', entingreso.nombre, 'no registra')))))) as nodo")
        ->selectRaw("if(roles.name = 'experto', lineastecnologicas.nombre, 'No Aplica') as linea")
        ->selectRaw('roles.name as role, users.documento, users.nombres, users.apellidos, users.email, if(users.telefono!=null,users.telefono, "No registra") as telefono, users.celular')
        ->whereIn("roles.name", ['dinamizador', 'experto', 'articulador', 'apoyo técnico', 'infocenter','ingreso'])
        ->where(function($query){
            $query->where("users.estado", 1)
            ->whereNull("users.deleted_at");
        })
        ->where(function($query) use($node){
            if(isset($node)){
                $query->where('gestornodo.id', $node->id)
                ->orWhere('infonodo.id', $node->id)
                ->orWhere('ingresonodo.id', $node->id)
                ->orWhere('user_nodo.nodo_id', $node->id);
            }
            $query;
        })
        ->groupBy("users.id", "linea")
        ->orderBy("roles.name", "ASC")
        ->get();




        return Excel::download(new NodoShowExport($users), 'Nodo' . '.xlsx');

    }
}
