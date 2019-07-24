<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Session, Validator};
use App\Http\Requests\{EdtFormRequest};
use App\Repositories\Repository\{EntidadRepository, EdtRepository};
use App\Models\{Edt, TipoEdt, AreaConocimiento};
use App\User;

class EdtController extends Controller
{

  /**
   * Un objeto la clase EntidadRepository
   * @var object
   */
  public $entidadRepository;
  /**
   * Objeto de la clase EdtRepository
   * @var object
   */
  private $edtRepository;
  public function __construct(EntidadRepository $entidadRepository, EdtRepository $edtRepository)
  {
    $this->entidadRepository = $entidadRepository;
    $this->edtRepository = $edtRepository;
    $this->middleware('auth');
  }

  /**
   * función para consultar las entidades (empresas) de una edt
   * @param init id Id de la edt
   * @return Response
   */
  public function consultarEntidadesDeUnaEdt($id)
  {
    if (request()->ajax()) {
      $entidades = $this->edtRepository->entidadesDeUnaEdt($id);
      dd($entidades);
      return response()->json([
        'entidades' => $entidades,
      ]);
    }
  }

  /**
   * Entregables de una edt
   * @param int id Id de la edt
   * @return Response
   */
  public function entregables($id)
  {

  }

  /**
  * Datatable que muestra las edts
  * @param object consulta Consulta la cual se generará la datatable
  * @return Response
  */
  private function datatableEdts($consulta)
  {
    return datatables()->of($consulta)
    ->addColumn('details', function ($data) {
      $details = '
      <a class="btn light-blue m-b-xs" onclick="detallesDeUnaEdt(' . $data->id . ')">
        <i class="material-icons">info</i>
      </a>
      ';
      return $details;
    })->addColumn('edit', function ($data) {
      if ( $data->estado == 'Inactiva') {
        $edit = '<a class="btn m-b-xs" disabled><i class="material-icons">edit</i></a>';
      } else {
        $edit = '<a class="btn m-b-xs" href='.route('edt.edit', $data->id).'><i class="material-icons">edit</i></a>';
      }
      return $edit;
    })->addColumn('entregables', function ($data) {
      $entregables = '
      <a class="btn blue-grey m-b-xs" href='. route('edt.entregables', $data->id) .'>
        <i class="material-icons">library_books</i>
      </a>
      ';
      return $entregables;
    })->addColumn('business', function ($data) {
      $empresas = '
      <a class="btn cyan m-b-xs" onclick="verEntidadesDeUnaEdt(' . $data->id . ')">
        <i class="material-icons">business</i>
      </a>
      ';
      return $empresas;
    })->rawColumns(['details', 'edit', 'business', 'entregables'])->make(true);
  }

  /**
   * Muestra las edts de un gestor
   * @param int id Id de un gestor
   * @return Response
   */
  public function consultarEdtsDeUnGestor($idgestor)
  {
    $id = "";
    if ( Session::get('login_role') == User::IsGestor() ) {
      $id = auth()->user()->gestor->id;
    }
    $edts = $this->edtRepository->consultarEdtsDeUnGestor($id);
    return $this->datatableEdts($edts);
  }

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    dd($this->edtRepository->entidadesDeUnaEdt(2));
    if ( Session::get('login_role') == User::IsGestor() ) {
      return view('edt.gestor.index');
    }
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view('edt.gestor.create', [
      'areasconocimiento' => AreaConocimiento::all()->pluck('nombre', 'id'),
      'tiposedt' => TipoEdt::all(),
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
    $req = new EdtFormRequest;
    $validator = Validator::make($request->all(), $req->rules(), $req->messages());
    if ($validator->fails()) {
      return response()->json([
        'fail' => true,
        'errors' => $validator->errors(),
      ]);
    }
    $result = $this->edtRepository->storeEdtRepository($request);
    if ($result == false) {
      return response()->json([
        'fail' => false,
        'redirect_url' => "false"
      ]);
    } else {
      return response()->json([
        'fail' => false,
        'redirect_url' => url(route('edt'))
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

}
