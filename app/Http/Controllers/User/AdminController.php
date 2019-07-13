<?php

namespace App\Http\Controllers\User;

use App\Events\User\UserWasRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequests\AdminFormRequest;
use App\Models\Ocupacion;
use App\Models\OcupacionModel;
use App\Repositories\Repository\UserRepository\AdminRepository;
use App\Repositories\Repository\UserRepository\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Session;

class AdminController extends Controller
{

    public $adminRepository;
    public $userRepository;

    public function __construct(AdminRepository $adminRepository, UserRepository $userRepository)
    {
        $this->middleware('auth');
        $this->adminRepository = $adminRepository;
        $this->userRepository  = $userRepository;
    }

    /*================================================================================
    =            metodo para consultar las ciudedes segun el departamento            =
    ================================================================================*/

    public function getCiudad($departamento)
    {

        return response()->json([
            'ciudades' => $this->userRepository->getAllCiudadDepartamento($departamento),
        ]);
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (request()->ajax()) {
            return datatables()->of($this->adminRepository->getAllAdministradores())
                ->addColumn('detail', function ($data) {

                    $button = '<a class="  btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver Detalle" href="#modal1" onclick="detalleAdministrador(' . $data->id . ')"><i class="material-icons">info_outline</i></a>';

                    return $button;
                })
                ->addColumn('edit', function ($data) {
                    if ($data->id != auth()->user()->id) {
                        $button = '<a href="' . route("usuario.usuarios.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';
                    } else {
                        $button = '<center><span class="new badge" data-badge-caption="ES USTED"></span></center>';
                    }
                    return $button;
                })
                ->editColumn('estado', function ($data) {
                    if ($data->estado == User::IsActive()) {
                        return $data->estado = 'Habilitado';
                    } else {
                        return $data->estado = 'Inhabilitado ';
                    }
                })
                ->rawColumns(['detail', 'edit'])
                ->make(true);
        }

        return view('users.administrador.administrador.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $ocupacion$this->userRepository->getAllOcupaciones();

        return view('users.administrador.administrador.create', [
            'tiposdocumentos'   => $this->userRepository->getAllTipoDocumento(),
            'gradosescolaridad' => $this->userRepository->getSelectAllGradosEscolaridad(),
            'gruposanguineos'   => $this->userRepository->getAllGrupoSanguineos(),
            'eps'               => $this->userRepository->getAllEpsActivas(),
            'departamentos'     => $this->userRepository->getAllDepartamentos(),
            'ocupaciones'       => $this->userRepository->getAllOcupaciones(),
            'roles'             => $this->userRepository->getAllRoles(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminFormRequest $request)
    {
        //generar contraseña
        $password = User::generatePasswordRamdom();
        //guardar registro
        $administrador = $this->adminRepository->Store($request, $password);

        $activationToken = $this->userRepository->activationToken($administrador->id);
        //envio de email con contraseña
        if ($administrador != null) {
            event(new UserWasRegistered($administrador, $password));
            alert()->success('Registro Exitoso.', 'El Usuario ha sido creado satisfactoriamente')->footer('<p class="red-text">Hemos enviado un link de activación al correo del usuario ' . $administrador->nombre_completo . '</p>')->showConfirmButton('Ok', '#009891')->toHtml();
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
        $user = $this->adminRepository->getFindDetailByid($id);

        $data = [
                    'user' =>$user,
                    'role' =>$user->getRoleNames()->implode(', '),
                    'tipodocumento' =>$user->tipoDocumento->nombre,
                    'eps' =>$user->eps->nombre,
                    'departamento' =>$user->ciudad->departamento->nombre,
                    'ciudad' =>$user->ciudad->nombre,
                    'gruposanguineo' =>$user->grupoSanguineo->nombre,
                    'gradosescolaridad' =>$user->gradoEscolaridad->nombre,

                ];
                

        return response()->json([
            'data' =>  $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('users.administrador.administrador.edit', [
            'user'              => $this->userRepository->findById($id),
            'tiposdocumentos'   => $this->userRepository->getAllTipoDocumento(),
            'gradosescolaridad' => $this->userRepository->getSelectAllGradosEscolaridad(),
            'gruposanguineos'   => $this->userRepository->getAllGrupoSanguineos(),
            'eps'               => $this->userRepository->getAllEpsActivas(),
            'departamentos'     => $this->userRepository->getAllDepartamentos(),
            'ocupaciones'       => $this->userRepository->getAllOcupaciones(),
            'roles'             => $this->userRepository->getAllRoles(),
    
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminFormRequest $request, $id)
    {
        $user = $this->userRepository->findById($id);
        if ($user != null) {
            $userUpdate = $this->adminRepository->Update($request, $user);
            alert()->success("El Usuario {$userUpdate->nombre_completo} ha sido  modificado.", 'Modificación Exitosa', "success");
        } else {
            alert()->error("El Usuario no se ha modificado.", 'Modificación Errónea', "error");
        }

        return redirect()->route('usuario.administrador.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
    }
}
