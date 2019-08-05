<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Repository\UserRepository\IngresoRepository;
use App\Repositories\Repository\UserRepository\UserRepository;
use App\User;

class IngresoController extends Controller
{

    protected $ingresoRepository;
    protected $userRepository;

    public function __construct(IngresoRepository $ingresoRepository, UserRepository $userRepository)
    {

        $this->ingresoRepository = $ingresoRepository;
        $this->userRepository    = $userRepository;
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
                return view('users.administrador.ingreso.index', [
                    'nodos' => $this->userRepository->getAllNodo(),
                ]);
                break;
            case User::IsDinamizador():
                return view('users.dinamizador.ingreso.index');
                break;

            default:

                break;
        }
    }

    /*=================================================================================
    =            metodo para mostrar los usuarios ingreso en el datatables            =
    =================================================================================*/

    public function getIngresoForNodo($nodo)
    {

        if (request()->ajax()) {
            return datatables()->of($this->ingresoRepository->getAllUsersIngresoForNodo($nodo))
                ->addColumn('detail', function ($data) {

                    $button = '<a class=" btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver Detalle" href="#modal1" onclick="UserIndex.detailUser(' . $data->id . ')"><i class="material-icons">info_outline</i></a>';

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
        abort('404');
    }

    /*=====  End of metodo para mostrar los usuarios ingreso en el datatables  ======*/


    /*=======================================================================================
    =            metodo para mostrar todos los usuarios ingreso de determinado nodo            =
    =======================================================================================*/
    
    public function getAllIngresoOfNodo()
    {      
         
        if (request()->ajax()) {

            return datatables()->of($this->ingresoRepository->getAllUsersIngresoForNodo(auth()->user()->dinamizador->nodo_id))
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
                ->rawColumns(['detail','estado', 'edit'])
                ->make(true);
        }
        abort('404');
       
    }
    
    /*=====  End of metodo para mostrar todos los usuarios ingreso de determinado nodo  ======*/

}
