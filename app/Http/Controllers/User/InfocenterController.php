<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Repository\UserRepository\{InfocenterRepository, UserRepository};
use App\Exports\User\Infocenter\InfocenterUserExport;
use App\User;
use Illuminate\Http\Request;
use App\Repositories\Datatables\UserDatatables;

class InfocenterController extends Controller
{

    protected $userRepository;
    protected $infocenterRepository;
    public $userdatables;

    public function __construct(UserRepository $userRepository, InfocenterRepository $infocenterRepository, UserDatatables $userdatables)
    {
        $this->middleware('auth');
        $this->userRepository       = $userRepository;
        $this->infocenterRepository = $infocenterRepository;
        $this->userdatables        = $userdatables;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('indexInfocenter', User::class);
        switch (session()->get('login_role')) {
            case User::IsAdministrador():
                return view('users.administrador.infocenter.index', [
                    'nodos' => $this->userRepository->getAllNodos(),
                    'view' => 'activos'
                ]);
                break;
            case User::IsDinamizador():
                return view('users.dinamizador.infocenter.index', [
                    'view' => 'activos'
                ]);
                break;

            default:
                abort('404');
                break;
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $this->authorize('indexInfocenter', User::class);
        switch (session()->get('login_role')) {
            case User::IsAdministrador():
                return view('users.administrador.infocenter.index', [
                    'nodos' => $this->userRepository->getAllNodos(),
                    'view' => 'inactivos'
                ]);
                break;
            case User::IsDinamizador():
                return view('users.dinamizador.infocenter.index', [
                    'view' => 'inactivos'
                ]);
                break;

            default:
                abort('404');
                break;
        }
    }

    /*======================================================================
    =            metodo para consultar los infocenters por nodo            =
    ======================================================================*/

    public function getInfocenterForNodo(Request $request, $nodo)
    {

        if (request()->ajax()) {
            $users = $this->infocenterRepository->getAllInfocentersForNodo($nodo)
                ->orderby('users.created_at', 'desc')
                ->get();

            return $this->userdatables->datatableUsers($request, $users);
        }
        abort('404');
    }

    public function getInfocenterForNodoTrash(Request $request, $nodo)
    {

        if (request()->ajax()) {
            $users = $this->infocenterRepository->getAllInfocentersForNodo($nodo)
                ->onlyTrashed()
                ->orderby('users.created_at', 'desc')
                ->get();
            return $this->userdatables->datatableUsers($request, $users);
        }
        abort('404');
    }

    /*=====  End of metodo para consultar los infocenters por nodo  ======*/
    /*=======================================================================================
    =            metodo para mostrar todos los infocenter de un determinado nodo            =
    =======================================================================================*/

    public function getAllInfocentersOfNodo(Request $request)
    {

        if (request()->ajax()) {

            if (session()->get('login_role') == User::IsDinamizador()) {
                $users = $this->infocenterRepository->getAllInfocentersForNodo(auth()->user()->dinamizador->nodo_id)
                    ->orderby('users.created_at', 'desc')
                    ->get();

                return $this->userdatables->datatableUsers($request, $users);
            }
            abort('404');
        }
        abort('404');
    }

    /*=====  End of metodo para mostrar todos los infocenter de un determinado nodo  ======*/

    public function getAllInfocentersOfNodoTrash(Request $request)
    {

        if (request()->ajax()) {

            if (session()->get('login_role') == User::IsDinamizador()) {
                $users = $this->infocenterRepository->getAllInfocentersForNodo(auth()->user()->dinamizador->nodo_id)
                    ->onlyTrashed()
                    ->orderby('users.created_at', 'desc')
                    ->get();

                return $this->userdatables->datatableUsers($request, $users);
            }
            abort('404');
        }
        abort('404');
    }

    public function exportInfocenterUser($state = 1, $nodo = null, $extension = 'xlsx')
    {
        $this->authorize('exportUsersInfocenter', User::class);
        $user = $this->getData($state, $nodo);
        $this->setQuery($user);
        return (new InfocenterUserExport($this->getQuery()))->download("Infocenters - " . config('app.name') . ".{$extension}");
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
        $role = [User::IsInfocenter()];

        $relations = [
            'infocenter.nodo.entidad' => function ($query) {
                $query->select('id', 'nombre');
            },
            'infocenter.nodo.entidad.ciudad' => function ($query) {
                $query->select('id', 'nombre');
            },
            'infocenter.nodo.entidad.ciudad.departamento' => function ($query) {
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
                    ->whereHas('infocenter.nodo', function ($query) use ($nodo) {
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
                    ->whereHas('infocenter.nodo', function ($query) use ($nodo) {
                        $query->where('id', $nodo);
                    })->onlyTrashed()
                    ->get();
            }
            return $this->userRepository->userInfoWithRelations($role, $relations)
                ->where('estado', $state)->onlyTrashed()->get();
        }
    }
}
