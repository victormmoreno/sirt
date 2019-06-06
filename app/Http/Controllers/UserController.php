<?php

namespace App\Http\Controllers;

use App\Models\Rols;
use App\User;
use Illuminate\Http\Request;
use App\Repositories\Repository\UserRepository;

class UserController extends Controller
{


    public $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if (auth()->user()->hasRole('Administrador') || auth()->user()->hasPermissionTo('consultar linea')) {

            // $administradores = User::
            // Join('tiposdocumentos', 'tiposdocumentos.id', '=', 'users.tipodocumento_id')
            // ->role('Administrador')->get();
            // dd($this->userRepository->getAllAdministradores());
            

            if (request()->ajax()) {
                return datatables()->of($this->userRepository->getAllAdministradores())
                    ->addColumn('detail', function ($data) {
                         $button = '<a class="waves-effect waves-light btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver Lineas" href="#modal1" onclick="detalles('. $data->id .')"><i class="material-icons">info_outline</i></a>';

                    return $button;
                    })
                    ->addColumn('edit', function ($data) {
                        $button = '<a href="' . route("usuario.administrador.edit", $data->id) . '" class="waves-effect waves-light btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';
                        return $button;
                    })
                    ->editColumn('estado', function ($data) {
                        if ($data->estado == User::IsActive()) {
                            return $data->estado = 'Habilitado';
                        } else {
                            return $data->estado = 'Inhabilitado ';
                        }
                    })
                    ->rawColumns(['detail','edit'])
                    ->make(true);
            }

            return view('users.administrador.administrador.index');
        } else {
            abort(403);
        } 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.administrador.administrador.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'user' => $this->userRepository->findByid($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
