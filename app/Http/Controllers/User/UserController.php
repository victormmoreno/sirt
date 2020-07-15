<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequests\UserFormRequest;
use App\Http\Traits\UserTrait\RegistersUsers;
use App\Models\{Nodo, Etnia, TipoTalento, TipoFormacion, TipoEstudio, Eps, Ocupacion, LineaTecnologica};
use App\Repositories\Repository\UserRepository\UserRepository;
use App\User;
use Illuminate\Http\Request;
use App\Repositories\Datatables\UserDatatables;
use Illuminate\Support\{Str, Facades\Session, Facades\Validator};
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Http\Response;
use App\Exports\User\Administrador\UserAllExport;


class UserController extends Controller
{

    use RegistersUsers;

    public $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function findUserById(int $id)
    {
        return response()->json([
            'user' => User::withTrashed()->where('id', $id)->first(),
        ]);
    }

    /**
     * metodo para mostrar el index o listado de usarios.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index', User::class);


        switch (session()->get('login_role')) {
            case User::IsAdministrador():
                return view('users.administrador.index', [
                    'roles' => $this->userRepository->getAllRoles(),
                ]);
                break;
            case User::IsDinamizador():
                $role = ['Gestor', 'Infocenter', 'Ingreso', 'Talento'];
                return view('users.administrador.index', [

                    'roles' => $this->userRepository->getRoleWhereInRole($role),
                ]);
                break;

            case User::IsGestor():

                return view('users.gestor.talento.index', ['view' => 'activos']);
                break;
            case User::IsInfocenter():
                $role = [User::IsGestor(), User::IsInfocenter(), User::IsTalento(), User::IsIngreso()];
                return view('users.administrador.index', [

                    'roles' => $this->userRepository->getRoleWhereInRole($role),
                ]);
                break;
            default:
                abort('404');
                break;
        }
    }
    //usuarios sin proyectos
    public function notActvity()
    {
        // $this->authorize('index', User::class);

        // $user =  DB::table('users')
        //     ->join('talentos', 'talentos.user_id', '=', 'users.id')
        //     ->whereNotExists(function ($query) {
        //         $query->select('articulacion_proyecto_talento.talento_id')
        //             ->from('articulacion_proyecto_talento')
        //             ->whereRaw('articulacion_proyecto_talento.talento_id = talentos.id');
        //     })
        //     ->get();

        // return Datatables::of($user)

        //     ->make(true);

        // return $user;

        // return DataTables::eloquent($user)
        //     ->skipPaging()
        //     ->toJson();

        // switch (session()->get('login_role')) {
        //         // case User::IsAdministrador():

        //         // case User::IsDinamizador():


        //     case User::IsGestor():
        //         $auth = auth()->user()->gestor->id;
        //         $nodo = auth()->user()->gestor->nodo_id;


        //         // $users = $this->userRepository->getUsersTalentosByProject($nodo, $auth, $anio)->groupBy('users.id')
        //         //     ->get();
        //         // return view('users.gestor.talento.notActivity', ['view' => 'activos']);
        //         break;
        //     case User::IsInfocenter():

        //     default:
        //         abort('404');
        //         break;
        // }
    }



    /*===============================================================================
    =            metodo API para consultar las ciudades por departamento            =
    ===============================================================================*/

    public function getCiudad($departamento = '1')
    {
        if (request()->ajax()) {
            return response()->json([
                'ciudades' => $this->userRepository->getAllCiudadDepartamento($departamento),
            ]);
        } else {
            abort('404');
        }
    }

    /*=====  End of metodo API para consultar las ciudades por departamento  ======*/

    /*============================================================================
    =            metodo encargado de hacer consulta y retonar la dataables          =
    ============================================================================*/

