<?php

namespace App\Http\Controllers\User;

use App\Events\User\UserWasRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequests\UserFormRequest;
use App\Repositories\Repository\UserRepository\UserRepository;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('users.administrador.index', [
            'roles' => $this->userRepository->getAllRoles(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.administrador.create', [
            'tiposdocumentos'   => $this->userRepository->getAllTipoDocumento(),
            'gradosescolaridad' => $this->userRepository->getSelectAllGradosEscolaridad(),
            'gruposanguineos'   => $this->userRepository->getAllGrupoSanguineos(),
            'eps'               => $this->userRepository->getAllEpsActivas(),
            'departamentos'     => $this->userRepository->getAllDepartamentos(),
            'ocupaciones'       => $this->userRepository->getAllOcupaciones(),
            'roles'             => $this->userRepository->getAllRoles(),
            'nodos'             => $this->userRepository->getAllNodo(),
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

        //validamos formularios
            //UserFormRequest
            
        //generar una contraseña
        $password = User::generatePasswordRamdom();
        //creamos el usuario
        $user            = $this->userRepository->Store($request, $password);
        $activationToken = $this->userRepository->activationToken($user->id);

        
        if ($user != null) {
            //envio de email con contraseña
            event(new UserWasRegistered($user, $password));
            //regresamos una respuesta al usuario
            alert()->success('Registro Exitoso.', 'El Usuario ha sido creado satisfactoriamente')->footer('<p class="red-text">Hemos enviado un link de activación al correo del usuario ' . $user->nombres . ' ' . $user->apellidos . '</p>')->showConfirmButton('Ok', '#009891')->toHtml();
        } else {
            alert()->error('El Usuario no se ha creado.', 'Registro Erróneo.')->footer('Por favor intente de nuevo')->showConfirmButton('Ok', '#009891')->toHtml();
        }
        //redireccion

        return redirect()->route('usuario.administrador.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        // dd(auth()->user()->getRoleNames()->implode(', '));
        
        return view('users.administrador.edit', [
            'user'              => $this->userRepository->findById($id),
            'tiposdocumentos'   => $this->userRepository->getAllTipoDocumento(),
            'gradosescolaridad' => $this->userRepository->getSelectAllGradosEscolaridad(),
            'gruposanguineos'   => $this->userRepository->getAllGrupoSanguineos(),
            'eps'               => $this->userRepository->getAllEpsActivas(),
            'departamentos'     => $this->userRepository->getAllDepartamentos(),
            'ocupaciones'       => $this->userRepository->getAllOcupaciones(),
            'roles'             => $this->userRepository->getAllRoles(),
            'nodos'             => $this->userRepository->getAllNodo(),
            'perfiles'          => $this->userRepository->getAllPerfiles(),
            'regionales'        => $this->userRepository->getAllRegionales(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserFormRequest $request, $id)
    {
        $user = $this->userRepository->findById($id);
        if ($user != null) {
            $userUpdate = $this->userRepository->Update($request, $user);
            alert()->success("El Usuario {$userUpdate->nombre_completo} ha sido  modificado.", 'Modificación Exitosa', "success");
        }
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
