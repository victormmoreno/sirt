<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Repository\UserRepository\{DinamizadorRepository, UserRepository};
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

        switch (session()->get('login_role')) {
            case User::IsAdministrador():
                return view('users.administrador.dinamizador.index', [
                    'nodos' => $this->userRepository->getAllNodos(),
                ]);
            break;
            case User::IsDinamizador():
                return view('users.dinamizador.gestor.index', [
                    'nodos' => $this->userRepository->getAllNodos(),
                ]);
             break;

            default:
                
            break;
        }
        
    }

    public function getDinanizador($nodo)
    {

        // $dinamizador = $this->dinamizadorRepository->getAllDinamizadoresPorNodo($nodo);
        // dd($dinamizador);

        if (request()->ajax()) {
            return datatables()->of($this->dinamizadorRepository->getAllDinamizadoresPorNodo($nodo))
                ->addColumn('detail', function ($data) {

                    $button = '<a class="  btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver detalle" href="#modal1" onclick="UserAdministradorDinamizador.detalleDinamizador(' . $data->id . ')"><i class="material-icons">info_outline</i></a>';

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
        ];

        return response()->json([
            'data' => $data,
        ]);
    }

}