    public function getDatatablesUsersTalentosByDatatables(Request $request, UserDatatables $usersDatatables, $anio)
    {
        if (request()->ajax()) {

            if (session()->get('login_role') == User::IsGestor()) {
                $auth = auth()->user()->gestor->id;
                $nodo = auth()->user()->gestor->nodo_id;
                $users = $this->userRepository->getUsersTalentosByProject($nodo, $auth, $anio)->groupBy('users.id')
                    ->get();

                return $usersDatatables->datatableUsers($request, $users);
            } else if (session()->get('login_role') == User::IsDinamizador()) {
                $nodo = auth()->user()->dinamizador->nodo_id;
                $users = $this->userRepository->getUsersTalentosByProject($nodo, $auth = null, $anio)->groupBy('users.id')
                    ->get();
                return $usersDatatables->datatableUsers($request, $users);
            } else if (session()->get('login_role') == User::IsInfocenter()) {
                $nodo = auth()->user()->infocenter->nodo_id;
                $users = $this->userRepository->getUsersTalentosByProject($nodo, $auth = null, $anio)->groupBy('users.id')
                    ->get();
                return $usersDatatables->datatableUsers($request, $users);
            }
        }
        abort('404');
    }

    public function getDatatablesUsersTalentosByDatatablesTrash(Request $request, UserDatatables $usersDatatables, $anio)
    {
        if (request()->ajax()) {

            if (session()->get('login_role') == User::IsGestor()) {
                $auth = auth()->user()->gestor->id;
                $nodo = auth()->user()->gestor->nodo_id;
                $users = $this->userRepository->getUsersTalentosByProject($nodo, $auth, $anio)
                    ->onlyTrashed()
                    ->groupBy('users.id')
                    ->get();

                return $usersDatatables->datatableUsers($request, $users);
            } else if (session()->get('login_role') == User::IsDinamizador()) {
                $nodo = auth()->user()->dinamizador->nodo_id;
                $users = $this->userRepository->getUsersTalentosByProject($nodo, $auth = null, $anio)
                    ->onlyTrashed()
                    ->groupBy('users.id')
                    ->get();
                return $usersDatatables->datatableUsers($request, $users);
            } else if (session()->get('login_role') == User::IsInfocenter()) {
                $nodo = auth()->user()->infocenter->nodo_id;
                $users = $this->userRepository->getUsersTalentosByProject($nodo, $auth = null, $anio)
                    ->onlyTrashed()
                    ->groupBy('users.id')
                    ->get();
                return $usersDatatables->datatableUsers($request, $users);
            }
        }
        abort('404');
    }

    public function getDatatablesUsersTalentosByGestorDatatables(Request $request, UserDatatables $usersDatatables, $gestor, $anio)
    {
        if (request()->ajax()) {

            if (session()->get('login_role') == User::IsDinamizador()) {
                $nodo = auth()->user()->dinamizador->nodo_id;
                $users = $this->userRepository->getUsersTalentosByProject($nodo, $gestor, $anio)->groupBy('users.id')
                    ->get();

                return $usersDatatables->datatableUsers($request, $users);
            } elseif (session()->get('login_role') == User::IsInfocenter()) {
                $nodo = auth()->user()->infocenter->nodo_id;
                $users = $this->userRepository->getUsersTalentosByProject($nodo, $gestor, $anio)->groupBy('users.id')
                    ->get();

                return $usersDatatables->datatableUsers($request, $users);
            }
        }
        abort('404');
    }
    public function getDatatablesUsersTalentosByGestorDatatablesTrash(Request $request, UserDatatables $usersDatatables, $gestor, $anio)
    {
        if (request()->ajax()) {

            if (session()->get('login_role') == User::IsDinamizador()) {
                $nodo = auth()->user()->dinamizador->nodo_id;
                $users = $this->userRepository->getUsersTalentosByProject($nodo, $gestor, $anio)
                    ->onlyTrashed()
                    ->groupBy('users.id')
                    ->get();

                return $usersDatatables->datatableUsers($request, $users);
            } elseif (session()->get('login_role') == User::IsInfocenter()) {
                $nodo = auth()->user()->infocenter->nodo_id;
                $users = $this->userRepository->getUsersTalentosByProject($nodo, $gestor, $anio)
                    ->onlyTrashed()
                    ->groupBy('users.id')
                    ->get();

                return $usersDatatables->datatableUsers($request, $users);
            }
        }
        abort('404');
    }


    public function getDatatablesUsersTalentosByNodoDatatables(Request $request, UserDatatables $usersDatatables, $nodo, $anio)
    {
        if (request()->ajax()) {

            if (session()->get('login_role') == User::IsAdministrador()) {

                $users = $this->userRepository->getUsersTalentosByProject($nodo, $auth = null, $anio)->groupBy('users.id')
                    ->get();

                return $usersDatatables->datatableUsers($request, $users);
            }
        }
        abort('404');
    }

