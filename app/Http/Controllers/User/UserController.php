<?php

namespace App\Http\Controllers\User;

use App\Events\User\UserWasRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequests\UserFormRequest;
use App\Models\Nodo;
use App\Repositories\Repository\UserRepository\UserRepository;
use App\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('role_session:Administrador|Dinamizador|Gestor');

        $this->userRepository = $userRepository;
    }

    /*===============================================================================
    =            metodo API para consultar las ciudades por departamento            =
    ===============================================================================*/

    public function getCiudad($departamento = '1')
    {

        return response()->json([
            'ciudades' => $this->userRepository->getAllCiudadDepartamento($departamento),
        ]);
    }

    /*=====  End of metodo API para consultar las ciudades por departamento  ======*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // dd($this->userRepository->getAllUsersForDatatables());
        // $this->authorize('view',auth()->user());
        switch (session()->get('login_role')) {
            case User::IsAdministrador():
                return view('users.administrador.index', [
                    'roles' => $this->userRepository->getAllRoles(),
                ]);
                break;
            case User::IsDinamizador():
                $role = ['Gestor', 'Infocenter', 'Ingreso', 'Talento'];
                return view('users.administrador.index', [
                    'roles' => $this->userRepository->getRoleWhereInRole($role),
                ]);
                break;

            case User::IsGestor():

                return view('users.gestor.talento.index');
                break;
            default:
                abort('404');
                break;
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


        switch (session()->get('login_role')) {
            case User::IsAdministrador():
                
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

                break;

            case User::IsDinamizador():

                $nodo = Nodo::nodoUserAthenticated(auth()->user()->dinamizador->nodo->id)->pluck('nombre', 'id');

              
                return view('users.administrador.create', [
                    'tiposdocumentos'   => $this->userRepository->getAllTipoDocumento(),
                    'gradosescolaridad' => $this->userRepository->getSelectAllGradosEscolaridad(),
                    'gruposanguineos'   => $this->userRepository->getAllGrupoSanguineos(),
                    'eps'               => $this->userRepository->getAllEpsActivas(),
                    'departamentos'     => $this->userRepository->getAllDepartamentos(),
                    'ocupaciones'       => $this->userRepository->getAllOcupaciones(),
                    'roles'             => $this->userRepository->getRoleWhereNotInRole(['Administrador','Dinamizador']),
                    'nodos'             => $nodo,
                    'perfiles'          => $this->userRepository->getAllPerfiles(),
                    'regionales'        => $this->userRepository->getAllRegionales(),
                ]);

                break;
            case User::IsGestor():
                
                $nodo = Nodo::nodoUserAthenticated(auth()->user()->gestor->nodo->id)->pluck('nombre', 'id');

                return view('users.administrador.create', [
                    'tiposdocumentos'   => $this->userRepository->getAllTipoDocumento(),
                    'gradosescolaridad' => $this->userRepository->getSelectAllGradosEscolaridad(),
                    'gruposanguineos'   => $this->userRepository->getAllGrupoSanguineos(),
                    'eps'               => $this->userRepository->getAllEpsActivas(),
                    'departamentos'     => $this->userRepository->getAllDepartamentos(),
                    'ocupaciones'       => $this->userRepository->getAllOcupaciones(),
                    'roles'             => $this->userRepository->getRoleWhereInRole(['Talento']),
                    'nodos'             => $nodo,
                    'perfiles'          => $this->userRepository->getAllPerfiles(),
                    'regionales'        => $this->userRepository->getAllRegionales(),
                ]);

                break;
            default:
                abort('404');
                break;
        }

    }

    /*============================================================================
    =            metodo para mostrar todos los usuarios en datatables            =
    ============================================================================*/
    
    public function getAllUsersInDatatable()
    {
        if (request()->ajax()) {

            return datatables()->of($this->userRepository->getAllUsersForDatatables())
                ->addColumn('detail', function ($data) {

                    $button = '<a class="btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver Detalle" href="#" onclick="UserIndex.detailUser(' . $data->id . ')"><i class="material-icons">info_outline</i></a>';

                    return $button;
                })->editColumn('estado', function ($data) {
                    if ($data->estado == User::IsActive()) {
                        
                        return $data->estado = 'Habilitado';
                    } else {
                        return $data->estado = 'Inhabilitado ';
                    }
                })
                ->editColumn('role', function ($data) {
                    return $data->roles->implode('name', ', ');
                })
                ->addColumn('edit', function ($data) {
                            if ($data->id != auth()->user()->id) {
                                $button = '<a href="' . route("usuario.usuarios.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';
                            } else {
                                $button = '<center><span class="new badge" data-badge-caption="ES USTED"></span></center>';
                            }
                            return $button;
                        })
                ->rawColumns(['detail','edit', 'estado','role'])
                ->make(true);
        }
    }
    
    /*=====  End of metodo para mostrar todos los usuarios en datatables  ======*/
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest $request)
    {
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->userRepository->findById($id);

        if (request()->ajax()) {
            $data = [
                'user' => $user,
                'role' => $user->getRoleNames()->implode(', '),
            ];

            return response()->json([
                'data' => $data,
            ]);

        }
        abort('404');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->findById($id);
        // $this->authorize('view', $user);
        switch (session()->get('login_role')) {
            case User::IsAdministrador():
                
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
                break;
            case User::IsDinamizador():
                $nodo = Nodo::nodoUserAthenticated(auth()->user()->dinamizador->nodo->id)->pluck('nombre', 'id');
               

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
                break;
            case User::IsGestor():
                $nodo = Nodo::nodoUserAthenticated(auth()->user()->gestor->nodo->id)->pluck('nombre', 'id');

                
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

                break;

            default:
                # code...
                break;
        }

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
            alert()->success("El Usuario {$userUpdate->nombres} {$userUpdate->apellidos} ha sido  modificado.", 'Modificación Exitosa', "success");
        } else {
            alert()->error("El Usuario {$user->nombres} {$user->apellidos} no ha sido  modificado.", 'Modificación Errónea', "error");
        }

        //redireccion
        return redirect()->route('usuario.index');
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
