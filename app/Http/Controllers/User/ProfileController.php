<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest\ChangePasswordRequest;
use App\Http\Requests\ProfileRequest\ProfileFormRequest;
use App\Repositories\Repository\ProfileRepository\ProfileRepository;
use App\Repositories\Repository\UserRepository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public $userRepository;
    public $profileRepostory;

    public function __construct(UserRepository $userRepository, ProfileRepository $profileRepostory)
    {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
        $this->profileRepostory = $profileRepostory;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // dd($this->userRepository->getRoleWhereInRole(array('Administrador' => 'Administrador','Dinamizador' => 'Dinamizador', 'Gestor' =>'Gestor' )));
        return view('users.profile.profile',[
            'user' => $this->userRepository->account(auth()->user()->documento),
        ]);

    }

    public function roles()
    {
        return view('users.profile.roles',[
            'user' => $this->userRepository->account(auth()->user()->documento),
            'roles' => $this->userRepository->getAllRoles(),
        ]);
    }


    public function permisos()
    {
        return view('users.profile.permisos',[
            'user' => $this->userRepository->account(auth()->user()->documento),
        ]);
    }

    public function account()
    {
        return view('users.profile.account',[
            'user' => $this->userRepository->account(auth()->user()->documento),
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($documento)
    {
        return view('users.profile.edit',[
            'user' => $this->userRepository->account($documento),
            'tiposdocumentos'   => $this->userRepository->getAllTipoDocumento(),
            'gradosescolaridad' => $this->userRepository->getSelectAllGradosEscolaridad(),
            'gruposanguineos'   => $this->userRepository->getAllGrupoSanguineos(),
            'eps'               => $this->userRepository->getAllEpsActivas(),
            'departamentos'     => $this->userRepository->getAllDepartamentos(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileFormRequest $request, $id)
    {   
        //buscar usuario por su id
        $user = $this->userRepository->findById($id);
        //acutalizar usuario
        $userUpdated = $this->profileRepostory->Update($request, $user);
        //alerta
        alert()->success('Modificación Exitosa',"El Usuario {$userUpdated->nombre_completo } ha sido  modificado.","success")
                ->showConfirmButton('Ok', '#009891')->toHtml();
        //rediccion
        // Auth::logout();
        //  return redirect()->route('login'); 
        return redirect()->route('perfil.index');

    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        $user = $this->userRepository->findById(auth()->user()->id);

        $userPasswordUpdated = $this->profileRepostory->updatePassword($request, $user);

        alert()->success('Modificación Exitosa',"su contraseña se ha actualizado","success")
                ->showConfirmButton('Ok', '#009891')->toHtml();

        return redirect()->route('perfil.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
