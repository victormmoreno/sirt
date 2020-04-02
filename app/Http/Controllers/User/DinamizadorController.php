<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Repository\UserRepository\DinamizadorRepository;
use App\Repositories\Repository\UserRepository\UserRepository;
use App\Exports\User\Dinamizador\DinamizadorUserExport;
use App\User;
use Illuminate\Http\Request;
use App\Repositories\Datatables\UserDatatables;

class DinamizadorController extends Controller
{

    public $dinamizadorRepository;
    public $userRepository;
    public $userdatables;

    public function __construct(DinamizadorRepository $dinamizadorRepository, UserRepository $userRepository, UserDatatables $userdatables)
    {
        $this->middleware('auth');
        $this->dinamizadorRepository = $dinamizadorRepository;
        $this->userRepository        = $userRepository;
        $this->userdatables        = $userdatables;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('indexDinamizador', User::class);
        switch (session()->get('login_role')) {
            case User::IsAdministrador():
                return view('users.administrador.dinamizador.index', [
                    'nodos' => $this->userRepository->getAllNodos(),
                    'view' => 'activos'
                ]);
                break;

            default:
                abort('404');
                break;
        }
    }

    public function getDinanizador(Request $request, $nodo)
    {
        $this->authorize('indexDinamizador', User::class);

        if (request()->ajax()) {
            $users = $this->dinamizadorRepository->getAllDinamizadoresPorNodo($nodo)
                ->orderby('users.created_at', 'desc')
                ->get();

            return $this->userdatables->datatableUsers($request, $users);
        }

        abort('404');
    }

    public function getDinanizadorTrash(Request $request, $nodo)
    {
        $this->authorize('indexDinamizador', User::class);

        if (request()->ajax()) {
            $users = $this->dinamizadorRepository->getAllDinamizadoresPorNodo($nodo)
                ->onlyTrashed()
                ->orderby('users.created_at', 'desc')
                ->get();

            return $this->userdatables->datatableUsers($request, $users);
        }

        abort('404');
    }




    public function trash(Request $request)
    {
        $this->authorize('indexDinamizador', User::class);
        switch (session()->get('login_role')) {
            case User::IsAdministrador():


                return view('users.administrador.dinamizador.index', [
                    'view' => 'inactivos',
                    'nodos' => $this->userRepository->getAllNodos(),
                ]);
                break;
            default:
                abort('404');
                break;
        }
    }

    public function exportDinamizadorUser($state = 1, $nodo = null, $extension = 'xlsx')
    {
        $this->authorize('exportAdminUser', User::class);
        $user = $this->getData($state, $nodo);
        $this->setQuery($user);
        return (new DinamizadorUserExport($this->getQuery()))->download("Dinamizadores - " . config('app.name') . ".{$extension}");
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
        $role = [User::IsDinamizador()];

        $relations = [
            'dinamizador.nodo.entidad' => function ($query) {
                $query->select('id', 'nombre');
            },
            'dinamizador.nodo.entidad.ciudad' => function ($query) {
                $query->select('id', 'nombre');
            },
            'dinamizador.nodo.entidad.ciudad.departamento' => function ($query) {
                $query->select('id', 'nombre');
            },
            'tipodocumento'                 => function ($query) {
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
        if ($state == null && $nodo == null) {
            return $this->userRepository->userInfoWithRelations($role, $relations)->get();
        } elseif ($state == 1) {
            if ($nodo !== null) {
                return $this->userRepository->userInfoWithRelations($role, $relations)
                    ->whereHas('dinamizador.nodo', function ($query) use ($nodo) {
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
                    ->whereHas('dinamizador.nodo', function ($query) use ($nodo) {
                        $query->where('id', $nodo);
                    })->onlyTrashed()
                    ->get();
            }
            return $this->userRepository->userInfoWithRelations($role, $relations)
                ->where('estado', $state)->onlyTrashed()->get();
        }
    }
}
