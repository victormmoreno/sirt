<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest\{ChangePasswordRequest, ProfileFormRequest};
use App\Http\Traits\ProfileTrait\SendsPasswordResetEmailsToUserAuthenticated;
use App\Repositories\Repository\{ProfileRepository\ProfileRepository, UserRepository\UserRepository};
use App\User;
use App\Models\Etnia;
use Illuminate\Http\Request;
use Illuminate\Support\{Facades\Validator};
use PDF;

class ProfileController extends Controller
{

    use SendsPasswordResetEmailsToUserAuthenticated;

    public $userRepository;
    public $profileRepostory;

    public function __construct(UserRepository $userRepository, ProfileRepository $profileRepostory)
    {
        $this->middleware(['auth', 'check_profile']);
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
        $authUser = $this->getAuthUserAccount();
        $this->authorize('viewProfile', $authUser);
        return view('users.profile.profile', [
            'user' => $authUser,
        ]);

    }

    public function roles()
    {
        $authUser = $this->getAuthUserAccount();
        $this->authorize('viewProfileRole', $authUser);
        return view('users.profile.roles', [
            'user'  => $authUser,
            'roles' => $this->userRepository->getAllRoles(),
        ]);
    }

    public function account()
    {
        $authUser = $this->getAuthUserAccount();
        $this->authorize('viewProfileAccountPassword', $authUser);
        return view('users.profile.account', [
            'user' => $authUser,
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
        $authUser = $this->getAuthUserAccount();

        $this->authorize('editAccount', $authUser);

        return view('users.profile.edit', [
            'user'              => $authUser,
            'etnias' => Etnia::pluck('nombre', 'id'),
            'tiposdocumentos'   => $this->userRepository->getAllTipoDocumento(),
            'gradosescolaridad' => $this->userRepository->getSelectAllGradosEscolaridad(),
            'gruposanguineos'   => $this->userRepository->getAllGrupoSanguineos(),
            'eps'               => $this->userRepository->getAllEpsActivas(),
            'departamentos'     => $this->userRepository->getAllDepartamentos(),
            'ocupaciones'       => $this->userRepository->getAllOcupaciones(),
            'view' => 'edit'
        ]);
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
        //buscar usuario por su id
        $user = User::find($id);

        if($user == null){
            $user = User::onlyTrashed()->find($id);
        }
        $this->authorize('updateProfile', $user);

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
                //acutalizar usuario
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



        
        // $userUpdated = $this->profileRepostory->Update($request, $user);

        // if ($userUpdated != null) {
        //     $this->userRepository->destroySessionUser();
        //     return redirect()->route('login')->withSuccess('Tu perfil ha sido actualizado exitosamente.');
        // }

        // return redirect()->back()->with('error', 'error al actualizar tu perfil, intentalo de nuevo.');

    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        $authUser = $this->getAuthUserFindById();
        $this->authorize('updatePassword', $authUser);

        $userPasswordUpdated = $this->profileRepostory->updatePassword($request, $authUser);

        if ($userPasswordUpdated != null) {
            $this->userRepository->destroySessionUser();
            return redirect()->route('login')->withSuccess('Contraseña modificada, ya puedes iniciar sesión');

        }

        return redirect()->back()->with('error', 'error al actualizar tu contraseña, intentalo de nuevo');
    }

    /*================================================================================
    =            metodo para descargar certificado registro en plataforma            =
    ================================================================================*/

    public function downloadCertificatedPlataform($extennsion = '.pdf', $orientacion = 'portrait')
    {
        $this->authorize('downloadCertificatedPlataform', User::class);

        $user = $this->getAuthUserFindById();

        $pdf = PDF::loadView('pdf.certificado-plataforma.certificado', compact('user'));

        $pdf->setPaper(strtolower('LETTER'), $orientacion = 'landscape');

        $pdf->setEncryption($user->documento);

        return $pdf->download("certificado  " . config('app.name') . $extennsion);
    }

    /*=====  End of metodo para descargar certificado registro en plataforma  ======*/

}
