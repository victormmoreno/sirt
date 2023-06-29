<?php

namespace App\Http\Controllers\User;


use App\Helpers\AuthRoleHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequests\UserFormEditRequest;
use App\Models\{Etnia, Nodo};
use App\Repositories\Repository\{UserRepository\UserRepository, ProfileRepository\ProfileRepository};
use App\User;
use Illuminate\Http\Request;
use App\Datatables\UserDatatable;
use Illuminate\Support\{Facades\Validator};
use Illuminate\Http\Response;


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
                    ->selectRaw('concat(users.nombres, " ",users.apellidos) as usuario, GROUP_CONCAT(distinct roles.name SEPARATOR ", ") as roles')
                    ->selectRaw("if(entidades.nombre is null, 'No Aplica', entidades.nombre) as nodo")
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
                $role = [
                            User::IsExperto(),
                            User::IsArticulador(),
                            User::IsInfocenter(),
                            User::IsIngreso(),
                            User::IsApoyoTecnico(),
                            User::IsTalento(),
                            User::IsUsuario()
                        ];
                return view('users.index', [
                    'roles' => $this->userRepository->getRoleWhereInRole($role),
                ]);
                break;
            case User::IsArticulador():
                $role = [User::IsExperto(), User::IsUsuario(), User::IsTalento()];
                return view('users.index', [
                    'roles' => $this->userRepository->getRoleWhereInRole($role),
                ]);
                break;
            case User::IsExperto():
                $role = [User::IsUsuario(), User::IsTalento()];
                return view('users.index', [
                    'roles' => $this->userRepository->getRoleWhereInRole($role),
                ]);
                break;
            case User::IsInfocenter():
                $role = [User::IsExperto(), User::IsArticulador(), User::IsInfocenter(), User::IsTalento(), User::IsIngreso(), User::IsApoyoTecnico(), User::IsUsuario()];
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
     * Display the specified resource.
     * @param int $documento
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|Response|\Illuminate\View\View
     */
    public function show($documento)
    {
        $user = $this->userRepository->findUserByDocumentBuilder($documento)->firstOrFail();
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

    public function getCustomersDatatableFormat()
    {
        if (request()->ajax()) {
            $talents = User::ConsultarUsuarios()
                ->get();
            return datatables()->of($talents)
                ->addColumn('add_proyecto', function ($data) {
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
                    'url' => route('usuario.show', $userUpdate->documento),
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
}