    public function getDatatablesUsersTalentosByNodoDatatablesTrash(Request $request, UserDatatables $usersDatatables, $nodo, $anio)
    {
        if (request()->ajax()) {

            if (session()->get('login_role') == User::IsAdministrador()) {

                $users = $this->userRepository->getUsersTalentosByProject($nodo, $auth = null, $anio)
                    ->onlyTrashed()
                    ->groupBy('users.id')
                    ->get();

                return $usersDatatables->datatableUsers($request, $users);
            }
        }
        abort('404');
    }



    /*============================================================================
    =            metodo para mostrar todos los usuarios en datatables            =
    ============================================================================*/

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($documento)
    {

        $user = User::where('documento', $documento)->first();

        if ($user == null) {
            $user = User::onlyTrashed()->where('documento', $documento)->firstOrFail();
        }

        return view('users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($documento)
    {
        $user = User::where('documento', $documento)->first();

        if ($user == null) {
            $user = User::onlyTrashed()->where('documento', $documento)->firstOrFail();
        }
        $this->authorize('edit', $user);
        switch (session()->get('login_role')) {
            case User::IsAdministrador():

                return view('users.edit', [
                    'etnias' => Etnia::pluck('nombre', 'id'),
                    'tipotalentos' => TipoTalento::pluck('nombre', 'id'),
                    'user'              => $user,
                    'tiposdocumentos'   => $this->userRepository->getAllTipoDocumento(),
                    'gradosescolaridad' => $this->userRepository->getSelectAllGradosEscolaridad(),
                    'gruposanguineos'   => $this->userRepository->getAllGrupoSanguineos(),
                    'eps'               => $this->userRepository->getAllEpsActivas(),
                    'departamentos'     => $this->userRepository->getAllDepartamentos(),
                    'ocupaciones'       => $this->userRepository->getAllOcupaciones(),
                    'roles'             => $this->userRepository->getAllRoles(),
                    'nodos'             => $this->userRepository->getAllNodo(),
                    'perfiles'          => $this->userRepository->getAllPerfiles(),
                    'regionales'        => $this->userRepository->getAllRegionales(),
                    'tipoformaciones' => TipoFormacion::pluck('nombre', 'id'),
                    'tipoestudios' => TipoEstudio::pluck('nombre', 'id'),
                    'lineas' => LineaTecnologica::pluck('nombre', 'id'),
                    'view' => 'edit'
                ]);
                break;
            case User::IsDinamizador():
                if (isset(auth()->user()->dinamizador->nodo->id)) {
                    $nodo = Nodo::nodoUserAthenticated(auth()->user()->dinamizador->nodo->id)->pluck('nombre', 'id');
                } else {
                    $nodo = [];
                    return redirect()->route('home');
                }


                return view('users.edit', [
                    'user'              => $user,
                    'tiposdocumentos'   => $this->userRepository->getAllTipoDocumento(),
                    'gradosescolaridad' => $this->userRepository->getSelectAllGradosEscolaridad(),
                    'gruposanguineos'   => $this->userRepository->getAllGrupoSanguineos(),
                    'eps'               => $this->userRepository->getAllEpsActivas(),
                    'departamentos'     => $this->userRepository->getAllDepartamentos(),
                    'ocupaciones'       => $this->userRepository->getAllOcupaciones(),
                    'roles'             => $this->userRepository->getAllRoles(),
                    'nodos'             => $this->userRepository->getAllNodo(),
                    'perfiles'          => $this->userRepository->getAllPerfiles(),
                    'regionales'        => $this->userRepository->getAllRegionales(),
                    'etnias' => Etnia::pluck('nombre', 'id'),
                    'tipotalentos' => TipoTalento::pluck('nombre', 'id'),
                    'tipoformaciones' => TipoFormacion::pluck('nombre', 'id'),
                    'tipoestudios' => TipoEstudio::pluck('nombre', 'id'),
                    'lineas' => LineaTecnologica::pluck('nombre', 'id'),

                    'view' => 'edit'
                ]);
                break;
            case User::IsGestor():
                if (isset(auth()->user()->gestor->nodo->id)) {
                    $nodo = Nodo::nodoUserAthenticated(auth()->user()->gestor->nodo->id)->pluck('nombre', 'id');
                } else {
                    $nodo = [];
                    return redirect()->route('home');
                }
                return view('users.edit', [
                    'user'              => $user,
                    'tiposdocumentos'   => $this->userRepository->getAllTipoDocumento(),
                    'gradosescolaridad' => $this->userRepository->getSelectAllGradosEscolaridad(),
                    'gruposanguineos'   => $this->userRepository->getAllGrupoSanguineos(),
                    'eps'               => $this->userRepository->getAllEpsActivas(),
                    'departamentos'     => $this->userRepository->getAllDepartamentos(),
                    'ocupaciones'       => $this->userRepository->getAllOcupaciones(),
                    'roles'             => $this->userRepository->getAllRoles(),
                    'nodos'             => $this->userRepository->getAllNodo(),
                    'perfiles'          => $this->userRepository->getAllPerfiles(),
                    'regionales'        => $this->userRepository->getAllRegionales(),
                    'etnias' => Etnia::pluck('nombre', 'id'),
                    'tipotalentos' => TipoTalento::pluck('nombre', 'id'),
                    'tipoformaciones' => TipoFormacion::pluck('nombre', 'id'),
                    'tipoestudios' => TipoEstudio::pluck('nombre', 'id'),
                    'lineas' => LineaTecnologica::pluck('nombre', 'id'),
                    'view' => 'edit'
                ]);

                break;

            default:
                abort('404');
                break;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $user = User::find($id);

        if ($user == null) {
            $user = User::onlyTrashed()->find($id);
        }

        $this->authorize('update', $user);

        $req       = new UserFormRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());


        if ($validator->fails()) {
            return response()->json([
                'state'   => 'error_form',
                'fail'   => true,
                'errors' => $validator->errors(),
            ]);
        } else {
            if ($user != null) {
                $userUpdate = $this->userRepository->Update($request, $user);

                return response()->json([
                    'state'   => 'success',
                    'message' => 'El Usuario ha sido modificado satisfactoriamente',
                    'url' => route('usuario.index'),
                    'user' => $userUpdate,
                ]);
            } else {
                return response()->json([
                    'state'   => 'error',
                    'message' => 'El Usuario no se ha modificado',
                    'url' => false

                ]);
            }
        }
    }


    public function userSearch()
    {
        return view('users.search');
    }

    public function querySearchUser(Request $request)
    {
        if (request()->ajax()) {

            if ($request->input('txttype_search') == 1) {

                $validator = Validator::make($request->all(), [
                    'txtsearch_user' => 'required|digits_between:6,11|numeric',
                    'txttype_search' => 'required|in:1',
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        'fail'   => true,
                        'errors' => $validator->errors(),
                    ]);
                }

                $user = User::where('documento', 'LIKE', "%" . $request->input('txtsearch_user') . "%")->first();
                if ($user == null) {
                    $user = User::onlyTrashed()->where('documento', 'LIKE', "%" . $request->input('txtsearch_user') . "%")->first();
                }
            } else if ($request->input('txttype_search') == 2) {
                $validator = Validator::make($request->all(), [
                    'txtsearch_user' => 'required|email',
                    'txttype_search' => 'required|in:2',
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        'fail'   => true,
                        'errors' => $validator->errors(),
                    ]);
                }
                $user = User::where('email', 'LIKE', "%" . $request->input('txtsearch_user') . "%")
                    ->first();
                if ($user == null) {
                    $user = User::onlyTrashed()->where('email', 'LIKE', "%" . $request->input('txtsearch_user') . "%")->first();
                }
            }


            if ($user == null) {
                return response()->json([
                    'data' => null,
                    'status' => Response::HTTP_ACCEPTED,
                    'message' => 'el usuario no existe en nuestros registros',
                    'url' => route('usuario.usuarios.create'),
                ], Response::HTTP_ACCEPTED);
            }
            return response()->json([
                'user' => $user,
                'roles' => $user->getRoleNames()->implode(', '),
                'message' => 'el usuario ya existe en nuestros registros',
                'status' => Response::HTTP_OK,
                'url' => route('usuario.usuarios.show', $user->documento),
            ], Response::HTTP_OK);
        }
        abort('403');
    }

