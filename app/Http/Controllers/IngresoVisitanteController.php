<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\IngresoVisitanteFormRequest;
use Illuminate\Support\Facades\{Session, Validator};
use App\Repositories\Repository\{IngresoVisitanteRepository};
use App\{User, Models\Ingreso, Models\TipoVisitante, Models\TipoDocumento, Models\Servicio, Models\Visitante};
use Alert;
use Carbon\Carbon;

class IngresoVisitanteController extends Controller
{

  /**
   * Objeto de la clase IngresoVisitanteRepository
   * @var object
   */
  public $ingresoVisitanteRepository;

  public function __construct(IngresoVisitanteRepository $ingresoVisitanteRepository)
  {
    $this->ingresoVisitanteRepository = $ingresoVisitanteRepository;
  }

  /**
   * Pinta la datatable para datos de los ingresos de visitantes
   * @param object $ingresos Datos de los cuales se mostrarán la datatable para ingresos
   * @return Response
   */
  private function datatableIngresos($ingresos)
  {
    return datatables()->of($ingresos)
    ->addColumn('edit', function ($data) {
      $edit = '<a class="btn m-b-xs" href='.route('visitante.edit', $data->id).'><i class="material-icons">edit</i></a>';
      return $edit;
    })->addColumn('details', function ($data) {
      $edit = '<a class="btn blue-grey m-b-xs" onclick="consultarDetalleDeUnIngreso('.$data->id.')"><i class="material-icons">info</i></a>';
      return $edit;
    })->rawColumns(['edit', 'details'])->make(true);
  }

  /**
   * Consulta los ingresos de un nodo de tecnoparque
   * @param int $id Id del nodo por el que se consultaran los ingresos de visitantes
   * @return Response
   */
  public function datatableIngresosDeUnNodo($id)
  {
    if ( Session::get('login_role') == User::IsIngreso() ) {
      $ingresos = $this->ingresoVisitanteRepository->consultarIngresosDeUnNodoRepository(auth()->user()->ingreso->nodo_id);
    } else if ( Session::get('login_role') == User::IsDinamizador() ) {
      $ingresos = $this->ingresoVisitanteRepository->consultarIngresosDeUnNodoRepository(auth()->user()->dinamizador->nodo_id);
    } else {
      $ingresos = $this->ingresoVisitanteRepository->consultarIngresosDeUnNodoRepository($id);
    }
    return $this->datatableIngresos($ingresos);
  }
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    // dd(Carbon::now()->isoFormat('YYYY'));
    if ( Session::get('login_role') == User::IsIngreso() ) {
      return view('ingreso.ingreso.index');
    } else if ( Session::get('login_role') == User::IsDinamizador() ) {
      return view('ingreso.dinamizador.index');
    } else {
      return view('ingreso.administrador.index');
    }
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view('ingreso.ingreso.create', [
      'tiposdocumento' => TipoDocumento::all()->pluck('nombre', 'id'),
      'tiposvisitante' => TipoVisitante::all()->pluck('nombre', 'id'),
      'servicios' => Servicio::all()->pluck('nombre', 'id')
    ]);
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    $req = new IngresoVisitanteFormRequest;
    $validator = Validator::make($request->all(), $req->rules(), $req->messages());
    if ($validator->fails()) {
      return response()->json([
      'fail' => true,
      'errors' => $validator->errors(),
      ]);
    }
    $result = $this->ingresoVisitanteRepository->storeIngresoVisitanteRepository($request);
    // dd($result['store']);
    if ($result['store'] == false) {
      return response()->json([
      'fail' => false,
      'redirect_url' => false
      ]);
    } else {
      return response()->json([
      'fail' => false,
      'redirect_url' => url(route('ingreso.create'))
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
