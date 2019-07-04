<?php

namespace App\Http\Controllers\User;

use App\Events\User\UserWasRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequests\GestorFormRequest;
use App\Repositories\Repository\UserRepository\GestorRepository;
use App\Repositories\Repository\UserRepository\UserRepository;
use App\User;
use Illuminate\Http\Request;

class GestorController extends Controller
{

    public $userRepository;
    public $gestorRepository;

    public function __construct(UserRepository $userRepository, GestorRepository $gestorRepository)
    {
        $this->userRepository   = $userRepository;
        $this->gestorRepository = $gestorRepository;
    }

    /*=================================================================
    =            metodo para consultar las lineas por nodo            =
    =================================================================*/

    public function getLineaPorNodo($nodo)
    {
        // $nodo   = $this->userRepository->getAllLineaNodo($nodo);
        
        return response()->json([
            'lineas' => $this->userRepository->getAllLineaNodo($nodo)->lineas->pluck('nombre','id'),
        ]);
    }

    /*=====  End of metodo para consultar las lineas por nodo  ======*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $nodo   = $this->userRepository->getAllLineaNodo(1)->lineas->pluck('nombre','id');
        // // $lineas = $nodo->lineas;

        // // dd($nodo->lineas->pluck('nombre','id'));
        // dd($nodo);

        return view('users.administrador.gestor.index', [
            'nodos' => $this->userRepository->getAllNodo(),
        ]);
    }

    public function getGestor($nodo)
    {

        if (request()->ajax()) {
            return datatables()->of($this->gestorRepository->getAllGestoresPorNodo($nodo))
                ->addColumn('detail', function ($data) {

                    $button = '<a class="  btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver detalle" href="#modal1" onclick="UserAdministradorGestor.detalleGestor(' . $data->id . ')"><i class="material-icons">info_outline</i></a>';

                    return $button;
                })
                ->addColumn('edit', function ($data) {
                    if ($data->id != auth()->user()->id) {
                        $button = '<a href="' . route("usuario.gestor.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';
                    } else {
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

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.administrador.gestor.create', [
            'tiposdocumentos'   => $this->userRepository->getAllTipoDocumento(),
            'gradosescolaridad' => $this->userRepository->getSelectAllGradosEscolaridad(),
            'gruposanguineos'   => $this->userRepository->getAllGrupoSanguineos(),
            'eps'               => $this->userRepository->getAllEpsActivas(),
            'departamentos'     => $this->userRepository->getAllDepartamentos(),
            'ocupaciones'       => $this->userRepository->getAllOcupaciones(),
            'roles'             => $this->userRepository->getAllRoles(),
            'nodos'             => $this->userRepository->getAllNodo(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GestorFormRequest $request)
    {
        //generar contraseña
        $password = User::generatePasswordRamdom();
        //guardar registro
        $gestor = $this->gestorRepository->Store($request, $password);

        $activationToken = $this->userRepository->activationToken($gestor->id);
        //envio de email con contraseña
        if ($gestor != null) {
            event(new UserWasRegistered($gestor, $password));
            alert()->success('Registro Exitoso.', 'El Usuario ha sido creado satisfactoriamente')->footer('<p class="red-text">Hemos enviado un link de activación al correo del usuario ' . $gestor->nombre_completo . '</p>')->showConfirmButton('Ok', '#009891')->toHtml();
        } else {
            alert()->error('El Usuario no se ha creado.', 'Registro Erróneo.')->footer('Por favor intente de nuevo')->showConfirmButton('Ok', '#009891')->toHtml();
        }
        //redireccion

        return redirect()->route('usuario.gestor.index');
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

        $data = [
            'user'              => $user,
            'role'              => $user->getRoleNames()->implode(', '),
            'tipodocumento'     => $user->tipoDocumento->nombre,
            'eps'               => $user->eps->nombre,
            'departamento'      => $user->ciudad->departamento->nombre,
            'ciudad'            => $user->ciudad->nombre,
            'gruposanguineo'    => $user->grupoSanguineo->nombre,
            'gradosescolaridad' => $user->gradoEscolaridad->nombre,

        ];

        return response()->json([
            'data' => $data,
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
        return view('users.administrador.gestor.edit', [
            'user'              => $this->userRepository->findById($id),
            'tiposdocumentos'   => $this->userRepository->getAllTipoDocumento(),
            'gradosescolaridad' => $this->userRepository->getSelectAllGradosEscolaridad(),
            'gruposanguineos'   => $this->userRepository->getAllGrupoSanguineos(),
            'eps'               => $this->userRepository->getAllEpsActivas(),
            'departamentos'     => $this->userRepository->getAllDepartamentos(),
            'ocupaciones'       => $this->userRepository->getAllOcupaciones(),
            'roles'             => $this->userRepository->getAllRoles(),
            'nodos'             => $this->userRepository->getAllNodo(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GestorFormRequest $request, $id)
    {
        dd($request->all());
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
