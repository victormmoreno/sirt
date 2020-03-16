<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Repository\UserRepository\IngresoRepository;
use App\Repositories\Repository\UserRepository\UserRepository;
use App\User;
use Illuminate\Http\Request;
use App\Repositories\Datatables\UserDatatables;

class IngresoController extends Controller
{

    protected $ingresoRepository;
    protected $userRepository;
    public $userdatables;

    public function __construct(IngresoRepository $ingresoRepository, UserRepository $userRepository, UserDatatables $userdatables)
    {
        $this->middleware('auth');
        $this->ingresoRepository = $ingresoRepository;
        $this->userRepository    = $userRepository;
        $this->userdatables        = $userdatables;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('indexIngreso', User::class);
        switch (session()->get('login_role')) {
            case User::IsAdministrador():
                return view('users.administrador.ingreso.index', [
                    'nodos' => $this->userRepository->getAllNodo(),
                    'view' => 'activos'
                ]);
                break;
            case User::IsDinamizador():
                return view('users.dinamizador.ingreso.index', ['view' => 'activos']);
                break;

            default:
                abort('404');
                break;
        }
    }

    public function trash()
    {
        // $this->authorize('indexIngreso', User::class);
        switch (session()->get('login_role')) {
            case User::IsAdministrador():
                return view('users.administrador.ingreso.index', [
                    'nodos' => $this->userRepository->getAllNodo(),
                    'view' => 'inactivos'
                ]);
                break;
            case User::IsDinamizador():
                return view('users.dinamizador.ingreso.index', ['view' => 'inactivos']);
                break;

            default:
                abort('404');
                break;
        }
    }

    /*=================================================================================
    =            metodo para mostrar los usuarios ingreso en el datatables            =
    =================================================================================*/
    

    public function getIngresoForNodo(Request $request, $nodo)
    {

        if (request()->ajax()) {
                $users = $this->ingresoRepository->getAllUsersIngresoForNodo($nodo)
                    ->orderby('users.created_at', 'desc')
                    ->get();

                return $this->userdatables->datatableUsers($request, $users);
        }
        abort('404');
    }

    /*=====  End of metodo para mostrar los usuarios ingreso en el datatables  ======*/


    public function getIngresoForNodoTrash(Request $request, $nodo)
    {

        if (request()->ajax()) {
            $users = $this->ingresoRepository->getAllUsersIngresoForNodo($nodo)
                    ->onlyTrashed()
                    ->orderby('users.created_at', 'desc')
                    ->get();

                return $this->userdatables->datatableUsers($request, $users);
        }
        abort('404');
    }

    /*=======================================================================================
    =            metodo para mostrar todos los usuarios ingreso de determinado nodo            =
    =======================================================================================*/

    public function getAllIngresoOfNodo(Request $request)
    {

        if (request()->ajax()) {
            if(session()->get('login_role') == User::IsDinamizador()){
                $users = $this->ingresoRepository->getAllUsersIngresoForNodo(auth()->user()->dinamizador->nodo_id)->get();
            return $this->userdatables->datatableUsers($request, $users);
            }
            abort('404');
        }
        abort('404');
    }

    /*=====  End of metodo para mostrar todos los usuarios ingreso de determinado nodo  ======*/

    public function getAllIngresoOfNodoTrash(Request $request)
    {

        if (request()->ajax()) {
            if(session()->get('login_role') == User::IsDinamizador()){
                $users = $this->ingresoRepository->getAllUsersIngresoForNodo(auth()->user()->dinamizador->nodo_id)
                ->onlyTrashed()
                ->get();
            return $this->userdatables->datatableUsers($request, $users);
            }
            abort('404');
        }
        abort('404');
    }

}
