<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Repository\UserRepository\InfocenterRepository;
use App\Repositories\Repository\UserRepository\UserRepository;
use App\User;
use Illuminate\Http\Request;

class InfocenterController extends Controller
{

    protected $userRepository;
    protected $infocenterRepository;

    public function __construct(UserRepository $userRepository, InfocenterRepository $infocenterRepository)
    {
        $this->middleware('auth');
        $this->userRepository       = $userRepository;
        $this->infocenterRepository = $infocenterRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $user = $this->userRepository->getAllUsersForRole('Infocenter');
        // dd($user);

        return view('users.administrador.infocenter.index', [
            'nodos' => $this->userRepository->getAllNodos(),
        ]);
    }

    /*======================================================================
    =            metodo para consultar los infocenters por nodo            =
    ======================================================================*/

    public function getInfocenterForNodo($nodo)
    {

        if (request()->ajax()) {
            return datatables()->of($this->infocenterRepository->getAllInfocentersForNodo($nodo))
                ->addColumn('detail', function ($data) {

                    $button = '<a class="  btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver Detalle" href="#modal1" onclick="UserAdministradorInfocenter.detalleInfocenter(' . $data->id . ')"><i class="material-icons">info_outline</i></a>';

                    return $button;
                })
                
                ->editColumn('estado', function ($data) {
                    if ($data->estado == User::IsActive()) {
                        if ($data->id == auth()->user()->id) {
                            return $data->estado = 'Habilitado <span class="new badge" data-badge-caption="ES USTED"></span>';
                        }
                        return $data->estado = 'Habilitado';
                    } else {
                        return $data->estado = 'Inhabilitado ';
                    }
                })
                ->rawColumns(['detail', 'estado'])
                ->make(true);
        }
    }

    /*=====  End of metodo para consultar los infocenters por nodo  ======*/

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
