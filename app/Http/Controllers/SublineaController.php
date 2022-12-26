<?php

namespace App\Http\Controllers;

use App\Repositories\Repository\SublineaRepository;
use Illuminate\Http\Request;
use App\Http\Requests\SublineaFormRequest;

class SublineaController extends Controller
{

    public $sublineaRepository;
    public function __construct(SublineaRepository $sublineaRepository)
    {
        $this->sublineaRepository = $sublineaRepository;
       
        $this->middleware([
            'auth',
        ]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // dd($this->sublineaRepository->getAllSublineas());

        if (request()->ajax()) {
                return datatables()->of($this->sublineaRepository->getAllSublineas())
                    
                    ->addColumn('edit', function ($data) {
                        
                            $button = '<a href="' . route("sublineas.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';
                        
                        return $button;
                    })
                    ->rawColumns([ 'edit'])
                    ->make(true);
            }
        
        return view('sublineas.administrador.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         
        return view('sublineas.administrador.create',[
            'lineas' => $this->sublineaRepository->getAllLineas(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SublineaFormRequest $request)
    {
        $sublineaStore = $this->sublineaRepository->store($request);
        if ($sublineaStore != null) {
            alert()->success('Registro Exitoso.',"La sublinea {$sublineaStore->nombre} ha creado satisfactoriamente");
        }else{
            alert()->error('Registro Erróneo.','La linea no se ha creado.');
        }

        return redirect()->route('sublineas.index'); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('sublineas.administrador.edit',[
            'sublinea' => $this->sublineaRepository->findById($id),
            'lineas' => $this->sublineaRepository->getAllLineas(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SublineaFormRequest $request, $id)
    {
        $sublinea = $this->sublineaRepository->findById($id);
        $sublineaUpdate = $this->sublineaRepository->update($request, $sublinea);
        if ($sublineaUpdate == true) {
            alert()->success('Modificación Exitosa',"La sublinea ha sido  modificada satisgactoriamente.","success");
        }else{
            alert()->error('Modificación Errónea',"La sublinea {$sublinea->nombre} no se ha modificado.", "error");
        }

        return redirect()->route('sublineas.index'); 

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