    public function consultaremail(Request $request)
    {
        $user = User::where('email', $request->txtemail)->first();

        if ($user != null) {
            return response()->json([
                'response' => false
            ]);
        } else {
            return response()->json([
                'response' => true
            ]);
        }
    }


    public function study($document = null)
    {
        $user = $this->userRepository->findUserByDocument($document)->first();
        if ($user != null) {
            abort('404');
        }

        switch (session()->get('login_role')) {
            case User::IsAdministrador():
                break;
            case User::IsGestor():
                return view('users.estudios', [
                    'ocupaciones'       => $this->userRepository->getAllOcupaciones(),
                    'documento' => $document,
                    'gradosescolaridad' => $this->userRepository->getSelectAllGradosEscolaridad(),
                ]);

                break;
            default:
                abort('404');
                break;
        }
    }

    public function acceso($document)
    {
        $user = User::where('documento', $document)->first();

        if ($user == null) {
            $user = User::onlyTrashed()->where('documento', $document)->firstOrFail();
        }

        $this->authorize('acceso', $user);

        return view('users.acceso', ['user' => $user]);
    }


    public function updateAcceso(Request $request, $documento)
    {
        $user = User::where('documento', $documento)->first();

        if ($user == null) {
            $user = User::onlyTrashed()->where('documento', $documento)->firstOrFail();
        }

        if ($request->get('txtestado') == 'on') {
            $user->update(['estado' => 0]);


            $user->delete();
            return redirect()->back()->withSuccess('Acceso de usuario modificado');
        } else {
            $user->update([
                'estado' => 1,
            ]);

            $user->restore();
            return redirect()->back()->withSuccess('Acceso de usuario modificado');
        }


        return redirect()->back()->with('error', 'error al actualizar, intentalo de nuevo');
    }


