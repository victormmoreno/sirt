<?php

namespace App\Http\Controllers\User;

use App\Events\User\UserWasRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequests\AdminFormRequest;
use App\Repositories\Repository\UserRepository\AdminRepository;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    // use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    public $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->middleware('auth');
        $this->adminRepository = $adminRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function administradorIndex()
    {

        if (auth()->user()->hasRole('Administrador') || auth()->user()->hasPermissionTo('consultar linea')) {

            $admin = $this->adminRepository->getAllAdministradores();


            if (request()->ajax()) {
                return datatables()->of($this->adminRepository->getAllAdministradores())
                    ->addColumn('detail', function ($data) {
                        
                        $button = '<a class="  btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver Lineas" href="#modal1" onclick="detalleAdministrador(' . $data->id . ')"><i class="material-icons">info_outline</i></a>';

                        return $button;
                    })
                    ->addColumn('edit', function ($data) {
                        if ($data->id != auth()->user()->id) {
                            $button = '<a href="' . route("usuario.administrador.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';
                        }else{
                            $button = '';
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
        } else {
            abort(403);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function administradorCreate()
    {

        return view('users.administrador.administrador.create', [
            'tiposdocumentos'   => $this->adminRepository->getAllTipoDocumento(),
            'gradosescolaridad' => $this->adminRepository->getSelectAllGradosEscolaridad(),
            'gruposanguineos'   => $this->adminRepository->getAllGrupoSanguineos(),
            'eps'               => $this->adminRepository->getAllEpsActivas(),
            'departamentos'     => $this->adminRepository->getAllDepartamentos(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function administradorStore(AdminFormRequest $request)
    {
        //generar contraseña
        $password = User::generatePasswordRamdom();
        //guardar registro
        $administrador   = $this->adminRepository->Store($request, $password);
        $activationToken = $this->adminRepository->activationToken($administrador->id);
        //envio de email con contraseña
        if ($administrador != null) {
            event(new UserWasRegistered($administrador, $password));
            alert()->success('El Usuario ha sido creado satisfactoriamente', 'Registro Exitoso.')->footer('<p class="red-text">Hemos enviado un link de activación al correo del usuario ' . $administrador->nombre_completo . '</p>')->showConfirmButton('Ok', '#009891')->toHtml();
        } else {
            alert()->error('El Usuario no se ha creado.', 'Registro Erróneo.')->footer('Por favor intente de nuevo')->showConfirmButton('Ok', '#009891')->toHtml();
        }
        //redireccion

        return redirect()->route('usuario.administrador.index');

    }

    /*================================================================================
    =            metodo para consultar las ciudedes segun el departamento            =
    ================================================================================*/
    
    public function getCiudad($departamento)
    {
       
        return response()->json([
            'ciudades' => $this->adminRepository->getAllCiudadDepartamento($departamento),
        ]);
    }
    
    /*=====  End of metodo para consultar las ciudedes segun el departamento  ======*/
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'user' => $this->adminRepository->getFindDetailByid($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function administradorEdit($id)
    {

        $user = $this->adminRepository->findInfoUserById($id);
        // dd($user->genero);
        
        return view('users.administrador.administrador.edit', [
            'user'              => $user,
            'tiposdocumentos'   => $this->adminRepository->getAllTipoDocumento(),
            'gradosescolaridad' => $this->adminRepository->getSelectAllGradosEscolaridad(),
            'gruposanguineos'   => $this->adminRepository->getAllGrupoSanguineos(),
            'eps'               => $this->adminRepository->getAllEpsActivas(),
            'departamentos'     => $this->adminRepository->getAllDepartamentos(),
            'ciudades' => $this->adminRepository->getAllCiudadDepartamento($user->iddepartamento),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function administradorUpdate(AdminFormRequest $request, $id)
    {
        $user = $this->adminRepository->findById($id);
        if ($user != null) {
            $userUpdate = $this->adminRepository->Update($request, $user);
            alert()->success("El Usuario {$userUpdate->nombre_completo } ha sido  modificado.",'Modificación Exitosa',"success");
        }else{
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
    public function administradorDelete($id)
    {
        //
    }
}
