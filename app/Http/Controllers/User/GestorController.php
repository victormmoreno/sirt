<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Repository\UserRepository\GestorRepository;
use App\Repositories\Repository\UserRepository\UserRepository;
use App\User;
use Illuminate\Http\Request;
use App\Repositories\Datatables\UserDatatables;

class GestorController extends Controller
{

    public $userRepository;
    public $gestorRepository;
    public $userdatables;

    public function __construct(UserRepository $userRepository, GestorRepository $gestorRepository, UserDatatables $userdatables)
    {
        $this->middleware('auth');
        $this->userRepository   = $userRepository;
        $this->gestorRepository = $gestorRepository;
        $this->userdatables        = $userdatables;
    }

    /**
     * Consulta los gestores de un nodo y los retorna (principalmente para pintarlos en un select)
     *
     * @param int $id Id del nodo
     * @return array
     * @author dum
     */
    public function getGestorPorNodoSelect($id)
    {
        return response()->json([
            'gestores' => $this->gestorRepository->getAllGestoresPorNodo($id)
                            ->orderby('users.created_at', 'desc')
                            ->get()
        ]);
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
                    'view' => 'activos'
                ]);
                break;
            case User::IsDinamizador():
                return view('users.dinamizador.gestor.index', ['view' => 'activos']);
                break;

            default:
                abort('404');
                break;
        }
    }


    public function trash()
    {
        $this->authorize('indexGestor', User::class);
        switch (session()->get('login_role')) {
            case User::IsAdministrador():
                return view('users.administrador.gestor.index', [
                    'nodos' => $this->userRepository->getAllNodo(),
                    'view' => 'inactivos'
                ]);
                break;
            case User::IsDinamizador():
                return view('users.dinamizador.gestor.index', ['view' => 'inactivos']);
                break;

            default:
                abort('404');
                break;
        }
    }

    /*==================================================================
    =            metodop para mostrar los gestores por nodo            =
    ==================================================================*/

    public function getGestor(Request $request, $nodo)
    {

        if (request()->ajax()) {

            $users = $this->gestorRepository->getAllGestoresPorNodo($nodo)
                    ->orderby('users.created_at', 'desc')
                    ->get();

            return $this->userdatables->datatableUsers($request, $users);
        }
        abort('404');
    }

    /*=====  End of metodop para mostrar los gestores por nodo  ======*/

    public function getGestorTrash(Request $request, $nodo)
    {

        if (request()->ajax()) {

            $users = $this->gestorRepository->getAllGestoresPorNodo($nodo)
                    ->onlyTrashed()
                    ->orderby('users.created_at', 'desc')
                    ->get();

            return $this->userdatables->datatableUsers($request, $users);
        }
        abort('404');
    }

    /*==============================================================================
    =            metodo para mostrar los gestores de un determnado nodo            =
    ==============================================================================*/

    public function getAllGestoresOfNodo(Request $request)
    {
        if (request()->ajax()) {

                if(session()->get('login_role') == User::IsDinamizador()){
                    $users = $this->gestorRepository->getAllGestoresPorNodo(auth()->user()->dinamizador->nodo_id)
                    ->orderby('users.created_at', 'desc')
                    ->get();

                    return $this->userdatables->datatableUsers($request, $users);
                }
                abort('404');
        }
        abort('404');
    }

    /*=====  End of metodo para mostrar los gestores de un determnado nodo  ======*/

    public function getAllGestoresOfNodoTrash(Request $request)
    {
        if (request()->ajax()) {

                if(session()->get('login_role') == User::IsDinamizador()){
                    $users = $this->gestorRepository->getAllGestoresPorNodo(auth()->user()->dinamizador->nodo_id)
                    ->onlyTrashed()
                    ->orderby('users.created_at', 'desc')
                    ->get();

                    return $this->userdatables->datatableUsers($request, $users);
                }
                abort('404');
        }
        abort('404');
    }

}
