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
use Barryvdh\DomPDF\Facade as PDF;

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
     * Show a resource for the profile.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $authUser = $this->getAuthUserAccount();
        if (request()->user()->cannot('viewProfile', $authUser)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        return view('users.profile.profile', ['user' => $authUser]);
    }

    public function roles()
    {
        $authUser = $this->getAuthUserAccount();
        if (request()->user()->cannot('viewProfile', $authUser)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        return view('users.profile.roles', [
            'user'  => $authUser,
            'roles' => $this->userRepository->getAllRoles(),
        ]);
    }

    public function account()
    {
        $authUser = $this->getAuthUserAccount();
        if (request()->user()->cannot('viewProfile', $authUser)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
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
        if (request()->user()->cannot('viewProfile', $authUser)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
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
        $authUser = $this->getAuthUserFindById();
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

    public function downloadCertificatedPlataform($extennsion = '.pdf', $orientacion = 'portrait')
    {
        $user = User::withTrashed()->where('documento', auth()->user()->documento)->firstOrFail();
        if (request()->user()->cannot('downloadCertificatedPlataform', $user)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $pdf = PDF::loadView('pdf.certificado-plataforma.certificado', compact('user'));
        $pdf->setPaper(strtolower('LETTER'),  $orientacion = 'landscape');
        $pdf->setEncryption($user->documento);
        return $pdf->download("certificado  " . config('app.name') . $extennsion);
    }

    public function activities()
    {
        $user = User::withTrashed()->find(auth()->user()->id);
        if (request()->user()->cannot('viewActivities', $user)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        if (\Session::get('login_role') == User::IsTalento()) {
            $actividades = $user->talento->articulacionproyecto()
                ->with([
                    'actividad' => function ($query) {
                        $query->orderBy('fecha_inicio', 'DESC');
                    }
                ])->paginate(10);
        }
        if (\Session::get('login_role') == User::IsGestor()) {

            $actividades = $user->gestor->actividades()
                ->with(['articulacion_proyecto.proyecto'])
                ->orderBy('fecha_inicio', 'DESC')->paginate(10);
        }
        return view('users.profile.actividad', ['user' => $user, 'actividades' => $actividades]);
    }
}
