<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Repository\UserRepository\UserRepository;
use Illuminate\Http\Request;

class InfocenterController extends Controller
{

    
    public $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('auth');
        $this->userRepository        = $userRepository;
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
        if (request()->ajax()) {
            return datatables()->of($this->userRepository->getAllUsersForRole())
                ->addColumn('detail', function ($data) {

                    $button = '<a class="  btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver Detalle" href="#modal1" onclick="detalleAdministrador(' . $data->id . ')"><i class="material-icons">info_outline</i></a>';

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

        return view('users.administrador.infocenter.index', [
                    'nodos' => $this->userRepository->getAllNodos(),
                ]);
    }

    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

}
