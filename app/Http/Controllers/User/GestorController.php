<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Repository\UserRepository\{GestorRepository, UserRepository};
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
        return response()->json([
            'lineas' => $this->userRepository->getAllLineaNodo($nodo)->lineas->pluck('nombre', 'id'),
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
                        $button = '<a href="' . route("usuario.usuarios.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';
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

}
