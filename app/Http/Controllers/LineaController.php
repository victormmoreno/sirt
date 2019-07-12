<?php

namespace App\Http\Controllers;

use Alert;
use App\Http\Requests\LineaFormRequest;
use App\Models\LineaTecnologica;
use App\Models\Rols;
use App\Repositories\Repository\LineaRepository;
use Illuminate\Http\Request;

class LineaController extends Controller
{
    public $lineaRepository;

    public function __construct(LineaRepository $lineaRepository)
    {
       
        $this->middleware([
            'auth',
            'role_or_permission:'                
                .config('laravelpermission.roles.roleAdministrador').'|'
                .config('laravelpermission.permissions.linea.index').'|'
                .config('laravelpermission.permissions.linea.register').'|'
                .config('laravelpermission.permissions.linea.edit'),
            
        ]);

        $this->lineaRepository = $lineaRepository;

    }


    /*=====================================================================
    =            metodo API para consultar las lineas por nodo            =
    =====================================================================*/
    
    public function getAllLineasForNodo($nodo)
    {
       if (request()->ajax()) {
            return response()->json([
                'lineasForNodo' =>  $this->lineaRepository->getAllLineaNodo($nodo),
            ]);
        }
    }
    
    
    /*=====  End of metodo API para consultar las lineas por nodo  ======*/
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
                
        if (request()->ajax()) {
            return datatables()->of(LineaTecnologica::all())
                ->addColumn('action', function ($data) {
                    $button = '<a href="' . route("lineas.edit", $data->id) . '" class="waves-effect waves-light btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';

                    return $button;
                })->rawColumns(['action'])
                ->make(true);
        }

        return view('lineas.administrador.index');

    }

    /**
     * Show the form for creating a new resource.s
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lineas.administrador.create');


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LineaFormRequest $request)
    {

        $linea = LineaTecnologica::create([
            "abreviatura" => $request->input('txtabreviatura'),
            "nombre"      => $request->input('txtnombre'),
            "descripcion" => $request->input('txtdescripcion'),
        ]);

        if ($linea != null) {
            Alert::success("La Linea {$linea->nombre} ha sido creado satisfactoriamente.",'Registro Exitoso',"success");
        }else{
            Alert::error("La linea  no se ha creado.",'Registro Erróneo', "error");
        }

        return redirect('lineas');

    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $linea = LineaTecnologica::findOrFail($id);
        return view('lineas.administrador.edit', compact('linea'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LineaFormRequest $request, $id)
    {
        $linea = LineaTecnologica::findOrFail($id);

        if ($linea != null) {
            $linea->abreviatura = $request->input('txtabreviatura');
            $linea->nombre = $request->input('txtnombre');
            $linea->descripcion = $request->input('txtdescripcion');
            $linea->update();

            Alert::success("La Linea {$linea->nombre} ha sido actualizado modificado.",'Modificación Exitosa',"success");

        }else{
            Alert::error("La Linea no se ha modificado.", 'Modificación Errónea', "error");
        }
        return redirect('lineas');
    }

    
}
