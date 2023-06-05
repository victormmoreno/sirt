<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Repository\UserRepository\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


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
    public function updateRoles(Request $request, int $documento)
    {
        $user = User::withTrashed()->where('documento', $documento)->firstOrFail();
        if (request()->user()->cannot('updateRoles', $user)) {
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

                $removeRole = array_diff(collect($user->getRoleNames())->toArray(), $request->input('role'));

                // return response()->json([
                //     'state' => 'success',
                //     'message' => 'El Usuario ha sido modificado satisfactoriamente',
                //     'url' => route('usuario.show', $userUpdate->documento),
                //     'user' => $userUpdate,
                // ]);

            }
            if (($user->isUserDinamizador() && isset($user->dinamizador) && ($user->dinamizador->nodo_id != $request->input('txtnododinamizador')))
                || ($user->isUserInfocenter() && isset($user->infocenter) && ($user->infocenter->nodo_id != $request->input('txtnodoinfocenter')))
                || ($user->isUserIngreso() && isset($user->ingreso) && ($user->ingreso->nodo_id != $request->input('txtnodoingreso')))
                || ($user->isUserApoyoTecnico() && isset($user->apoyotecnico) && ($user->apoyotecnico->nodo_id != $request->input('txtnodouser')))
            ) {
            }
            // return response()->json([
            //     'state' => 'success',
            //     'message' => 'El Usuario ha sido modificado satisfactoriamente',
            //     'url' => route('usuario.show', $userUpdate->documento),
            //     'user' => $userUpdate,
            // ]);
        }
    }

}
