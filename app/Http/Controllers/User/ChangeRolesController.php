<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Repository\UserRepository\UserRepository;
use App\Http\Requests\UsersRequests\RoleContratInformationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Strategies\User\OfficerStorage\ActivatorOfficerStorage;
use App\Strategies\User\OfficerStorage\DynamizerOfficerStorage;
use App\Strategies\User\OfficerStorage\ExpertOfficerStorage;
use App\Strategies\User\OfficerStorage\ArticulatorOfficerStorage;
use App\Strategies\User\OfficerStorage\TechnicalSupportOfficerStorage;
use App\Strategies\User\OfficerStorage\InfocenterOfficerStorage;
use App\Strategies\User\OfficerStorage\IncomeOfficerStorage;
use App\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

    protected function saveRoleContract(Request $request, $user )
    {
        $roles = is_array($request->role) ? $request->role : explode(', ', $request->role);
        DB::beginTransaction();
        try {
            $roles = collect($roles)
            ->flatten()
            ->map(function ($role) use($request, $user) {
                if (empty($role)) {
                    return false;
                }
                if($role == User::IsActivador())
                {
                    return (new ActivatorOfficerStorage)->save($request, $user);
                }
                if($role == User::IsDinamizador())
                {
                    return (new DynamizerOfficerStorage)->save($request, $user);
                }
                if($role == User::IsExperto())
                {
                    return (new ExpertOfficerStorage)->save($request, $user);
                }
                if($role == User::IsArticulador())
                {
                    return (new ArticulatorOfficerStorage)->save($request, $user);
                }
                if($role == User::IsApoyoTecnico())
                {
                    return (new TechnicalSupportOfficerStorage)->save($request, $user);
                }
                if($role == User::IsInfocenter())
                {
                    return (new InfocenterOfficerStorage)->save($request, $user);
                }
                if($role == User::IsIngreso())
                {
                    return (new IncomeOfficerStorage)->save($request, $user);
                }
                if($role == User::IsTalento())
                {
                    if($request->talent_type == 1){
                        $request->merge([
                            'tipo_talento' => 'aprendiz_sena_con_apoyo_de_sostenimiento',
                            'regional' => $request->regional,
                            'centro_formacion' => $request->training_center,
                            'programa_formacion' => $request->training_program,
                        ]);
                    }
                    else if($request->talent_type == 2){
                        $request->merge([
                            'tipo_talento' => 'aprendiz_sena_sin_apoyo_de_sostenimiento',
                            'regional' => $request->regional,
                            'centro_formacion' => $request->training_center,
                            'programa_formacion' => $request->training_program
                        ]);
                    }
                    else if($request->talent_type  == 3){
                        $request->merge([
                            'tipo_talento' => 'egresado_sena',
                            'regional' => $request->regional,
                            'centro_formacion' => $request->training_center,
                            'programa_formacion' => $request->training_program,
                            'tipo_formacion' => $request->formation_type,
                        ]);
                    }
                    else if($request->talent_type == 7)
                    {
                        $request->merge([
                            'tipo_talento' => 'emprendedor'
                        ]);
                    }
                    else if($request->talent_type == 8){
                        $request->merge([
                            'tipo_talento' => 'estudiante_universitario',
                            'tipo_estudio' => $request->study_type,
                            'universidad' => $request->university,
                            'carrera' => $request->career,
                        ]);
                    }
                    else if($request->talent_type == 9){
                        $request->merge([
                            'tipo_talento' => 'funcionario_de_empresa',
                            'empresa' => $request->company
                        ]);
                    }
                    else if($request->talent_type == 5){
                        $request->merge([
                            'tipo_talento' => 'funcionario_sena',
                            'regional' => $request->regional,
                            'centro_formacion' => $request->training_center,
                            'dependencia' => $request->dependency
                        ]);
                    }
                    else if($request->talent_type == 4){
                        $request->merge([
                            'tipo_talento' => 'instructor_sena',
                            'regional' => $request->regional,
                            'centro_formacion' => $request->training_center,
                        ]);
                    }
                    else if($request->talent_type == 6){
                        $request->merge([
                            'tipo_talento' => 'propietario_empresa',
                            'empresa' => $request->company
                        ]);
                    }
                    return $user->saveInformationTalent($request);
                }
                return $role;
            })->filter(function ($role) {
                return $role;
            });
            $user->syncRoles($request->role);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
        }

}
