<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequests\UserFormEditRequest;
use App\Models\{Nodo,Fase, Entidad, Etnia, TipoTalento, TipoFormacion, TipoEstudio, Eps, Ocupacion, LineaTecnologica};
use App\Repositories\Repository\UserRepository\UserRepository;
use App\User;
use Illuminate\Http\Request;
use App\Datatables\UserDatatable;
use Illuminate\Support\{Facades\Validator};
use Illuminate\Http\Response;
use App\Exports\User\UserExport;
use App\Http\Requests\UsersRequests\ConfirmUserRequest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\User\{NewContractor, RoleAssignedOfficer, NodeChanged};



class UserController extends Controller
{

    public $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('auth')->except('getCiudad');
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
                $role = [User::IsGestor(), User::IsArticulador(), User::IsInfocenter(), User::IsTalento(), User::IsIngreso()];
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
                $role = [User::IsGestor(),User::IsArticulador(), User::IsInfocenter(), User::IsTalento(), User::IsIngreso()];
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

        if(($user->has('dinamizador') && isset($user->dinamizador)) || ($user->has('gestor') && isset($user->gestor)) || ($user->has('infocenter') && isset($user->infocenter)) || ($user->has('ingreso') && isset($user->ingreso))){
            if ($request->get('txtestado') == 'on') {
                $user->update(['estado' => 0]);
                $user->delete();
                return redirect()->back()->withSuccess('Acceso de usuario modificado');
            } else {
                $user->update([
                    'estado' => User::IsActive(),
                ]);
                $user->restore();
                return redirect()->back()->withSuccess('Acceso de usuario modificado');
            }

        }else if($user->has('talento') && isset($user->talento))
        {
            if ($request->get('txtestado') == 'on') {
                $user->update(['estado' => 0]);
                $user->delete();
                return redirect()->back()->withSuccess('Acceso de usuario modificado');
            } else {
                $user->update([
                    'estado' => User::IsActive(),
                ]);
                $user->restore();
                return redirect()->back()->withSuccess('Acceso de usuario modificado');
            }
        }
        else
        {
            return redirect()->back()->withError('No puedes cambiar el estado a este usuario. Primero asigna un rol y un nodo');
        }
        return redirect()->back()->with('error', 'error al actualizar, intentalo de nuevo');
    }


    public function gestoresByNodo($nodo = null)
    {
        $gestores = User::select('gestores.id')
            ->selectRaw('CONCAT(users.documento, " - ", users.nombres, " ", users.apellidos) as nombre')
            ->join('gestores', 'gestores.user_id', 'users.id')
            ->role(User::IsGestor())
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
                    'url' => route('registro'),
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

    public function changeNodeUser($document)
    {

        $user = User::withTrashed()->where('documento', $document)->firstOrFail();

        // $this->authorize('acceso', $user);
        return view('users.permissions', [
            'user' => $user,
            'roles' => $this->userRepository->getRoleWhereNotInRole([User::IsDesarrollador()]),
            'nodos'             => $this->userRepository->getAllNodo(),
            'tipotalentos' => TipoTalento::pluck('nombre', 'id'),
            'regionales'        => $this->userRepository->getAllRegionales(),
            'tipoformaciones' => TipoFormacion::pluck('nombre', 'id'),
            'tipoestudios' => TipoEstudio::pluck('nombre', 'id'),
            'lineas' => LineaTecnologica::pluck('nombre', 'id')
        ]);
    }

    public function updateNode(Request $request, int $documento)
    {
        $user = User::withTrashed()->where('documento', $documento)->firstOrFail();
        // $this->authorize('confirmContratorInformation', $user);

        $req = new ConfirmUserRequest;

        $validator = Validator::make($request->all(), $req->rules(), $req->messages());

        if ($validator->fails()) {
            return response()->json([
                'state'   => 'error_form',
                'fail'   => true,
                'errors' => $validator->errors(),
            ]);
        } else {
            if ($user != null) {

                if(($user->isUserExperto() || $user->isUserArticulador()) && ($user->gestor->nodo_id != $request->input('txtnodogestor')  || $user->gestor->lineatecnologica_id != $request->input('txtlinea') ) )
                {
                    $activities = $user->gestor->actividades()->activitiesGestor();
                    $removeRole = array_diff(collect($user->getRoleNames())->toArray(), $request->input('role'));

                    if($activities->count() > 0 || ($removeRole != null && collect($removeRole)->contains(User::IsGestor())))
                    {
                        return response()->json([
                            'state'   => 'error',
                            'message' => "No se puede cambiar de nodo, actualmente el experto tiene {$activities->count()} atividades sin finalizar, para ello debe asignarlas a otro experto del nodo",
                            'url' => false,
                            'activities' => $activities,
                            'count' => $activities->count()
                        ]);
                    }

                    if($request->input('txtnodogestor') != $user->gestor->nodo_id){
                        $userUpdate = $this->userRepository->UpdateUserConfirm($request, $user);
                        Notification::send($userUpdate, new NodeChanged($userUpdate));
                        return response()->json([
                            'state'   => 'success',
                            'message' => 'El Usuario ha sido modificado satisfactoriamente',
                            'url' => route('usuario.usuarios.show', $userUpdate->documento),
                            'user' => $userUpdate,
                        ]);
                    }
                }
                if(($user->isUserDinamizador() && ($user->dinamizador->nodo_id != $request->input('txtnododinamizador')))
                    || ($user->isUserInfocenter() && ($user->infocenter->nodo_id != $request->input('txtnodoinfocenter')))
                    || ($user->isUserIngreso() && ($user->ingreso->nodo_id != $request->input('txtnodoingreso')))
                ){
                    $userUpdate = $this->userRepository->UpdateUserConfirm($request, $user);
                    Notification::send($userUpdate, new NodeChanged($userUpdate));
                    return response()->json([
                        'state'   => 'success',
                        'message' => 'El Usuario ha sido modificado satisfactoriamente',
                        'url' => route('usuario.usuarios.show', $userUpdate->documento),
                        'user' => $userUpdate,
                    ]);
                }

                $userUpdate = $this->userRepository->UpdateUserConfirm($request, $user);

                return response()->json([
                    'state'   => 'success',
                    'message' => 'El Usuario ha sido modificado satisfactoriamente',
                    'url' => route('usuario.usuarios.show', $userUpdate->documento),
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
}
