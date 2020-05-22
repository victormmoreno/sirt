<?php

namespace App\Http\Traits\UserTrait;

use App\Events\User\UserWasRegistered;
use App\Http\Requests\UsersRequests\UserFormRequest;
use App\Models\{Nodo, TipoTalento, TipoFormacion, TipoEstudio, Etnia, LineaTecnologica};
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait RegistersUsers
{
    /**
     * mostrar el formulario para crear un nuevo usuario.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($document = null)
    {
        if ($document == null) {
            $document = null;
        } else {
            $user = $this->userRepository->findUserByDocument($document)->first();
            if ($user != null) {
                abort('404');
            }
        }

        $this->authorize('create', User::class);

        $roles = null;
        $nodo  = null;

        switch (session()->get('login_role')) {
            case User::IsAdministrador():

                $roles = $this->userRepository->getRoleWhereInRole([User::IsAdministrador(), User::IsDinamizador()]);
                $nodo  = $this->userRepository->getAllNodo();

                break;

            case User::IsDinamizador():

                $roles = $this->userRepository->getRoleWhereNotInRole([User::IsAdministrador(), User::IsDinamizador(), User::IsTalento(), User::IsDesarrollador()]);
                $nodo  = Nodo::nodoUserAthenticated(auth()->user()->dinamizador->nodo->id)->pluck('nombre', 'id');

                break;
            case User::IsGestor():

                $roles = $this->userRepository->getRoleWhereInRole([User::IsTalento()]);
                $nodo  = Nodo::nodoUserAthenticated(auth()->user()->gestor->nodo->id)->pluck('nombre', 'id');

                return view('users.create', [
                    'etnias' => Etnia::pluck('nombre', 'id'),
                    'tiposdocumentos'   => $this->userRepository->getAllTipoDocumento(),
                    'gradosescolaridad' => $this->userRepository->getSelectAllGradosEscolaridad(),
                    'gruposanguineos'   => $this->userRepository->getAllGrupoSanguineos(),
                    'eps'               => $this->userRepository->getAllEpsActivas(),
                    'departamentos'     => $this->userRepository->getAllDepartamentos(),
                    'ocupaciones'       => $this->userRepository->getAllOcupaciones(),
                    'roles'             => $roles,
                    'nodos'             => $nodo,
                    'regionales'        => $this->userRepository->getAllRegionales(),
                    'documento' => $document,
                    'tipotalentos' => TipoTalento::pluck('nombre', 'id'),
                    'tipoformaciones' => TipoFormacion::pluck('nombre', 'id'),
                    'tipoestudios' => TipoEstudio::pluck('nombre', 'id'),
                    'lineas' => LineaTecnologica::pluck('nombre', 'id'),
                    'view' => 'create'
                ]);
                break;
            default:
                abort('404');
                break;
        }


        return view('users.create', [
            'etnias' => Etnia::pluck('nombre', 'id'),
            'tiposdocumentos'   => $this->userRepository->getAllTipoDocumento(),
            'gradosescolaridad' => $this->userRepository->getSelectAllGradosEscolaridad(),
            'gruposanguineos'   => $this->userRepository->getAllGrupoSanguineos(),
            'eps'               => $this->userRepository->getAllEpsActivas(),
            'departamentos'     => $this->userRepository->getAllDepartamentos(),
            'ocupaciones'       => $this->userRepository->getAllOcupaciones(),
            'roles'             => $roles,
            'nodos'             => $nodo,
            'regionales'        => $this->userRepository->getAllRegionales(),
            'documento' => $document,
            'lineas' => LineaTecnologica::pluck('nombre', 'id'),
            'view' => 'create'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //policy
        $this->authorize('store', User::class);
        $req       = new UserFormRequest;

        $validator = Validator::make($request->all(), $req->rules(), $req->messages());

        if ($validator->fails()) {
            return response()->json([
                'state'   => 'error_form',
                'fail'   => true,
                'errors' => $validator->errors(),
            ]);
        } else {

            //generar una contraseña
            $password = User::generatePasswordRamdom();
            //creamos el usuario
            $user = $this->userRepository->Store($request, $password);

            if ($user != null) {
                //evento para crear token para activacion de cuenta
                // $this->userRepository->activationToken($user->id);

                //envio de email con contraseña
                event(new UserWasRegistered($user, $password));


                return response()->json([
                    'state'   => 'success',
                    'message' => 'El Usuario ha sido creado satisfactoriamente',
                    'url' => route('usuario.index'),
                    'user' => $user,
                ]);
            } else {

                return response()->json([
                    'state'   => 'error',
                    'message' => 'El Usuario no se ha creado',
                    'url' => false

                ]);
            }
        }
    }
}
