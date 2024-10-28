<?php

namespace App\Http\Traits\Idea;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\{IdeaFormRequest, EmpresaFormRequest};
use App\Http\Traits\Idea\CompleteIdeaInformationTrait;
use App\Models\Idea;
// use App\Http\Requests\UsersRequests\CompletiesTalentInformationRequest;
// use App\Http\Controllers\User\RolesPermissions;

trait StorageIdeaTrait
{
    use CompleteIdeaInformationTrait;
    // use RedirectsUsers;

    // /**
    //  * Show the email complete talent information notice.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(Request $request)
    // {
    //     $user = $this->userRepository->findUserByDocumentEloquent($request->user()->documento)->firstOrFail();
    //     return $request->user()->hasCompletedTalentInformation()
    //         ? redirect($this->redirectPath())
    //         : view('users.complete-talent-information', [
    //             'user'            => $user,
    //             'tipotalentos'    => $this->userRepository->getAllTipoTalento(),
    //             'regionales'      => $this->userRepository->getAllRegionales(),
    //             'tipoformaciones' => $this->userRepository->getAllTipoFormaciones(),
    //             'tipoestudios'    => $this->userRepository->getAllTipoEstudios(),
    //             'lineas'          => $this->userRepository->getAllLineas(),
    //             'ocupaciones' => $this->userRepository->getAllOcupaciones(),
    //         ]);
    // }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $empresa = null;
        if ($request->input('txtidea_empresa') == 1) {
            // Idea con empresa
            $empresa = $this->empresaRepository->consultarEmpresaParams($request->input('txtnit'), 'nit')->first();
            if ($empresa == null) {
                $req_empresa = new EmpresaFormRequest;
                $validar_empresa = Validator::make($request->all(), $req_empresa->rules(), $req_empresa->messages());
                if ($validar_empresa->fails()) {
                return response()->json([
                    'state'   => 'error_form',
                    'errors' => $validar_empresa->errors(),
                ]);
                }
            }
        }

        if ($request->input('txtopcionRegistro') == "guardar") {
            // dd('aqui estamos');
            $req = new IdeaFormRequest($request->input('txtopcionRegistro'), $empresa);
            $validator = Validator::make($request->all(), $req->rules(), $req->messages());
            if ($validator->fails()) {
                return response()->json([
                    'state'   => 'error_form',
                    'errors' => $validator->errors(),
                ]);
            }
            // $clase = new CompleteIdeaInformationTrait;
            // dd($clase);
            $structure = $this->buildStorageRecord($request);
            // dd($structure);
            // exit;
            Idea::create($structure);
            exit;
        } else {
            $req = new IdeaFormRequest($request->input('txtopcionRegistro'), $empresa);
            $validator = Validator::make($request->all(), $req->rules(), $req->messages());
            if ($validator->fails()) {
                return response()->json([
                    'state'   => 'error_form',
                    'errors' => $validator->errors(),
                    'title' => 'Error',
                    'msg' => 'Estas ingresando mal los datos',
                    'type' => 'error'
                ]);
            }
            $result = $this->ideaRepository->storeAndPostular($request);
        }
        if ($result['state']) {
            return response()->json([
                'state' => 'registro',
                'url' => route('idea.detalle', $result['idea']->id),
                'title' => $result['title'],
                'msg' => $result['msg'],
                'type' => $result['type']
                ]);
        } else {
            return response()->json([
                'state' => 'no_registro',
                'title' => $result['title'],
                'msg' => $result['msg'],
                'type' => $result['type']
            ]);
        }
    }

}
