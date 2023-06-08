<?php

namespace App\Http\Traits\User;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UsersRequests\CompletiesTalentInformationRequest;
use App\Http\Controllers\User\RolesPermissions;
use Illuminate\Http\JsonResponse;
use App\Events\User\CompletedTalentInformation;
use App\Models\TipoTalento;

trait CompletiesTalentInformation
{
    use RedirectsUsers;

    /**
     * Show the email complete talent information notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user = $this->userRepository->findUserByDocumentEloquent($request->user()->documento)->firstOrFail();
        return $request->user()->hasCompletedTalentInformation()
                        ? redirect($this->redirectPath())
                        : view('users.complete-talent-information', [
                            'user'            => $user,
                            'tipotalentos'    => $this->userRepository->getAllTipoTalento(),
                            'regionales'      => $this->userRepository->getAllRegionales(),
                            'tipoformaciones' => $this->userRepository->getAllTipoFormaciones(),
                            'tipoestudios'    => $this->userRepository->getAllTipoEstudios(),
                            'lineas'          => $this->userRepository->getAllLineas()
                        ]);
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function complete(Request $request)
    {
        $req = new CompletiesTalentInformationRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'fail'   => true,
                    'errors' => $validator->errors(),
                ]
            ]);
        } else {
            if ($request->user()->hasCompletedTalentInformation()) {
                return response()->json([
                    'data' => [
                        'fail'   => false,
                        'url' => route('home'),
                        'errors' => [],
                    ],
                ]);
            }
            $request = $this->buildMergeRequest($request);

            $request->user()->saveInformationTalent($request);
            $request->merge([
                'role' => \App\User::IsTalento()
            ]);
            RolesPermissions::changeRoleSession($request);
            return response()->json([
                'data' => [
                    'fail'   => false,
                    'url' => route('home'),
                    'errors' => [],
                ],
            ]);
        }

    }

    private function buildMergeRequest($request)
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
                'programa_formacion' => $request->training_program,
            ]);
        }
        else if($request->talent_type == 3){
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
        return $request;
    }
}
