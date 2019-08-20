<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Session, Validator};
use App\Http\Requests\{EdtFormRequest};
use App\Repositories\Repository\{EntidadRepository, EdtRepository};
use App\Models\{Edt, TipoEdt, AreaConocimiento, Nodo};
use App\User;
use App\Helpers\ArrayHelper;
use Alert;

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
  * @param int id Id de la edt
  * @param boolean tipo Tipo de petición que se hace (si es 1, se consultará para mostrar la entidades, si es 0 se consultará para mostrar información de la edt)
  * @return Response
  * @author Victor Manuel Moreno Vega
  */
  public function consultarDetallesDeUnaEdt($id, $tipo)
  {
    if (request()->ajax()) {
      $edt = $this->edtRepository->consultarDetalleDeUnaEdt($id)->toArray();
      $edt = ArrayHelper::validarDatoNullDeUnArray($edt);
      if ($tipo = 1) {
        $entidades = $this->edtRepository->entidadesDeUnaEdt($id);
        return response()->json([
          'entidades' => $entidades,
          'edt' => $edt
        ]);
      } else {
        return response()->json([
          'edt' => $edt,
        ]);
      }
    }
  }

  /**
   * Entregables de una edt
   * @param int id Id de la edt
   * @return Response
   * @author Victor Manuel Moreno Vega
   */
  public function entregables($id)
  {
    $edt = $this->edtRepository->consultarDetalleDeUnaEdt($id);
    // $edt = ArrayHelper::validarDatoNullDeUnArray($edt);
    if ( Session::get('login_role') == User::IsGestor() ) {
      return view('edt.gestor.evidencias', [
        'edt' => $edt,
      ]);
    } else if ( Session::get('login_role') == User::IsDinamizador() ) {
      return view('edt.dinamizador.evidencias', [
        'edt' => $edt
      ]);
    } else {
      return view('edt.dinamizador.evidencias', [
        'edt' => $edt
      ]);
    }
  }

  /**
  * Datatable que muestra las edts
  * @param object consulta Consulta la cual se generará la datatable
  * @return Response
  * @author Victor Manuel Moreno Vega
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
   * datatable para mostrar las edts de un nodo
   * @param int idnodo Id del nodo
   * @return Collection
   */
  public function consultarEdtsDeUnNodo($idnodo)
  {
    $id = "";
    if ( Session::get('login_role') == User::IsDinamizador() ) {
      $id = auth()->user()->dinamizador->nodo_id;
    } else {
      $id = $idnodo;
    }
    $edts = $this->edtRepository->consultarEdtsDeUnNodo($id);
    return $this->datatableEdts($edts);
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
    if ( Session::get('login_role') == User::IsGestor() ) {
      return view('edt.gestor.index');
    } else if ( Session::get('login_role') == User::IsDinamizador() ) {
      return view('edt.dinamizador.index');
    } else {
      return view('edt.administrador.index', [
        'nodos' => Nodo::SelectNodo()->get()
      ]);
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
    return view('edt.gestor.edit', [
      'edt' => $this->edtRepository->consultarDetalleDeUnaEdt($id),
      'areasconocimiento' => AreaConocimiento::all()->pluck('nombre', 'id'),
      'tiposedt' => TipoEdt::all(),
      'entidades' => $this->edtRepository->entidadesDeUnaEdt($id)
    ]);
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
    $req = new EdtFormRequest;
    $validator = Validator::make($request->all(), $req->rules(), $req->messages());
    if ($validator->fails()) {
      return response()->json([
        'fail' => true,
        'errors' => $validator->errors(),
      ]);
    }
    $result = $this->edtRepository->updateEdtRepository($request, $id);
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
  * Modifica los entregables de una edt
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function updateEntregables(Request $request, $id)
  {
    $result = $this->edtRepository->updateEntregableRepository($request, $id);
    if ($result) {
      Alert::success('Los entregables de la EDT se han modificado exitosamente!', 'Modificación Existosa!')->showConfirmButton('Ok', '#3085d6');
      return redirect('edt');
    } else {
      Alert::error('Los entregables de la EDT no se han modificado!', 'Modificación Errónea!')->showConfirmButton('Ok', '#3085d6');
    }
  }
}
