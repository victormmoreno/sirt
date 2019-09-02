<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
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
        if (request()->ajax()) {
            return response()->json([
                'lineas' => $this->userRepository->getAllLineaNodo($nodo)->lineas->pluck('nombre', 'id'),
            ]);
        }

    }

    /*=====  End of metodo para consultar las lineas por nodo  ======*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('indexGestor', User::class);
        switch (session()->get('login_role')) {
            case User::IsAdministrador():
                return view('users.administrador.gestor.index', [
                    'nodos' => $this->userRepository->getAllNodo(),
                ]);
                break;
            case User::IsDinamizador():
                return view('users.dinamizador.gestor.index');
                break;

            default:
                abort('404');
                break;
        }

    }

    /*==================================================================
    =            metodop para mostrar los gestores por nodo            =
    ==================================================================*/

    public function getGestor($nodo)
    {

        if (request()->ajax()) {

            return datatables()->of($this->gestorRepository->getAllGestoresPorNodo($nodo))
                ->addColumn('detail', function ($data) {

                    $button = '<a class="  btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver detalle" href="#" onclick="UserIndex.detailUser(' . $data->id . ')"><i class="material-icons">info_outline</i></a>';

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
            })->rawColumns(['detail', 'estado', 'edit'])
                ->make(true);
        }
        abort('404');
    }

    /*=====  End of metodop para mostrar los gestores por nodo  ======*/

    /*==============================================================================
    =            metodo para mostrar los gestores de un determnado nodo            =
    ==============================================================================*/

    public function getAllGestoresOfNodo()
    {

        if (request()->ajax()) {

            return datatables()->of($this->gestorRepository->getAllGestoresPorNodo(auth()->user()->dinamizador->nodo_id))
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

    /*=====  End of metodo para mostrar los gestores de un determnado nodo  ======*/

}
