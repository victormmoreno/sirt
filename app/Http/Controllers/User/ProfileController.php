<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest\ChangePasswordRequest;
use App\Http\Requests\ProfileRequest\ProfileFormRequest;
use App\Http\Traits\ProfileTrait\SendsPasswordResetEmailsToUserAuthenticated;
use App\Repositories\Repository\ProfileRepository\ProfileRepository;
use App\Repositories\Repository\UserRepository\UserRepository;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;


class ProfileController extends Controller 
{

    use SendsPasswordResetEmailsToUserAuthenticated;

    public $userRepository;
    public $profileRepostory;

    public function __construct(UserRepository $userRepository, ProfileRepository $profileRepostory)
    {
        $this->middleware('auth');
        $this->userRepository   = $userRepository;
        $this->profileRepostory = $profileRepostory;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('users.profile.profile', [
            'user' => $this->userRepository->account(auth()->user()->id),
        ]);

    }

    public function roles()
    {
        return view('users.profile.roles', [
            'user'  => $this->userRepository->account(auth()->user()->id),
            'roles' => $this->userRepository->getAllRoles(),
        ]);
    }

    public function permisos()
    {
        return view('users.profile.permisos', [
            'user' => $this->userRepository->account(auth()->user()->id),
        ]);
    }

    public function account()
    {
        return view('users.profile.account', [
            'user' => $this->userRepository->account(auth()->user()->id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editAccount()
    {
        $user = $this->userRepository->account(auth()->user()->id);

        $this->authorize('update',$user);

        return view('users.profile.edit', [
            'user'              => $user,
            'tiposdocumentos'   => $this->userRepository->getAllTipoDocumento(),
            'gradosescolaridad' => $this->userRepository->getSelectAllGradosEscolaridad(),
            'gruposanguineos'   => $this->userRepository->getAllGrupoSanguineos(),
            'eps'               => $this->userRepository->getAllEpsActivas(),
            'departamentos'     => $this->userRepository->getAllDepartamentos(),
            'ocupaciones'       => $this->userRepository->getAllOcupaciones(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileFormRequest $request,$id)
    {

        //buscar usuario por su id
        $user = $this->userRepository->findById(auth()->user()->id);
        $this->authorize('update',$user);
        //acutalizar usuario
        $userUpdated = $this->profileRepostory->Update($request, $user);

        if ($userUpdated != null) {
            $this->userRepository->destroySessionUser();
            return redirect()->route('login')->withSuccess('Tu perfil ha sido actualizado exitosamente.');
        }

        return redirect()->back()->with('error', 'error al actualizar tu contraseña, intentalo de nuevo');

        

    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        $user = $this->userRepository->findById(auth()->user()->id);

        $userPasswordUpdated = $this->profileRepostory->updatePassword($request, $user);

        if ($userPasswordUpdated != null) {
            $this->userRepository->destroySessionUser();
            return redirect()->route('login')->withSuccess('Contraseña modificada, ya puedes iniciar sesión');

        }

        return redirect()->back()->with('error', 'error al actualizar tu contraseña, intentalo de nuevo');
    }

}
