<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Repository\UserRepository\DinamizadorRepository;
use App\User;
use Illuminate\Http\Request;

class DinamizadorController extends Controller
{

    public $dinamizadorRepository;

    public function __construct(DinamizadorRepository $dinamizadorRepository)
    {
        // $this->middleware('auth');
        $this->dinamizadorRepository = $dinamizadorRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nodos = $this->dinamizadorRepository->getAllNodos();

        return view('users.administrador.dinamizador.index', [
            'nodos' => $this->dinamizadorRepository->getAllNodos(),
        ]);
    }

    public function getDinanizador($nodo)
    {

        if (request()->ajax()) {
            return datatables()->of($this->dinamizadorRepository->getAllDinamizadoresPorNodo($nodo))
                 ->addColumn('detail', function ($data) {
                        
                        $button = '<a class="  btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver Lineas" href="#modal1" onclick=""><i class="material-icons">info_outline</i></a>';

                        return $button;
                    })
                    ->addColumn('edit', function ($data) {
                        if ($data->id != auth()->user()->id) {
                            $button = '<a href="' . route("usuario.administrador.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';
                        }else{
                            $button = '';
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

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
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
