<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest\{ChangePasswordRequest, ProfileFormRequest};
use App\Http\Traits\ProfileTrait\SendsPasswordResetEmailsToUserAuthenticated;
use App\Repositories\Repository\{ProfileRepository\ProfileRepository, UserRepository\UserRepository};
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\User\Profilable;


class ProfileController extends Controller
{
    use Profilable, SendsPasswordResetEmailsToUserAuthenticated;

    public $userRepository;
    public $profileRepostory;

    public function __construct(UserRepository $userRepository, ProfileRepository $profileRepostory)
    {
        $this->middleware(['auth']);
        $this->userRepository   = $userRepository;
        $this->profileRepostory = $profileRepostory;
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
        $user = User::withTrashed()->findOrFail($id);
        if (request()->user()->cannot('updateProfile', $user)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $req       = new ProfileFormRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'state'   => 'error_form',
                'fail'   => true,
                'errors' => $validator->errors(),
            ]);
        } else {
            if ($user != null) {
                $userUpdate = $this->profileRepostory->Update($request, $user);
                return response()->json([
                    'state'   => 'success',
                    'message' => 'Tu perfil ha sido actualizado exitosamente.',
                    'url' => route('login'),
                    'user' => $userUpdate,
                ]);
            } else {
                return response()->json([
                    'state'   => 'error',
                    'message' => 'El Usuario no se ha modificado',
                    'url' => redirect()->back()
                ]);
            }
        }
    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        $authUser = $this->getAuthUserFindByIdEloquent();
        if (request()->user()->cannot('updatePassword', $authUser)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $userPasswordUpdated = $this->profileRepostory->updatePassword($request, $authUser);
        if ($userPasswordUpdated != null) {
            $this->userRepository->destroySessionUser();
            return redirect()->route('login')->withSuccess('Contraseña modificada, ya puedes iniciar sesión');
        }
        return redirect()->back()->with('error', 'error al actualizar tu contraseña, intentalo de nuevo');
    }
}
