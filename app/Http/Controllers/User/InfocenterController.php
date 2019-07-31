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

        switch (session()->get('login_role')) {
            case User::IsAdministrador():
                return view('users.administrador.infocenter.index', [
                    'nodos' => $this->userRepository->getAllNodos(),
                ]);
                break;
            case User::IsDinamizador():
                return view('users.dinamizador.infocenter.index', [
                    'nodos' => $this->userRepository->getAllNodos(),
                ]);
                break;

            default:

                break;
        }

    }

    /*======================================================================
    =            metodo para consultar los infocenters por nodo            =
    ======================================================================*/

    public function getInfocenterForNodo($nodo)
    {

        if (request()->ajax()) {
            return datatables()->of($this->infocenterRepository->getAllInfocentersForNodo($nodo))
                ->addColumn('detail', function ($data) {

                    $button = '<a class="  btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver Detalle" href="#" onclick="UserIndex.detailUser(' . $data->id . ')"><i class="material-icons">info_outline</i></a>';

                    return $button;
                })

                ->editColumn('estado', function ($data) {
                    if ($data->estado == User::IsActive()) {
                        return $data->estado = 'Habilitado';
                    } else {
                        return $data->estado = 'Inhabilitado ';
                    }
                })->addColumn('edit', function ($data) {
                    if ($data->id != auth()->user()->id) {
                        $button = '<a href="' . route("usuario.usuarios.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';
                    } else {
                        $button = '<center><span class="new badge" data-badge-caption="ES USTED"></span></center>';
                    }
                    return $button;
                })
                ->rawColumns(['detail', 'estado','edit'])
                ->make(true);
        }
    }

    /*=====  End of metodo para consultar los infocenters por nodo  ======*/
    /*=======================================================================================
    =            metodo para mostrar todos los infocenter de un determinado nodo            =
    =======================================================================================*/

    public function getAllInfocentersOfNodo()
    {

        if (request()->ajax()) {

            return datatables()->of($this->infocenterRepository->getAllInfocentersForNodo(auth()->user()->dinamizador->nodo_id))
                ->addColumn('detail', function ($data) {

                    $button = '<a class="  btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver detalle" href="#" onclick="UserIndex.detailUser(' . $data->id . ')"><i class="material-icons">info_outline</i></a>';

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
                ->rawColumns(['detail', 'estado', 'edit'])
                ->make(true);
        }
        abort('404');

    }

    /*=====  End of metodo para mostrar todos los infocenter de un determinado nodo  ======*/

}
