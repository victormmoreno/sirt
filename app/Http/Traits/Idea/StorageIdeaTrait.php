<?php

namespace App\Http\Traits\Idea;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\{IdeaFormRequest, EmpresaFormRequest};
// use App\Http\Traits\Idea\CompleteIdeaInformationTrait;
use App\Http\Traits\Idea\EnviarPostulacionIdeaTrait;
use App\Models\Idea;
use App\Repositories\Repository\EmpresaRepository;
use App\Repositories\Repository\IdeaRepository;
// use App\Http\Requests\UsersRequests\CompletiesTalentInformationRequest;
// use App\Http\Controllers\User\RolesPermissions;

trait StorageIdeaTrait
{
    // use CompleteIdeaInformationTrait;
    use EnviarPostulacionIdeaTrait, CompleteIdeaInformationTrait;

    private $ideaRepository;

    public function __construct(IdeaRepository $ideaRepository, EmpresaRepository $empresaRepository)
    {
        $this->ideaRepository = $ideaRepository;
        $this->empresaRepository = $empresaRepository;
    }

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
        if ($request->input('check_idea_empresa') == 1) {
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
        $structure = $this->buildStorageRecord($request);
        $idea = Idea::create($structure);
        $this->sendNotificacionPostulado($request, $idea);
        return response()->json([
            'state' => 'registro',
            'url' => route('idea.detalle', $idea->id),
            'msg' => 'La idea se ha registrado exitosamente!',
            'title' => 'Registro exitoso!',
            'type' => 'success',
        ]);
    }




    public function update(Request $request, $id)
    {
        $empresa = null;
        $idea = $this->ideaRepository->findByid($id);
        if(!request()->user()->can('update', $idea)) {
            alert('No autorizado', 'No tienes permisos para cambiar la información de esta idea de proyecto', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        if ($request->input('check_idea_empresa') == 1) {
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
        $structure = $this->buildStorageRecord($request, $idea);
        $idea->update($structure);
        $this->sendNotificacionPostulado($request, $idea);
        return response()->json([
            'state' => 'registro',
            'url' => route('idea.detalle', $idea->id),
            'msg' => 'La idea se ha registrado exitosamente!',
            'title' => 'Registro exitoso!',
            'type' => 'success',
        ]);
    }

    /**
     * Envio de notificación
     *
     * @param Request $request
     * @return void
     * @author dum
     **/
    public function sendNotificacionPostulado(Request $request = null, $idea)
    {
        if ($request->txtopcionRegistro != "guardar") {
            $this->updateToPostulado($idea);
            // $this->sendEmailToUser($idea);
            $this->sendNotificationToArticuladores($idea);
            $this->registerHistory($idea);
        }
    }

}
