<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequests\UserFormRequest;
use App\Http\Traits\UserTrait\RegistersUsers;
use App\Models\Nodo;
use App\Repositories\Repository\UserRepository\UserRepository;
use App\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class UserController extends Controller
{

    use RegistersUsers;

    public $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * metodo para mostrar el index o listado de usarios.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index', User::class);
        $nodo = 2;
        $user = User::with([
            'tipodocumento'                       => function ($query) {
                $query->select('id', 'nombre');
            },
            'gradoEscolaridad'                    => function ($query) {
                $query->select('id', 'nombre');
            },
            'eps'                                 => function ($query) {
                $query->select('id', 'nombre');
            },
            'ciudad'                              => function ($query) {
                $query->select('id', 'nombre', 'departamento_id');
            },
            'ciudad.departamento'                 => function ($query) {
                $query->select('id', 'nombre');
            },
            'talento'                             => function ($query) {
                $query->select('id', 'user_id', 'perfil_id', 'entidad_id', 'universidad', 'programa_formacion', 'carrera_universitaria', 'empresa', 'otro_tipo_talento');
            },
            'talento.perfil'                      => function ($query) {
                $query->select('id', 'nombre');
            },
            'talento.entidad'                     => function ($query) {
                $query->select('id', 'ciudad_id', 'nombre', 'email_entidad');
            },
            'talento.entidad.ciudad'              => function ($query) {
                $query->select('id', 'nombre', 'departamento_id');
            },
            'talento.entidad.ciudad.departamento' => function ($query) {
                $query->select('id', 'nombre');
            },
            'talento.articulacionproyecto'        => function ($query) {
                $query->select('articulacion_proyecto.id', 'entidad_id', 'actividad_id', 'revisado_final', 'acta_inicio', 'actas_seguimiento', 'acta_cierre');
            },
            // 'talento.articulacionproyecto.proyecto.sublinea.linea',
            'talento.articulacionproyecto.articulacion.tipoarticulacion'])
            ->select('id', 'tipodocumento_id', 'gradoescolaridad_id', 'eps_id', 'ciudad_id', 'nombres', 'apellidos', 'documento', 'email', 'barrio', 'direccion', 'celular', 'telefono', 'fechanacimiento', 'genero', 'otra_eps', 'institucion', 'titulo_obtenido', 'estrato', 'otra_ocupacion', 'created_at')
            ->whereHas('talento.articulacionproyecto.actividad.nodo', function ($query) use ($nodo) {
                $query->where('nodos.id', $nodo);
            })
            ->get();
       

        // return $user;

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

    /*===============================================================================
    =            metodo API para consultar las ciudades por departamento            =
    ===============================================================================*/

    public function getCiudad($departamento = '1')
    {
        if (request()->ajax()) {
            return response()->json([
                'ciudades' => $this->userRepository->getAllCiudadDepartamento($departamento),
            ]);
        } else {
            abort('404');
        }
    }

    /*=====  End of metodo API para consultar las ciudades por departamento  ======*/

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
                    
                    return $data->roles->whenEmpty(function($collection) {
                        return $collection->push('No tiene roles asignados');
                    })->implode('name', ', ');
                                       
                    
                })
                ->addColumn('edit', function ($data) {
                    if ($data->id != auth()->user()->id) {
                        $button = '<a href="' . route("usuario.usuarios.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';
                    } else {
                        $button = '<center><span class="new badge" data-badge-caption="ES USTED"></span></center>';
                    }
                    return $button;
                })
                ->rawColumns(['detail', 'edit', 'estado', 'role'])
                ->make(true);
        } else {
            abort('404');
        }
    }

    /*=====  End of metodo para mostrar todos los usuarios en datatables  ======*/

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
        $this->authorize('edit', $user);
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
                abort('404');
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
        $this->authorize('update', $user);

        if ($user != null) {
            $userUpdate = $this->userRepository->Update($request, $user);
            alert()->success("El Usuario {$userUpdate->nombres} {$userUpdate->apellidos} ha sido  modificado.", 'Modificación Exitosa', "success");
        } else {
            alert()->error("El Usuario {$user->nombres} {$user->apellidos} no ha sido  modificado.", 'Modificación Errónea', "error");
        }

        //redireccion
        return redirect()->route('usuario.index');
    }

}
