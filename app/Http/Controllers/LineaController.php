<?php

namespace App\Http\Controllers;

use App\Http\Requests\LineaFormRequest;
use App\Models\Linea;
use Illuminate\Http\Request;
use Alert;

class LineaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $this->authorize('view','Administrador');

        if (auth()->user()->hasRole('Administrador') || auth()->user()->hasPermissionTo('consultar linea')) {
            // $lineas = Linea::select('id','abreviatura', 'nombre', 'descripcion','created_at','updated_at')->get();
            if (request()->ajax()) {
                return datatables()->of(Linea::all())
                    ->addColumn('action', function ($data) {
                        $button = '<a href="' . route("lineas.edit", $data->id) . '" class="waves-effect waves-light btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';

                        return $button;
                    })->rawColumns(['action'])
                    ->make(true);
            }
            return view('lineas.administrador.index');
        } else {
            abort(403);
        }

    }

    /**
     * Show the form for creating a new resource.s
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lineas.administrador.create');

        // abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LineaFormRequest $request)
    {


        $linea = Linea::create([
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
        // $this->authorize('view',$id);
        $linea = Linea::findOrFail($id);
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
        $linea = Linea::findOrFail($id);

        if ($linea != null) {
            $linea->abreviatura = $request->input('txtabreviatura');
            $linea->nombre = $request->input('txtnombre');
            $linea->descripcion = $request->input('txtdescripcion');
            $linea->update();

            Alert::success("La Linea {$linea->nombre} ha sido actualizado modificado.",'Modificación Exitosa',"success");
            // alert('Hello World!',"success","success","success")->autoclose(3000);

        }else{
            Alert::error("La Linea no se ha modificado.", 'Modificación Errónea', "error");
        }
        


        return redirect('lineas');
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
