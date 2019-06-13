<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ComiteFormRequest;
use App\Repositories\Repository\ComiteRepository;
use App\Models\Nodo;

class ComiteController extends Controller
{

  public $comiteRepository;

  public function __construct(ComiteRepository $comiteRepository)
  {
    $this->comiteRepository = $comiteRepository;
    $this->middleware('auth');
  }

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    if ( auth()->user()->rol()->first()->nombre == 'Infocenter' ) {
      if (request()->ajax()) {
        $csibt = $this->comiteRepository->consultarComitesPorNodo( auth()->user()->infocenter->nodo_id );
        return datatables()->of($csibt)
        ->addColumn('details', function ($data) {
          $button = '
          <a class="btn light-blue m-b-xs modal-trigger" href="#modal1" onclick="csibt.consultarComitesPorNodo('. $data->id .')">
          <i class="material-icons">info</i>
          </a>
          ';
          return $button;
        })->addColumn('edit', function ($data) {
          $edit = '<a href="'. route("csibt.edit", $data->id) .'" class="btn m-b-xs"><i class="material-icons">edit</i></a>';
          return $edit;
        })->rawColumns(['details', 'edit'])->make(true);
      }
      return view('comite.infocenter.index');
    } else if ( auth()->user()->rol()->first()->nombre == 'Gestor' ) {
      if (request()->ajax()) {
        $csibt = $this->comiteRepository->consultarComitesPorNodo( auth()->user()->gestor->nodo_id );
        return datatables()->of($csibt)
        ->addColumn('details', function ($data) {
          $button = '
          <a class="btn light-blue m-b-xs modal-trigger" href="#modal1" onclick="csibt.consultarComitesPorNodo('. $data->id .')">
          <i class="material-icons">info</i>
          </a>
          ';
          return $button;
        })->rawColumns(['details'])->make(true);
      }
      return view('comite.gestor.index');
    } else if ( auth()->user()->rol()->first()->nombre == 'Administrador' ) {
      $nodos = Nodo::SelectNodo()->get();
      return view('comite.administrador.index', compact('nodos'));
    } else if (auth()->user()->rol()->first()->nombre == 'Dinamizador') {
      if (request()->ajax()) {
        $csibt = $this->comiteRepository->consultarComitesPorNodo( auth()->user()->dinamizador->nodo_id );
        return datatables()->of($csibt)
        ->addColumn('details', function ($data) {
          $button = '
          <a class="btn light-blue m-b-xs modal-trigger" href="#modal1" onclick="csibt.consultarComitesPorNodo('. $data->id .')">
          <i class="material-icons">info</i>
          </a>
          ';
          return $button;
        })->rawColumns(['details'])->make(true);
      }
      return view('comite.dinamizador.index');
    }
  }

  public function datatableCsibtPorNodo_Administrador($id)
  {
    if (request()->ajax()) {
      return datatables()->of($this->comiteRepository->consultarComitesPorNodo($id))
      ->addColumn('details', function ($data) {
        $button = '
        <a class="btn light-blue m-b-xs modal-trigger" href="#modal1" onclick="csibt.consultarComitesPorNodo('. $data->id .')">
        <i class="material-icons">info</i>
        </a>
        ';
        return $button;
      })->rawColumns(['details'])->make(true);
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
    if (request()->ajax()) {
      return json_encode([
        'ideasDelComite' => $this->comiteRepository->consultarIdeasDelComite($id)
      ]);
    }
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
