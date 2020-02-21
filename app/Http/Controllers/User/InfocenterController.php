<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Repository\UserRepository\InfocenterRepository;
use App\Repositories\Repository\UserRepository\UserRepository;
use App\User;
use Illuminate\Http\Request;
use App\Repositories\Datatables\UserDatatables;

class InfocenterController extends Controller
{

    protected $userRepository;
    protected $infocenterRepository;
    public $userdatables;

    public function __construct(UserRepository $userRepository, InfocenterRepository $infocenterRepository, UserDatatables $userdatables)
    {
        $this->middleware('auth');
        $this->userRepository       = $userRepository;
        $this->infocenterRepository = $infocenterRepository;
        $this->userdatables        = $userdatables;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('indexInfocenter', User::class);
        switch (session()->get('login_role')) {
            case User::IsAdministrador():
                return view('users.administrador.infocenter.index', [
                    'nodos' => $this->userRepository->getAllNodos(),
                    'view' => 'activos'
                ]);
                break;
            case User::IsDinamizador():
                return view('users.dinamizador.infocenter.index', [
                    'nodos' => $this->userRepository->getAllNodos(),
                    'view' => 'activos'
                ]);
                break;

            default:
                abort('404');
                break;
        }

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $this->authorize('indexInfocenter', User::class);
        switch (session()->get('login_role')) {
            case User::IsAdministrador():
                return view('users.administrador.infocenter.index', [
                    'nodos' => $this->userRepository->getAllNodos(),
                    'view' => 'inactivos'
                ]);
                break;
            case User::IsDinamizador():
                return view('users.dinamizador.infocenter.index', [
                    'nodos' => $this->userRepository->getAllNodos(),
                    'view' => 'inactivos'
                ]);
                break;

            default:
                abort('404');
                break;
        }

    }

    /*======================================================================
    =            metodo para consultar los infocenters por nodo            =
    ======================================================================*/

    public function getInfocenterForNodo(Request $request, $nodo)
    {

        if (request()->ajax()) {
            $users = $this->infocenterRepository->getAllInfocentersForNodo($nodo)
                                    ->orderby('users.created_at', 'desc')
                                    ->get();

            return $this->userdatables->datatableUsers($request, $users);
        }
        abort('404');
    }

    public function getInfocenterForNodoTrash(Request $request, $nodo)
    {

        if (request()->ajax()) {
            $users = $this->infocenterRepository->getAllInfocentersForNodo($nodo)
                                    ->onlyTrashed()
                                    ->orderby('users.created_at', 'desc')
                                    ->get();
            return $this->userdatables->datatableUsers($request, $users);
        }
        abort('404');
    }

    /*=====  End of metodo para consultar los infocenters por nodo  ======*/
    /*=======================================================================================
    =            metodo para mostrar todos los infocenter de un determinado nodo            =
    =======================================================================================*/

    public function getAllInfocentersOfNodo(Request $request)
    {

        if (request()->ajax()) {

            $users = $this->infocenterRepository->getAllInfocentersForNodo(auth()->user()->dinamizador->nodo_id)
                        ->orderby('users.created_at', 'desc')
                        ->get();
            
            return $this->userdatables->datatableUsers($request, $users);
        }
        abort('404');

    }

    /*=====  End of metodo para mostrar todos los infocenter de un determinado nodo  ======*/

}
