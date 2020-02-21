<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Repository\UserRepository\DinamizadorRepository;
use App\Repositories\Repository\UserRepository\UserRepository;
use App\User;
use Illuminate\Http\Request;
use App\Repositories\Datatables\UserDatatables;

class DinamizadorController extends Controller
{

    public $dinamizadorRepository;
    public $userRepository;
    public $userdatables;

    public function __construct(DinamizadorRepository $dinamizadorRepository, UserRepository $userRepository, UserDatatables $userdatables)
    {
        $this->middleware('auth');
        $this->dinamizadorRepository = $dinamizadorRepository;
        $this->userRepository        = $userRepository;
        $this->userdatables        = $userdatables;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('indexDinamizador', User::class);
        switch (session()->get('login_role')) {
            case User::IsAdministrador():
                return view('users.administrador.dinamizador.index', [
                    'nodos' => $this->userRepository->getAllNodos(),
                    'view' => 'activos'
                ]);
                break;

            default:
                abort('404');
                break;
        }
    }

    public function getDinanizador(Request $request, $nodo)
    {
        $this->authorize('indexDinamizador', User::class);

        if (request()->ajax()) {
            $users = $this->dinamizadorRepository->getAllDinamizadoresPorNodo($nodo)
                ->orderby('users.created_at', 'desc')
                ->get();

            return $this->userdatables->datatableUsers($request, $users);
        }

        abort('404');
    }

    public function getDinanizadorTrash(Request $request, $nodo)
    {
        $this->authorize('indexDinamizador', User::class);

        if (request()->ajax()) {
            $users = $this->dinamizadorRepository->getAllDinamizadoresPorNodo($nodo)
                    ->onlyTrashed()
                    ->orderby('users.created_at', 'desc')
                    ->get();

            return $this->userdatables->datatableUsers($request, $users);
        }

        abort('404');
    }


    

    public function trash(Request $request)
    {
        $this->authorize('indexDinamizador', User::class);
        switch (session()->get('login_role')) {
            case User::IsAdministrador():


                return view('users.administrador.dinamizador.index', [
                    'view' => 'inactivos',
                    'nodos' => $this->userRepository->getAllNodos(),
                ]);
                break;
            default:
                abort('404');
                break;
        }
    }
}
