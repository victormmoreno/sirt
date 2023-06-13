<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Repository\UserRepository\UserRepository;
use App\Http\Requests\UsersRequests\RoleContratInformationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Strategies\User\OfficerStorage\ActivatorOfficerStorage;


class ChangeRolesController extends Controller
{
    public $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('auth');
    }

    /**
     * todo
     * Display the view for to update node and roles to specified resource (user).
     * @param int $documento
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|Response|\Illuminate\View\View
     */
    public function  showRolesForm($document)
    {
        $user = $this->userRepository->findUserByDocumentEloquent($document)->firstOrFail();
        if (request()->user()->cannot('updateRoles', $user)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        return view('users.permissions', [
            'user'            => $user,
            'roles'           => $this->userRepository->getAllRoles(),
            'nodos'           => $this->userRepository->getAllNodo(),
            'tipotalentos'    => $this->userRepository->getAllTipoTalento(),
            'regionales'      => $this->userRepository->getAllRegionales(),
            'tipoformaciones' => $this->userRepository->getAllTipoFormaciones(),
            'tipoestudios'    => $this->userRepository->getAllTipoEstudios(),
            'lineas'          => $this->userRepository->getAllLineas()
        ]);
    }

    /**
     * todo
     * Update node and roles to specified resource (user).
     * @param int $documento
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|Response|\Illuminate\View\View
     */
    public function updateRoles(Request $request, int $document)
    {
        $user = $this->userRepository->findUserByDocumentEloquent($document)->firstOrFail();
        if (request()->user()->cannot('updateRoles', $user)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $req = new RoleContratInformationRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'fail'   => true,
                    'errors' => $validator->errors(),
                ]
            ]);
        } else {
            return response()->json([
                'data' => [
                    'fail'   => true,
                    'errors' => $this->saveRoleContract($request,$user ),
                ]
            ]);
        }

    }

    protected function saveRoleContract(Request $request, $user )
    {
        $roles = is_array($request->role) ? $request->role : explode(', ', $request->role);
        $roles = collect($roles)
            ->flatten()
            ->map(function ($role) use($request, $user) {
                if (empty($role)) {
                    return false;
                }
                if($role == \App\User::IsActivador()){
                    // return $user->activatorContractCurrentYear;
                    // $request->merge();
                    $infoContract =  (new ActivatorOfficerStorage)->buildStorageRecord($request);
                    $user->activatorContractCurrentYear()->updateOrCreate(
                        // ['user_nodo_id' => $parent_id],
                        [
                            'codigo' =>  $infoContract['codigo'],
                            'fecha_inicio' => $infoContract['fecha_inicio'],
                            'fecha_finalizacion' => $infoContract['fecha_finalizacion'],
                            'valor_contrato' => $infoContract['valor_contrato'],
                            'vinculacion' => $infoContract['vinculacion'],
                            'honorarios' => $infoContract['honorarios']
                        ]
                    );
                    return $user->activatorContractCurrentYear;
                }
                return $role;
            })->filter(function ($role) {
                // if($role == \App\User::IsActivador()){
                //     return "Julian";
                // }
                return $role;
            });
        return $roles;
    }

}
