<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Repository\UserRepository\{IngresoRepository, UserRepository};
use App\Exports\User\Ingreso\IngresoUserExport;
use App\User;
use Illuminate\Http\Request;
use App\Repositories\Datatables\UserDatatables;

class IngresoController extends Controller
{

    protected $ingresoRepository;
    protected $userRepository;
    public $userdatables;

    public function __construct(IngresoRepository $ingresoRepository, UserRepository $userRepository, UserDatatables $userdatables)
    {
        $this->middleware('auth');
        $this->ingresoRepository = $ingresoRepository;
        $this->userRepository    = $userRepository;
        $this->userdatables        = $userdatables;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('indexIngreso', User::class);
        switch (session()->get('login_role')) {
            case User::IsAdministrador():
                return view('users.administrador.ingreso.index', [
                    'nodos' => $this->userRepository->getAllNodo(),
                    'view' => 'activos'
                ]);
                break;
            case User::IsDinamizador():
                return view('users.dinamizador.ingreso.index', ['view' => 'activos']);
                break;

            default:
                abort('404');
                break;
        }
    }

    public function trash()
    {
        // $this->authorize('indexIngreso', User::class);
        switch (session()->get('login_role')) {
            case User::IsAdministrador():
                return view('users.administrador.ingreso.index', [
                    'nodos' => $this->userRepository->getAllNodo(),
                    'view' => 'inactivos'
                ]);
                break;
            case User::IsDinamizador():
                return view('users.dinamizador.ingreso.index', ['view' => 'inactivos']);
                break;

            default:
                abort('404');
                break;
        }
    }

    /*=================================================================================
    =            metodo para mostrar los usuarios ingreso en el datatables            =
    =================================================================================*/


    public function getIngresoForNodo(Request $request, $nodo)
    {

        if (request()->ajax()) {
            $users = $this->ingresoRepository->getAllUsersIngresoForNodo($nodo)
                ->orderby('users.created_at', 'desc')
                ->get();

            return $this->userdatables->datatableUsers($request, $users);
        }
        abort('404');
    }

    /*=====  End of metodo para mostrar los usuarios ingreso en el datatables  ======*/


    public function getIngresoForNodoTrash(Request $request, $nodo)
    {

        if (request()->ajax()) {
            $users = $this->ingresoRepository->getAllUsersIngresoForNodo($nodo)
                ->onlyTrashed()
                ->orderby('users.created_at', 'desc')
                ->get();

            return $this->userdatables->datatableUsers($request, $users);
        }
        abort('404');
    }

    /*=======================================================================================
    =            metodo para mostrar todos los usuarios ingreso de determinado nodo            =
    =======================================================================================*/

    public function getAllIngresoOfNodo(Request $request)
    {

        if (request()->ajax()) {
            if (session()->get('login_role') == User::IsDinamizador()) {
                $users = $this->ingresoRepository->getAllUsersIngresoForNodo(auth()->user()->dinamizador->nodo_id)->get();
                return $this->userdatables->datatableUsers($request, $users);
            }
            abort('404');
        }
        abort('404');
    }

    /*=====  End of metodo para mostrar todos los usuarios ingreso de determinado nodo  ======*/

    public function getAllIngresoOfNodoTrash(Request $request)
    {

        if (request()->ajax()) {
            if (session()->get('login_role') == User::IsDinamizador()) {
                $users = $this->ingresoRepository->getAllUsersIngresoForNodo(auth()->user()->dinamizador->nodo_id)
                    ->onlyTrashed()
                    ->get();
                return $this->userdatables->datatableUsers($request, $users);
            }
            abort('404');
        }
        abort('404');
    }

    public function exportIngresoUser($state = 1, $nodo = null, $extension = 'xlsx')
    {
        $this->authorize('exportUsersIngreso', User::class);
        $user = $this->getData($state, $nodo);
        $this->setQuery($user);
        return (new IngresoUserExport($this->getQuery()))->download("Ingreso - " . config('app.name') . ".{$extension}");
    }

    private function setQuery($query)
    {
        $this->query = $query;
    }

    /**
     * Retorna el valor de $query
     * @return object
     * @author dum
     */
    private function getQuery()
    {
        return $this->query;
    }

    /**
     * retorna consulta de administradores
     * @return collection
     * @author dum
     */
    private function getData($state = null, $nodo = null)
    {
        $role = [User::IsIngreso()];

        $relations = [
            'ingreso.nodo.entidad' => function ($query) {
                $query->select('id', 'nombre');
            },
            'ingreso.nodo.entidad.ciudad' => function ($query) {
                $query->select('id', 'nombre');
            },
            'ingreso.nodo.entidad.ciudad.departamento' => function ($query) {
                $query->select('id', 'nombre');
            },

            'tipodocumento'                 => function ($query) {
                $query->select('id', 'nombre');
            },
            'gradoescolaridad'              => function ($query) {
                $query->select('id', 'nombre');
            },
            'gruposanguineo'                => function ($query) {
                $query->select('id', 'nombre');
            },
            'eps'                           => function ($query) {
                $query->select('id', 'nombre');
            },
            'ciudad'                        => function ($query) {
                $query->select('id', 'nombre', 'departamento_id');
            },
            'ciudad.departamento'           => function ($query) {
                $query->select('id', 'nombre');
            },
            'ciudadexpedicion'              => function ($query) {
                $query->select('id', 'nombre', 'departamento_id');
            },
            'ciudadexpedicion.departamento' => function ($query) {
                $query->select('id', 'nombre');
            },
            'ocupaciones',
        ];
        if (session()->get('login_role') == User::IsDinamizador()) {
            $nodo = auth()->user()->dinamizador->nodo->id;
        } elseif (session()->get('login_role') == User::IsGestor()) {
            $nodo = auth()->user()->gestor->nodo->id;
        } elseif (session()->get('login_role') == User::IsInfocenter()) {
            $nodo = auth()->user()->infocenter->nodo->id;
        }


        if ($state == null && $nodo == null) {
            return $this->userRepository->userInfoWithRelations($role, $relations)->get();
        } elseif ($state == 1) {
            if ($nodo !== null) {
                return $this->userRepository->userInfoWithRelations($role, $relations)
                    ->whereHas('ingreso.nodo', function ($query) use ($nodo) {
                        $query->where('id', $nodo);
                    })
                    ->where('estado', $state)->get();
            }
            return $this->userRepository->userInfoWithRelations($role, $relations)
                ->where('estado', $state)->get();
        } elseif ($state == 0) {
            if ($nodo !== null) {
                return $this->userRepository->userInfoWithRelations($role, $relations)
                    ->where('estado', $state)
                    ->whereHas('ingreso.nodo', function ($query) use ($nodo) {
                        $query->where('id', $nodo);
                    })->onlyTrashed()
                    ->get();
            }
            return $this->userRepository->userInfoWithRelations($role, $relations)
                ->where('estado', $state)->onlyTrashed()->get();
        }
    }
}
