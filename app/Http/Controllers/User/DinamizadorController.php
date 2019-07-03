<?php

namespace App\Http\Controllers\User;

use App\Events\User\UserWasRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequests\DinamizadorFormRequest;
use App\Repositories\Repository\UserRepository\DinamizadorRepository;
use App\Repositories\Repository\UserRepository\UserRepository;
use App\User;
use Illuminate\Http\Request;

class DinamizadorController extends Controller
{

    public $dinamizadorRepository;
    public $userRepository;

    public function __construct(DinamizadorRepository $dinamizadorRepository, UserRepository $userRepository)
    {
        $this->middleware('auth');
        $this->dinamizadorRepository = $dinamizadorRepository;
        $this->userRepository        = $userRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nodos = $this->dinamizadorRepository->getAllNodos();


        return view('users.administrador.dinamizador.index', [
            'nodos' => $this->dinamizadorRepository->getAllNodos(),
        ]);
    }

    public function getDinanizador($nodo)
    {

        if (request()->ajax()) {
            return datatables()->of($this->dinamizadorRepository->getAllDinamizadoresPorNodo($nodo))
                ->addColumn('detail', function ($data) {

                    $button = '<a class="  btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver Lineas" href="#modal1" onclick=""><i class="material-icons">info_outline</i></a>';

                    return $button;
                })
                ->addColumn('edit', function ($data) {
                    if ($data->id != auth()->user()->id) {
                        $button = '<a href="' . route("usuario.dinamizador.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';
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
        // $nodos = $this->dinamizadorRepository->getAllNodosPluck();
        // dd($nodos);
        return view('users.administrador.dinamizador.create', [
            'tiposdocumentos'   => $this->userRepository->getAllTipoDocumento(),
            'gradosescolaridad' => $this->userRepository->getSelectAllGradosEscolaridad(),
            'gruposanguineos'   => $this->userRepository->getAllGrupoSanguineos(),
            'eps'               => $this->userRepository->getAllEpsActivas(),
            'departamentos'     => $this->userRepository->getAllDepartamentos(),
            'ocupaciones'       => $this->userRepository->getAllOcupaciones(),
            'roles'             => $this->userRepository->getAllRoles(),
            'nodos'             => $this->dinamizadorRepository->getAllNodosPluck(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DinamizadorFormRequest $request)
    {
        //generar contraseña
        $password = User::generatePasswordRamdom();
        //guardar registro
        $dinamizador = $this->dinamizadorRepository->Store($request, $password);
        $activationToken = $this->userRepository->activationToken($dinamizador->id);
        //envio de email con contraseña
        if ($dinamizador != null) {
            event(new UserWasRegistered($dinamizador, $password));
            alert()->success('Registro Exitoso.', 'El Usuario ha sido creado satisfactoriamente')->footer('<p class="red-text">Hemos enviado un link de activación al correo del usuario ' . $dinamizador->nombre_completo . '</p>')->showConfirmButton('Ok', '#009891')->toHtml();
        } else {
            alert()->error('El Usuario no se ha creado.', 'Registro Erróneo.')->footer('Por favor intente de nuevo')->showConfirmButton('Ok', '#009891')->toHtml();
        }
        //redireccion

        return redirect()->route('usuario.dinamizador.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $nombre)
    {
        // $user = User::where('nombres',$nombre)->where('apellidos',$apellido)->first();
        // dd($nombre);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('users.administrador.dinamizador.edit',[
            'user'              => $this->userRepository->findById($id),
            'tiposdocumentos'   => $this->userRepository->getAllTipoDocumento(),
            'gradosescolaridad' => $this->userRepository->getSelectAllGradosEscolaridad(),
            'gruposanguineos'   => $this->userRepository->getAllGrupoSanguineos(),
            'eps'               => $this->userRepository->getAllEpsActivas(),
            'departamentos'     => $this->userRepository->getAllDepartamentos(),
            'ocupaciones'       => $this->userRepository->getAllOcupaciones(),
            'roles'             => $this->userRepository->getAllRoles(),
            'nodos'             => $this->dinamizadorRepository->getAllNodosPluck(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DinamizadorFormRequest $request, $id)
    {
        $user = $this->userRepository->findById($id);
        if ($user != null) {
            $userUpdate = $this->dinamizadorRepository->Update($request, $user);
            alert()->success("El Usuario {$userUpdate->nombre_completo} ha sido  modificado.", 'Modificación Exitosa', "success");
        } else {
            alert()->error("El Usuario no se ha modificado.", 'Modificación Errónea', "error");
        }

        return redirect()->route('usuario.dinamizador.index');
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