    public function gestoresByNodo($nodo = null)
    {
        $gestores = User::select('gestores.id')
            ->selectRaw('CONCAT(users.documento, " - ", users.nombres, " ", users.apellidos) as nombre')
            ->join('gestores', 'gestores.user_id', 'users.id')
            ->role('Gestor')
            ->where('gestores.nodo_id', $nodo)
            ->withTrashed()
            ->pluck('nombre', 'id');

        return response()->json([
            'gestores' => $gestores
        ]);
    }

    /**
     * retorna excel con todos los usuarios
     * @author devjul
     */
    public function exportAllUser($state = 1, $extension = 'xlsx')
    {
        $this->authorize('exportAdminUser', User::class);
        if ($state == User::IsActive() || $state == User::IsInactive()) {
            $user = $this->getData($state);
            $this->setQuery($user);
            if ($state == User::IsActive()) {
                return (new UserAllExport($this->getQuery()))->download("usuarios-habilitados-redtecnoparque.{$extension}");
            } else {
                return (new UserAllExport($this->getQuery()))->download("usuarios-inhabilitados-redtecnoparque.{$extension}");
            }
        } else {
            return abort('404');
        }
    }

    /**
     * retorna consulta de todos los usuarios
     * @return collection
     * @author devjul
     */
    private function getData($state = null)
    {
        $role = [User::IsAdministrador(), User::IsDinamizador(), User::IsGestor(), User::IsInfocenter(), User::IsTalento(), User::IsIngreso()];

        $relations = [
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
            'roles',
            'dinamizador.nodo.entidad' => function ($query) {
                $query->select('id', 'nombre');
            },
            'gestor.nodo.entidad' => function ($query) {
                $query->select('id', 'nombre');
            },

            'infocenter.nodo.entidad' => function ($query) {
                $query->select('id', 'nombre');
            },
            'ingreso.nodo.entidad' => function ($query) {
                $query->select('id', 'nombre');
            },



        ];
        if ($state == null) {
            return $this->userRepository->userInfoWithRelations($role, $relations)->get();
        } elseif ($state == 1) {
            return $this->userRepository->userInfoWithRelations($role, $relations)->where('estado', $state)->get();
        } elseif ($state == 0) {
            return $this->userRepository->userInfoWithRelations($role, $relations)->where('estado', $state)->onlyTrashed()->get();
        }
    }

    /**
     * Asigna el valor de $query
     * @author devjul
     */
    private function setQuery($query)
    {
        $this->query = $query;
    }

    /**
     * Retorna el valor de $query
     * @return object
     * @author devjul
     */
    private function getQuery()
    {
        return $this->query;
    }
}
