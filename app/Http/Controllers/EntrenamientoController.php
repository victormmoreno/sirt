<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EntrenamientoFormRequest;
use App\Models\Idea;
use App\Models\Nodo;
use App\Repositories\Repository\EntrenamientoRepository;
use App\User;
use Carbon\Carbon;
use Alert;

class EntrenamientoController extends Controller
{

  public $entrenamientoRepository;

  public function __construct(EntrenamientoRepository $entrenamientoRepository)
  {
    $this->entrenamientoRepository = $entrenamientoRepository;
    $this->middleware('auth');
  }
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $nodo = Nodo::userNodo(auth()->user()->infocenter->nodo_id)->first()->nombre;

    if (request()->ajax()) {
      $entrenamientos = $this->entrenamientoRepository->consultarEntrenamientosPorNodo( auth()->user()->infocenter->nodo_id );
      return datatables()->of($entrenamientos)
      ->addColumn('details', function ($data) {
        $button = '
        <a class="btn light-blue m-b-xs modal-trigger" href="#modal1" onclick="detallesIdeasDelEntrenamiento('. $data->id .')">
        <i class="material-icons">info</i>
        </a>
        ';
        return $button;
      })->addColumn('update_state', function ($data) {
        $delete = '<a class="btn red lighten-3 m-b-xs"><i class="material-icons">delete_sweep</i></a>';
        return $delete;
      })->addColumn('edit', function ($data) {
        $edit = '<a href="' . route("entrenamientos.edit", $data->id) . '" class="btn m-b-xs"><i class="material-icons">edit</i></a>';
        return $edit;
      })->rawColumns(['details', 'edit', 'update_state'])->make(true);
    }

    if ( auth()->user()->rol()->first()->nombre == 'Infocenter' ) {
      return view('entrenamientos.infocenter.index', compact('nodo'));
    }
  }
  // Consulta las ideas que asistieron al entrenamiento
  public function details($id)
  {
    echo json_encode($this->entrenamientoRepository->consultarIdeasDelEntrenamiento($id));
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    $nodo = Nodo::userNodo(auth()->user()->infocenter->nodo_id)->first()->nombre;
    if ( auth()->user()->rol()->first()->nombre == 'Infocenter' ) {
      return view('entrenamientos.infocenter.create', compact('nodo'));
    }
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(EntrenamientoFormRequest $request)
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
