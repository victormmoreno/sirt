<?php

namespace App\Http\Controllers\User;

use App\Models\Rols;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Repository\UserRepository\AdminRepository;

class AdminController extends Controller
{


    public $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->middleware('auth');
        $this->adminRepository = $adminRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function administradorIndex()
    {
        
        if (auth()->user()->hasRole('Administrador') || auth()->user()->hasPermissionTo('consultar linea')) {

            // $administradores = User::
            // Join('tiposdocumentos', 'tiposdocumentos.id', '=', 'users.tipodocumento_id')
            // ->role('Administrador')->get();
            // dd($this->userRepository->getAllAdministradores());
            

            if (request()->ajax()) {
                return datatables()->of($this->adminRepository->getAllAdministradores())
                    ->addColumn('detail', function ($data) {
                         $button = '<a class="  btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver Lineas" href="#modal1" onclick="detalleAdministrador('. $data->id .')"><i class="material-icons">info_outline</i></a>';

                    return $button;
                    })
                    ->addColumn('edit', function ($data) {
                        $button = '<a href="' . route("usuario.administrador.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';
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
    public function administradorCreate()
    {
        $tiposdocumentos = $this->adminRepository->getAllTipoDocumento();
        return view('users.administrador.administrador.create',compact('tiposdocumentos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function administradorStore(Request $request)
    {

        dd($request->all());
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
            'user' => $this->adminRepository->getFindDetailByid($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function administradorEdit($id)
    {
        
        // $user = $this->adminRepository->findById($id);
        // $user['fechanacimiento'] = $user->fechanacimiento->format('Y-m-d');
        // dd($user->fechanacimiento);
        return view('users.administrador.administrador.edit',[
            'tiposdocumentos' => $this->adminRepository->getAllTipoDocumento(),
            'user' => $this->adminRepository->findById($id),
            'gradosescolaridad' => $this->adminRepository->getSelectAllGradosEscolaridad(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function administradorUpdate(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function administradorDelete($id)
    {
        //
    }
}
