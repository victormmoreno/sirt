<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Repository\UserRepository\UserRepository;
use App\Http\Requests\UsersRequests\RoleContratInformationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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
            $response = $this->saveRoleContract($request,$user);
            if($response){
                return response()->json([
                    'data' => [
                        'fail'   => false,
                        'url' => route('usuario.show', $user->documento),
                        'errors' => [],
                    ],
                ]);
            }else{
                return response()->json([
                    'data' => [
                        'fail'   => false,
                        'errors' => [],
                    ]
                ]);
            }
        }
    }

    protected function saveRoleContract(Request $request, $user)
    {
        DB::beginTransaction();
        try {
            $user->saveInformationOfficer($request);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
}
