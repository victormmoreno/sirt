<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sector;
use App\Models\Departamento;
use App\Models\TipoArticulacion;
use App\Models\Talento;
use App\Http\Requests\ArticulacionFormRequest;
use Carbon\Carbon;
use App\Repositories\Repository\ArticulacionRepository;

class ArticulacionController extends Controller
{

  private $articulacionRepository;
  // private $empresaRepository;

  public function __construct(ArticulacionRepository $articulacionRepository)
  {
    // $this->empresaRepository = $empresaRepository;
    $this->articulacionRepository = $articulacionRepository;
    $this->middleware([
      'auth',
    ]);
  }

  public function datatableArticulaciones($id)
  {
    if ( auth()->user()->rol()->first()->nombre == 'Gestor' ) {
      if (request()->ajax()) {
        $articulaciones = $this->articulacionRepository->consultarArticulacionesDeUnGestor( auth()->user()->gestor->id );
        // dd($articulaciones);
        return datatables()->of($articulaciones)
        ->addColumn('details', function ($data) {
          $button = '
          <a class="btn light-blue m-b-xs modal-trigger" href="#modal1">
          <i class="material-icons">info</i>
          </a>
          ';
          return $button;
        })->addColumn('edit', function ($data) {
          $edit = '<a class="btn m-b-xs"><i class="material-icons">edit</i></a>';
          return $edit;
        })->addColumn('entregables', function ($data) {
          $button = '
          <a class="btn blue-grey m-b-xs" >
          <i class="material-icons">library_books</i>
          </a>
          ';
          return $button;
        })->rawColumns(['details', 'edit', 'entregables'])->make(true);
      }
    }
  }

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    // dd($this->articulacionRepository->consultarArticulacionesDeUnGestor( auth()->user()->gestor->id ));

    switch (auth()->user()->rol()->first()->nombre) {
      case 'Administrador':

      break;
      case 'Dinamizador':

      break;
      case 'Gestor':
      return view('articulaciones.gestor.index');
      break;

      default:
      // code...
      break;
    }
  }


  // Consulta los tipos de articulaciones que se pueden realizar con grupos de investigación, empresas ó emprendedores
  public function consultarTipoArticulacion($tipo)
  {
    $tiposarticulacion = "";
    if ($tipo == 0) {
      $tiposarticulacion = TipoArticulacion::ConsultarTipoArticulacionConGruposDeInvestigacion()->get();
    } else {
      $tiposarticulacion = TipoArticulacion::ConsultarTipoArticulacionConEmpresasEmprendedores()->get();
    }
    return response()->json([
      'tiposarticulacion' => $tiposarticulacion,
    ]);
  }

  public function addTalentoCollectionCreate($id)
  {
    if (isset($collect)) {
      $collect = $collect->concat($id);
    } else {
      $collect = collect($id);
    }
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    if (auth()->user()->rol()->first()->nombre == 'Gestor') {
      return view('articulaciones.gestor.create');
    }
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    $req = new ArticulacionFormRequest;
    $validator = \Validator::make($request->all(), $req->rules(), $req->messages());
    if ($validator->fails()) {
      return response()->json([
        'fail' => true,
        'errors' => $validator->errors(),
      ]);
    }
    $result = $this->articulacionRepository->create($request);
    if ($result == false) {
      return response()->json([
          'fail' => false,
          'redirect_url' => false
      ]);
    } else {
      return response()->json([
          'fail' => false,
          'redirect_url' => url(route('articulacion'))
      ]);
    }
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
