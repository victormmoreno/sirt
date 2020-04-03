<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Repository\UserRepository\{GestorRepository, UserRepository};
use App\Exports\User\Gestor\GestorUserExport;
use App\User;
use Illuminate\Http\Request;
use App\Repositories\Datatables\UserDatatables;

class GestorController extends Controller
{

    public $userRepository;
    public $gestorRepository;
    public $userdatables;

    public function __construct(UserRepository $userRepository, GestorRepository $gestorRepository, UserDatatables $userdatables)
    {
        $this->middleware('auth');
        $this->userRepository   = $userRepository;
        $this->gestorRepository = $gestorRepository;
        $this->userdatables        = $userdatables;
    }

    /**
     * Consulta los gestores de un nodo y los retorna (principalmente para pintarlos en un select)
     *
     * @param int $id Id del nodo
     * @return array
     * @author dum
     */
    public function getGestorPorNodoSelect($id)
    {
        return response()->json([
            'gestores' => $this->gestorRepository->getAllGestoresPorNodo($id)
                ->orderby('users.created_at', 'desc')
                ->get()
        ]);
    }

    /*=================================================================
    =            metodo para consultar las lineas por nodo            =
    =================================================================*/

    public function getLineaPorNodo($nodo)
    {
        if (request()->ajax()) {
            return response()->json([
                'lineas' => $this->userRepository->getAllLineaNodo($nodo)->lineas->pluck('nombre', 'id'),
            ]);
        }
    }

    /*=====  End of metodo para consultar las lineas por nodo  ======*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('indexGestor', User::class);
        switch (session()->get('login_role')) {
            case User::IsAdministrador():
                return view('users.administrador.gestor.index', [
                    'nodos' => $this->userRepository->getAllNodo(),
                    'view' => 'activos'
                ]);
                break;
            case User::IsDinamizador():
                return view('users.dinamizador.gestor.index', ['view' => 'activos']);
                break;

            default:
                abort('404');
                break;
        }
    }


    public function trash()
    {
        $this->authorize('indexGestor', User::class);
        switch (session()->get('login_role')) {
            case User::IsAdministrador():
                return view('users.administrador.gestor.index', [
                    'nodos' => $this->userRepository->getAllNodo(),
                    'view' => 'inactivos'
                ]);
                break;
            case User::IsDinamizador():
                return view('users.dinamizador.gestor.index', ['view' => 'inactivos']);
                break;

            default:
                abort('404');
                break;
        }
    }

    /*==================================================================
    =            metodop para mostrar los gestores por nodo            =
    ==================================================================*/

    public function getGestor(Request $request, $nodo)
    {

        if (request()->ajax()) {

            $users = $this->gestorRepository->getAllGestoresPorNodo($nodo)
                ->orderby('users.created_at', 'desc')
                ->get();

            return $this->userdatables->datatableUsers($request, $users);
        }
        abort('404');
    }

    /*=====  End of metodop para mostrar los gestores por nodo  ======*/

    public function getGestorTrash(Request $request, $nodo)
    {

        if (request()->ajax()) {

            $users = $this->gestorRepository->getAllGestoresPorNodo($nodo)
                ->onlyTrashed()
                ->orderby('users.created_at', 'desc')
                ->get();

            return $this->userdatables->datatableUsers($request, $users);
        }
        abort('404');
    }

    /*==============================================================================
    =            metodo para mostrar los gestores de un determnado nodo            =
    ==============================================================================*/

    public function getAllGestoresOfNodo(Request $request)
    {
        if (request()->ajax()) {

            if (session()->get('login_role') == User::IsDinamizador()) {
                $users = $this->gestorRepository->getAllGestoresPorNodo(auth()->user()->dinamizador->nodo_id)
                    ->orderby('users.created_at', 'desc')
                    ->get();

                return $this->userdatables->datatableUsers($request, $users);
            }
            abort('404');
        }
        abort('404');
    }

    /*=====  End of metodo para mostrar los gestores de un determnado nodo  ======*/

    public function getAllGestoresOfNodoTrash(Request $request)
    {
        if (request()->ajax()) {

            if (session()->get('login_role') == User::IsDinamizador()) {
                $users = $this->gestorRepository->getAllGestoresPorNodo(auth()->user()->dinamizador->nodo_id)
                    ->onlyTrashed()
                    ->orderby('users.created_at', 'desc')
                    ->get();

                return $this->userdatables->datatableUsers($request, $users);
            }
            abort('404');
        }
        abort('404');
    }

    public function exportGestorUser($state = 1, $nodo = null, $extension = 'xlsx')
    {
        $this->authorize('exportUsersGestor', User::class);
        $user = $this->getData($state, $nodo);
        $this->setQuery($user);
        return (new GestorUserExport($this->getQuery()))->download("Gestores - " . config('app.name') . ".{$extension}");
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
        $role = [User::IsGestor()];

        $relations = [
            'gestor.nodo.entidad' => function ($query) {
                $query->select('id', 'nombre');
            },
            'gestor.nodo.entidad.ciudad' => function ($query) {
                $query->select('id', 'nombre');
            },
            'gestor.nodo.entidad.ciudad.departamento' => function ($query) {
                $query->select('id', 'nombre');
            },
            'gestor.lineatecnologica' => function ($query) {
                $query->select('id', 'nombre', 'abreviatura');
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
                    ->whereHas('gestor.nodo', function ($query) use ($nodo) {
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
                    ->whereHas('gestor.nodo', function ($query) use ($nodo) {
                        $query->where('id', $nodo);
                    })->onlyTrashed()
                    ->get();
            }
            return $this->userRepository->userInfoWithRelations($role, $relations)
                ->where('estado', $state)->onlyTrashed()->get();
        }
    }
}
