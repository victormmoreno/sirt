<?php

namespace App\Http\Controllers\User;


use App\Helpers\AuthRoleHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequests\UserFormEditRequest;
use App\Models\{Etnia, Nodo, TipoTalento, TipoFormacion, TipoEstudio, LineaTecnologica, Entidad};
use App\Repositories\Repository\{UserRepository\UserRepository, ProfileRepository\ProfileRepository};
use App\User;
use Illuminate\Http\Request;
use App\Datatables\UserDatatable;
use Illuminate\Support\{Facades\Validator};
use Illuminate\Http\Response;
use App\Exports\User\UserExport;
use Illuminate\Support\Facades\Notification;
use App\Notifications\User\NodeChanged;


class UserController extends Controller
{
    public $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('auth');
    }

    /**
     * Display the list resources.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|Response|\Illuminate\View\View
     */
    public function index(Request $request, UserDatatable $usersDatatables)
    {
        if (request()->user()->cannot('index', User::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $node = AuthRoleHelper::checkRoleAuth(['node' => $request->filter_nodo])['node'];
        if (request()->ajax()) {
            $users = [];
            if (($request->filled('filter_nodo') || $request->filter_nodo == null) && ($request->filled('filter_role') || $request->filter_role == null) && $request->filled('filter_state') && ($request->filled('filter_year') || $request->filter_year == null)) {
                $users = User::query()
                    ->select('users.id', 'tiposdocumentos.nombre as tipodocumento', 'users.documento', 'users.email', 'users.celular', 'users.ultimo_login', 'users.estado', 'users.deleted_at')
                    ->selectRaw('concat(users.nombres, " ",users.apellidos) as usuario, GROUP_CONCAT(roles.name SEPARATOR ", ") as roles')
                    ->selectRaw("if(roles.name = 'dinamizador', entidaddinamizador.nombre, if(roles.name = 'experto', entidadexperto.nombre, if(roles.name = 'articulador', entidadusernodo.nombre, if(roles.name = 'apoyo técnico', entidadusernodo.nombre, if(roles.name = 'infocenter', entidadinfocenter.nombre, if(roles.name = 'ingreso', entidadingreso.nombre, 'No Aplica')))))) as nodo")
                    ->userQuery()
                    ->nodeQuery($request->filter_role, $node)
                    ->roleQuery($request->filter_role)
                    ->stateDeletedAt($request->filter_state)
                    ->groupBy('users.id')
                    ->orderBy('users.created_at', 'desc')
                    ->get();

            }
            return $usersDatatables->datatableUsers($users);
        }
        switch (session()->get('login_role')) {
            case User::IsAdministrador():
                return view('users.index', [
                    'roles' => $this->userRepository->getAllRoles(),
                    'nodos' => Nodo::SelectNodo()->get()
                ]);
                break;
            case User::IsActivador():
                return view('users.index', [
                    'roles' => $this->userRepository->getAllRoles(),
                    'nodos' => Nodo::SelectNodo()->get()
                ]);
                break;
            case User::IsDinamizador():
                $role = [User::IsExperto(), User::IsArticulador(), User::IsInfocenter(), User::IsTalento(), User::IsIngreso(), User::IsApoyoTecnico()];
                return view('users.index', [
                    'roles' => $this->userRepository->getRoleWhereInRole($role),
                ]);
                break;
            case User::IsArticulador():
                $role = [User::IsTalento()];
                return view('users.index', [
                    'roles' => $this->userRepository->getRoleWhereInRole($role),
                ]);
                break;
            case User::IsExperto():
                $role = [User::IsTalento()];
                return view('users.index', [
                    'roles' => $this->userRepository->getRoleWhereInRole($role),
                ]);
                break;
            case User::IsInfocenter():
                $role = [User::IsExperto(), User::IsArticulador(), User::IsInfocenter(), User::IsTalento(), User::IsIngreso(), User::IsApoyoTecnico()];
                return view('users.index', [
                    'roles' => $this->userRepository->getRoleWhereInRole($role),
                ]);
                break;
            default:
                alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
                return redirect()->route('home');
                break;
        }
    }



    /**
     * Display the list resources (talents).
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|Response|\Illuminate\View\View
     */
    public function talentsList(Request $request, UserDatatable $usersDatatables)
    {
        if (request()->user()->cannot('talentsList', User::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        if (request()->ajax()) {
            $users = [];
            if (($request->filled('filter_year') || $request->filter_year != null || $request->filter_year != 'all')) {
                $users = User::query()
                    ->select('users.id', 'tiposdocumentos.nombre as tipodocumento', 'users.documento', 'users.email', 'users.celular', 'users.ultimo_login', 'users.estado', 'users.deleted_at')
                    ->selectRaw('concat(users.nombres, " ",users.apellidos) as usuario, GROUP_CONCAT(DISTINCT roles.name SEPARATOR ", ") as roles')
                    ->leftJoin('tiposdocumentos', 'tiposdocumentos.id', '=', 'users.tipodocumento_id')
                    ->join('model_has_roles', function ($join) {
                        $join->on('users.id', '=', 'model_has_roles.model_id')
                            ->where('model_has_roles.model_type', User::class);
                    })
                    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                    ->activitiesTalentsQuery(User::IsTalento(), $request->filter_year, auth()->user()->gestor->nodo_id)
                    ->role(User::IsTalento())
                    ->stateDeletedAt($request->filter_state)
                    ->groupBy('users.id')
                    ->orderBy('users.created_at', 'desc')
                    ->get();
            }
            return $usersDatatables->datatableUsers($users);
        }
        return view('users.talents', [
            'roles' => $this->userRepository->getRoleWhereInRole([User::IsTalento()]),
        ]);
    }

    /**
     * export the list resources
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|Response|\Illuminate\View\View
     */
    public function export(Request $request, $extension = 'xlsx')
    {
        ini_set('memory_limit', '-1');
        set_time_limit('3000000');
        if (request()->user()->cannot('export', User::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $node = AuthRoleHelper::checkRoleAuth(['node' => $request->filter_nodo])['node'];
        $users = [];
        if (($request->filled('filter_nodo') || $request->filter_nodo == null) && ($request->filled('filter_role') || $request->filter_role == null) && $request->filled('filter_state') && ($request->filled('filter_year') || $request->filter_year == null)) {
            $users = User::query()
                ->select('users.id', 'tiposdocumentos.nombre as tipodocumento', 'users.fechanacimiento', 'users.documento', 'users.email', 'users.celular', 'users.telefono', 'users.genero', 'gruposanguineos.nombre as grupo_sanguineo', 'users.estrato', 'users.direccion', 'etnias.nombre as etnia', 'users.grado_discapacidad', 'users.descripcion_grado_discapacidad', 'eps.nombre as eps', 'users.otra_eps', 'users.institucion', 'users.titulo_obtenido', 'users.fecha_terminacion', 'users.ultimo_login', 'users.estado', 'users.deleted_at')
                ->selectRaw('concat(users.nombres, " ",users.apellidos) as usuario, concat(expedition_city.nombre, " (",expedition_depart.nombre,")") as expedicion, concat(residency_city.nombre, " (",residency_depart.nombre,")") as residencia, GROUP_CONCAT(DISTINCT roles.name SEPARATOR ", ") as roles, GROUP_CONCAT(DISTINCT ocupaciones.nombre SEPARATOR ", ") as ocupaciones')
                ->selectRaw("if(roles.name = 'dinamizador', entidaddinamizador.nombre, if(roles.name = 'experto', entidadexperto.nombre, if(roles.name = 'articulador', entidadusernodo.nombre, if(roles.name = 'apoyo técnico', entidadusernodo.nombre, if(roles.name = 'infocenter', entidadinfocenter.nombre, if(roles.name = 'ingreso', entidadingreso.nombre, 'No Aplica')))))) as nodo")
                ->leftJoin('ciudades as expedition_city', 'expedition_city.id', '=', 'users.ciudad_expedicion_id')
                ->leftJoin('departamentos as expedition_depart', 'expedition_depart.id', '=', 'expedition_city.departamento_id')
                ->leftJoin('gruposanguineos', 'gruposanguineos.id', '=', 'users.gruposanguineo_id')
                ->leftJoin('ciudades as residency_city', 'residency_city.id', '=', 'users.ciudad_id')
                ->leftJoin('departamentos as residency_depart', 'residency_depart.id', '=', 'residency_city.departamento_id')
                ->leftJoin('etnias', 'etnias.id', '=', 'users.etnia_id')
                ->leftJoin('eps', 'eps.id', '=', 'users.eps_id')
                ->leftJoin('ocupaciones_users', 'ocupaciones_users.user_id', '=', 'users.id')
                ->leftJoin('ocupaciones', 'ocupaciones.id', '=', 'ocupaciones_users.ocupacion_id')
                ->userQuery()
                ->nodeQuery($request->filter_role, $node)
                ->roleQuery($request->filter_role)
                ->stateDeletedAt($request->filter_state)
                ->groupBy('users.id')
                ->orderBy('users.created_at', 'desc')
                    ->get();
        }
        return (new UserExport($request, $users))->download("Usuarios - " . config('app.name') . ".{$extension}");
    }

    /**
     * Display the specified resource.
     * @param int $documento
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|Response|\Illuminate\View\View
     */
    public function show($documento)
    {
        $user = User::withTrashed()->where('documento', $documento)->firstOrFail();
        if(request()->user()->cannot('show', $user))
        {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->back();
        }
        if (request()->ajax()) {
            return response()->json([
                'data' => [
                    'user' => $user
                ]
            ]);
        }
        return view('users.show', ['user' => $user]);
    }

    /**
     * Display the view for to change access the specified resource.
     * @param int $document
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|Response|\Illuminate\View\View
     */
    public function access(int $document)
    {
        $user = User::withTrashed()->where('documento', $document)->firstOrFail();
        if (request()->user()->cannot('access', $user)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        return view('users.access', ['user' => $user]);
    }

    /**
     * Update access the specified resource
     * @param int $documento
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|Response|\Illuminate\View\View
     */
    public function updateAccess(Request $request, $documento)
    {
        $user = User::withTrashed()->where('documento', $documento)->firstOrFail();
        if (request()->user()->cannot('access', $user)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        return $this->userRepository->updateAccessAUser($request, $user);
    }

    /**
     * Display the view for to search specified resource (user).
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|Response|\Illuminate\View\View
     */
    public function userSearch()
    {
        if (request()->user()->cannot('search', User::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        return view('users.search');
    }

    /**
     * Search specified resource (user).
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|Response|\Illuminate\View\View
     */
    public function querySearchUser(Request $request)
    {
        if (!request()->ajax() || request()->user()->cannot('search', User::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        if ($request->input('txttype_search') == 1) {
            $validator = Validator::make($request->all(), [
                'txtsearch_user' => 'required|digits_between:6,11|numeric',
                'txttype_search' => 'required|in:1',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'fail' => true,
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
                    'fail' => true,
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
            'url' => route('usuarios.show', $user->documento),
        ], Response::HTTP_OK);
    }

    /**
     * Display the view for to update node and roles to specified resource (user).
     * @param int $documento
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|Response|\Illuminate\View\View
     */
    public function changeNodeAndRole($document)
    {
        $user = User::withTrashed()->where('documento', $document)->firstOrFail();
        if (request()->user()->cannot('updateNodeAndRole', $user)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        return view('users.permissions', [
            'user' => $user,
            'roles' => $this->userRepository->getAllRoles(),
            'nodos' => $this->userRepository->getAllNodo(),
            'tipotalentos' => TipoTalento::pluck('nombre', 'id'),
            'regionales' => $this->userRepository->getAllRegionales(),
            'tipoformaciones' => TipoFormacion::pluck('nombre', 'id'),
            'tipoestudios' => TipoEstudio::pluck('nombre', 'id'),
            'lineas' => LineaTecnologica::pluck('nombre', 'id')
        ]);
    }

    public function consultarUnUsuarioPorId($id)
    {
        return response()->json([
            'talento' => User::findOrFail($id),
        ]);
    }

    public function datatableTalentosDeTecnoparque()
    {
        if (request()->ajax()) {
            $talentos = User::ConsultarUsuarios()
                ->get();
            return datatables()->of($talentos)->addColumn('add_proyecto', function ($data) {
                    $add = '<a onclick="addTalentoProyecto(' . $data->id . ')" class="btn bg-info white-text m-b-xs"><i class="material-icons">done</i></a>';
                    return $add;
                })->addColumn('add_propiedad', function ($data) {
                    $propiedad = '<a onclick="addPersonaPropiedad(' . $data->id . ')" class="btn bg-secondary m-b-xs"><i class="material-icons">done</i></a>';
                    return $propiedad;
                })
                ->addColumn('add_intertocutor_talent_articulation', function ($data) {
                    $add = '<a onclick="articulationStage.addInterlocutorTalentArticulacion(' . $data->id . ')" class="btn bg-info white-text m-b-xs"><i class="material-icons">done</i></a>';
                    return $add;
                })

                ->addColumn('add_talents_articulation', function ($data) {
                    $add = '<a onclick="filter_articulations.addTalentToArticulation(' . $data->id . ')" class="btn bg-info white-text m-b-xs"><i class="material-icons">done</i></a>';
                    return $add;
                })
                ->rawColumns(['add_proyecto', 'add_proyecto', 'add_propiedad', 'add_talents_articulation', 'add_intertocutor_talent_articulation'])->make(true);
        }
        abort('404');
    }

    /**
     * Update node and roles to specified resource (user).
     * @param int $documento
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|Response|\Illuminate\View\View
     */
    public function updateNodeAndRole(Request $request, int $documento)
    {
        $user = User::withTrashed()->where('documento', $documento)->firstOrFail();
        if (request()->user()->cannot('updateNodeAndRole', $user)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $req = new Request;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'state' => 'error_form',
                'fail' => true,
                'errors' => $validator->errors(),
            ]);
        } else {
            if (($user->isUserExperto()) && ($user->gestor->nodo_id != $request->input('txtnodogestor') || $user->gestor->lineatecnologica_id != $request->input('txtlinea'))) {
                $projects = $user->gestor->proyectos()->proyectosGestor();
                $removeRole = array_diff(collect($user->getRoleNames())->toArray(), $request->input('role'));

                if ($projects->count() > 0 || ($removeRole != null && collect($removeRole)->contains(User::IsExperto()))) {
                    return response()->json([
                        'state' => 'error',
                        'message' => "No se puede cambiar de nodo, actualmente el experto tiene {$projects->count()} atividades sin finalizar, para ello debe asignarlas a otro experto del nodo",
                        'url' => false,
                        'activities' => $projects,
                        'count' => $projects->count()
                    ]);
                }
                $userUpdate = $this->userRepository->UpdateUserConfirm($request, $user);
                Notification::send($userUpdate, new NodeChanged($userUpdate));
                return response()->json([
                    'state' => 'success',
                    'message' => 'El Usuario ha sido modificado satisfactoriamente',
                    'url' => route('usuarios.show', $userUpdate->documento),
                    'user' => $userUpdate,
                ]);

            }
            $userUpdate = $this->userRepository->UpdateUserConfirm($request, $user);
            if (($user->isUserDinamizador() && isset($user->dinamizador) && ($user->dinamizador->nodo_id != $request->input('txtnododinamizador')))
                || ($user->isUserInfocenter() && isset($user->infocenter) && ($user->infocenter->nodo_id != $request->input('txtnodoinfocenter')))
                || ($user->isUserIngreso() && isset($user->ingreso) && ($user->ingreso->nodo_id != $request->input('txtnodoingreso')))
                || ($user->isUserApoyoTecnico() && isset($user->apoyotecnico) && ($user->apoyotecnico->nodo_id != $request->input('txtnodouser')))
            ) {
                Notification::send($userUpdate, new NodeChanged($userUpdate));
            }
            return response()->json([
                'state' => 'success',
                'message' => 'El Usuario ha sido modificado satisfactoriamente',
                'url' => route('usuarios.show', $userUpdate->documento),
                'user' => $userUpdate,
            ]);
        }
    }

    public function edit($document)
    {
        $user = User::withTrashed()->where('documento', $document)->firstOrFail();
        if (request()->user()->cannot('update', $user)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        return view('users.edit', [
            'user' => $user,
            'etnias' => Etnia::pluck('nombre', 'id'),
            'tiposdocumentos' => $this->userRepository->getAllTipoDocumento(),
            'gradosescolaridad' => $this->userRepository->getSelectAllGradosEscolaridad(),
            'gruposanguineos' => $this->userRepository->getAllGrupoSanguineos(),
            'eps' => $this->userRepository->getAllEpsActivas(),
            'departamentos' => $this->userRepository->getAllDepartamentos(),
            'ocupaciones' => $this->userRepository->getAllOcupaciones(),
            'view' => 'edit'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateAccountUser(Request $request, ProfileRepository $profileRepostory, $id)
    {
        $user = User::withTrashed()->find($id);
        if (request()->user()->cannot('updateProfile', $user)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }

        $req = new UserFormEditRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());

        if ($validator->fails()) {
            return response()->json([
                'state' => 'error_form',
                'fail' => true,
                'errors' => $validator->errors(),
            ]);
        } else {
            if ($user != null) {
                $userUpdate = $profileRepostory->Update($request, $user);
                return response()->json([
                    'state' => 'success',
                    'message' => 'La cuenta del usuario ha sido actualizada exitosamente.',
                    'url' => route('usuarios.show', $userUpdate->documento),
                    'user' => $userUpdate,
                ]);
            } else {
                return response()->json([
                    'state' => 'error',
                    'message' => 'El Usuario no se ha modificado',
                    'url' => redirect()->back()
                ]);
            }
        }
    }


    public function generatePassword(int $document)
    {
        $user = User::withTrashed()->where('documento', $document)->firstOrFail();
        if (request()->user()->cannot('generatePassword', $user)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        return $this->userRepository->generateNewPasswordToUser($user);
    }

    /**
     * Display the specified resource of talents.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function filterTalento($documento)
    {
        $user = User::withTrashed()
            ->with(['talento'])
            ->role(User::IsTalento())
            ->where('documento', $documento)
            ->first();

        if (request()->ajax()) {

            if ($user != null) {
                return response()->json([
                    'data' => [
                        'user' => $user,
                        'status_code' => Response::HTTP_OK
                    ]
                ], Response::HTTP_OK);
            }

            return response()->json([
                'data' => [
                    'user' => null,
                    'status_code' => Response::HTTP_NOT_FOUND,
                ]
            ]);
        }
        return view('users.show', ['user' => $user]);
    }

    public function findUserById(int $id)
    {
        return response()->json([
            'user' => User::withTrashed()->with(['gestor', 'gestor.lineatecnologica'])->where('id', $id)->first(),
        ]);
    }


    public function gestoresByNodo($nodo = null)
    {
        $gestores = User::select('gestores.id', 'users.id AS user_id')
            ->selectRaw('CONCAT(users.documento, " - ", users.nombres, " ", users.apellidos) as nombre')
            ->join('gestores', 'gestores.user_id', 'users.id')
            ->role(User::IsExperto())
            ->where('gestores.nodo_id', $nodo)
            ->withTrashed()
            ->get();

        return response()->json([
            'gestores' => $gestores
        ]);
    }
}
