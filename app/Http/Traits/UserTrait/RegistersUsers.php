<?php

namespace App\Http\Traits\UserTrait;

use App\Events\User\UserWasRegistered;
use App\Http\Requests\UsersRequests\UserFormRequest;
use App\Models\Nodo;
use App\User;

trait RegistersUsers
{
    /**
     * mostrar el formulario para crear un nuevo usuario.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = null;
        $nodo  = null;
        $this->authorize('create', User::class);
        switch (session()->get('login_role')) {
            case User::IsAdministrador():

                $roles = $this->userRepository->getRoleWhereInRole([User::IsAdministrador(), User::IsDinamizador()]);
                $nodo  = $this->userRepository->getAllNodo();

                break;

            case User::IsDinamizador():

                $roles = $this->userRepository->getRoleWhereNotInRole([User::IsAdministrador(), User::IsDinamizador(), User::IsTalento()]);
                $nodo  = Nodo::nodoUserAthenticated(auth()->user()->dinamizador->nodo->id)->pluck('nombre', 'id');

                break;
            case User::IsGestor():

                $roles = $this->userRepository->getRoleWhereInRole([User::IsTalento()]);
                $nodo  = Nodo::nodoUserAthenticated(auth()->user()->gestor->nodo->id)->pluck('nombre', 'id');

                break;
            default:
                abort('404');
                break;

        }

  
        return view('users.administrador.create', [
            'tiposdocumentos'   => $this->userRepository->getAllTipoDocumento(),
            'gradosescolaridad' => $this->userRepository->getSelectAllGradosEscolaridad(),
            'gruposanguineos'   => $this->userRepository->getAllGrupoSanguineos(),
            'eps'               => $this->userRepository->getAllEpsActivas(),
            'departamentos'     => $this->userRepository->getAllDepartamentos(),
            'ocupaciones'       => $this->userRepository->getAllOcupaciones(),
            'roles'             => $roles,
            'nodos'             => $nodo,
            'perfiles'          => $this->userRepository->getAllPerfiles(),
            'regionales'        => $this->userRepository->getAllRegionales(),
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest $request)
    {
        $this->authorize('store', User::class);
        //generar una contraseña
        $password = User::generatePasswordRamdom();
        //creamos el usuario
        $user = $this->userRepository->Store($request, $password);

        if ($user != null) {
            //evento para crear token para activacion de cuenta
            $this->userRepository->activationToken($user->id);
            //envio de email con contraseña
            event(new UserWasRegistered($user, $password));
            //regresamos una respuesta al usuario
            alert()->success('Registro Exitoso.', 'El Usuario ha sido creado satisfactoriamente')->footer('<p class="red-text">Hemos enviado un link de activación al correo del usuario ' . $user->nombres . ' ' . $user->apellidos . '</p>')->showConfirmButton('Ok', '#009891')->toHtml();
        } else {
            alert()->error('El Usuario no se ha creado.', 'Registro Erróneo.')->footer('Por favor intente de nuevo')->showConfirmButton('Ok', '#009891')->toHtml();
        }
        //redireccion
        return redirect()->route('usuario.index');

    }

}
