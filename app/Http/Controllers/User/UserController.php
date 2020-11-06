<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequests\UserFormRequest;
use App\Http\Traits\UserTrait\RegistersUsers;
use App\Models\{Nodo, Entidad, Etnia, TipoTalento, TipoFormacion, TipoEstudio, Eps, Ocupacion, LineaTecnologica};
use App\Repositories\Repository\UserRepository\UserRepository;
use App\User;
use Illuminate\Http\Request;
use App\Datatables\UserDatatable;
use Illuminate\Support\{Facades\Validator};
use Illuminate\Http\Response;
use App\Exports\User\UserExport;



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
            'user' => User::withTrashed()->with(['gestor'])->where('id', $id)->first(),
        ]);
    }

    /**
     * metodo para mostrar el index o listado de usarios.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, UserDatatable $usersDatatables)
    {
        $this->authorize('index', User::class);

        switch (\Session::get('login_role')) {
            case User::IsAdministrador():
                $nodo = $request->filter_nodo;
                break;
            case User::IsDinamizador():
                $nodo = auth()->user()->dinamizador->nodo_id;
                break;
            case User::IsGestor():
                $nodo = auth()->user()->gestor->nodo_id;
                break;
            case User::IsInfocenter():
                $nodo = auth()->user()->infocenter->nodo_id;
                break;
            default:
                return abort('403');
                break;
        }

        if (request()->ajax()) {
            $users = [];
            if (($request->filled('filter_nodo') || $request->filter_nodo == null) && ($request->filled('filter_role') ||  $request->filter_role == null) && $request->filled('filter_state') && ($request->filled('filter_year') || $request->filter_year == null)) {

                $users = User::with(['tipodocumento'])
                    ->role($request->filter_role)
                    ->nodoUser($request->filter_role, $nodo)
                    ->stateDeletedAt($request->filter_state)
                    ->yearActividad($request->filter_role, $request->filter_year, $nodo)
                    ->orderBy('users.created_at', 'desc')
                    ->get();
            }

            return $usersDatatables->datatableUsers($users);
        }
        switch (session()->get('login_role')) {
            case User::IsAdministrador():
                $nodos = Entidad::has('nodo')->with('nodo')->get()->pluck('nombre', 'nodo.id');
                return view('users.administrador.index', [
                    'roles' => $this->userRepository->getAllRoles(),
                    'nodos' => $nodos,
                ]);
                break;
            case User::IsDinamizador():
                $role = [User::IsGestor(), User::IsInfocenter(), User::IsTalento(), User::IsIngreso()];
                return view('users.index', [
                    'roles' => $this->userRepository->getRoleWhereInRole($role),
                ]);
                break;

            case User::IsGestor():
                $role = [User::IsTalento()];
                return view('users.gestor.index', [
                    'roles' => $this->userRepository->getRoleWhereInRole($role),
                ]);
                break;
            case User::IsInfocenter():
                $role = [User::IsGestor(), User::IsInfocenter(), User::IsTalento(), User::IsIngreso()];
                return view('users.index', [
                    'roles' => $this->userRepository->getRoleWhereInRole($role),
                ]);
                break;
            default:
                abort('404');
                break;
        }
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


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($documento)
    {
        $user = User::withTrashed()->where('documento', $documento)->firstOrFail();
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
        $user = User::withTrashed()->where('documento', $documento)->firstOrFail();

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
        $user = User::withTrashed()->find($id);

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
                $user = User::withTrashed()->where('documento', 'LIKE', "%" . $request->input('txtsearch_user') . "%")->first();
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
                $user = User::withTrashed()->where('email', 'LIKE', "%" . $request->input('txtsearch_user') . "%")->first();
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
        $user = User::withTrashed()->where('email', $request->txtemail)->first();

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


    public function acceso($document)
    {
        $user = User::withTrashed()->where('documento', $document)->firstOrFail();
        $this->authorize('acceso', $user);

        return view('users.acceso', ['user' => $user]);
    }


    public function updateAcceso(Request $request, $documento)
    {
        $user = User::withTrashed()->where('documento', $documento)->firstOrFail();

        $this->authorize('acceso', $user);

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

    public function export(Request $request, $extension = 'xlsx')
    {
        $this->authorize('export', User::class);

        switch (\Session::get('login_role')) {
            case User::IsAdministrador():
                $nodo = $request->filter_nodo;
                break;
            case User::IsDinamizador():
                $nodo = auth()->user()->dinamizador->nodo_id;
                break;
            case User::IsGestor():
                $nodo = auth()->user()->gestor->nodo_id;
                break;
            case User::IsInfocenter():
                $nodo = auth()->user()->infocenter->nodo_id;
                break;
            default:
                return abort('403');
                break;
        }

        $users = [];
        if (($request->filled('filter_nodo') || $request->filter_nodo == null) && ($request->filled('filter_role') || $request->filter_role == null) && $request->filled('filter_state') && ($request->filled('filter_year') || $request->filter_year == null)) {
            $users = User::with(['tipodocumento'])
                ->role($request->filter_role)
                ->nodoUser($request->filter_role, $nodo)
                ->stateDeletedAt($request->filter_state)
                ->yearActividad($request->filter_role, $request->filter_year, $nodo)
                ->orderBy('users.created_at', 'desc')
                ->get();
        }

        return (new UserExport($request, $users))->download("Usuarios - " . config('app.name') . ".{$extension}");
    }

    public function myTalentos(Request $request, UserDatatable $usersDatatables)
    {

        $this->authorize('myTalentos', User::class);

        if (request()->ajax()) {
            $users = [];
            if (($request->filled('filter_nodo') || $request->filter_nodo == null) && ($request->filled('filter_role') ||  $request->filter_role == null) && $request->filled('filter_state') && ($request->filled('filter_year') || $request->filter_year == null)) {
                $users = User::with(['tipodocumento'])
                    ->role(User::IsTalento())
                    ->stateDeletedAt($request->filter_state)
                    ->activitiesTalento(User::IsTalento(), $request->filter_year, auth()->user()->gestor->nodo_id)
                    ->orderBy('users.created_at', 'desc')
                    ->get();
            }

            return $usersDatatables->datatableUsers($users);
        }

        return view('users.gestor.talentos', [
            'roles' => $this->userRepository->getRoleWhereInRole([User::IsTalento()]),
        ]);
    }

    public function exportMyTalentos(Request $request, $extension = 'xlsx')
    {
        $this->authorize('export', User::class);

        switch (\Session::get('login_role')) {
            case User::IsAdministrador():
                $nodo = $request->filter_nodo;
                break;
            case User::IsDinamizador():
                $nodo = auth()->user()->dinamizador->nodo_id;
                break;
            case User::IsGestor():
                $nodo = auth()->user()->gestor->nodo_id;
                break;
            case User::IsInfocenter():
                $nodo = auth()->user()->infocenter->nodo_id;
                break;
            default:
                return abort('403');
                break;
        }

        $users = [];
        if (($request->filled('filter_nodo') || $request->filter_nodo == null) && ($request->filled('filter_role') || $request->filter_role == null) && $request->filled('filter_state') && ($request->filled('filter_year') || $request->filter_year == null)) {
            $users = User::with(['tipodocumento'])
                ->role(User::IsTalento())
                ->nodoUser(User::IsTalento(), $nodo)
                ->stateDeletedAt($request->filter_state)
                ->activitiesTalento(User::IsTalento(), $request->filter_year, $nodo)
                ->orderBy('users.created_at', 'desc')
                ->get();
        }

        return (new UserExport($request, $users))->download("Usuarios - " . config('app.name') . ".{$extension}");
    }

    /*=====  Método para controlar el formulario usuarios nuevos  ======*/
    public function create()
    {
        return view('registro_usuarios.form',[
            'tiposdocumentos'   => $this->userRepository->getAllTipoDocumento(),
            'departamentos'     => $this->userRepository->getAllDepartamentos(),
            'ciudades'          => $this->userRepository->getAllCiudades(),
            'view' => 'create'
        ]);
    }

    /*=====  Fin Método para controlar el formulario usuarios nuevos  ======*/
}
