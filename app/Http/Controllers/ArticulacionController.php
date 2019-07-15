<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Sector, Departamento, TipoArticulacion, Talento, Articulacion, Nodo, Gestor};
use App\Http\Requests\ArticulacionFormRequest;
use Carbon\Carbon;
use App\Repositories\Repository\{ArticulacionRepository, EmpresaRepository, GrupoInvestigacionRepository};
use App\Helpers\ArrayHelper;
Use App\User;

class ArticulacionController extends Controller
{

  private $articulacionRepository;
  private $empresaRepository;
  private $grupoInvestigacionRepository;

  public function __construct(ArticulacionRepository $articulacionRepository, EmpresaRepository $empresaRepository, GrupoInvestigacionRepository $grupoInvestigacionRepository)
  {
    $this->articulacionRepository = $articulacionRepository;
    $this->empresaRepository = $empresaRepository;
    $this->grupoInvestigacionRepository = $grupoInvestigacionRepository;
    $this->middleware([
      'auth',
    ]);
  }

  // Consulta el detalle de la entidad asociada a la articulación
  public function consultarEntidadDeLaArticulacion($id)
  {
    $articulacionObj = Articulacion::findOrFail($id);
    $articulacion = $this->articulacionRepository->consultarArticulacionPorId($id)->last()->toArray();
    $entidad = null;
    if ($articulacionObj->tipo_articulacion == Articulacion::IsEmpresa()) {
      $entidad = $this->empresaRepository->consultarDetallesDeUnaEmpresa($articulacionObj->entidad->empresa->id)->toArray();
      $entidad = ArrayHelper::validarDatoNullDeUnArray($entidad);
    } else if ($articulacionObj->tipo_articulacion == Articulacion::IsGrupo()) {
      $entidad = $this->grupoInvestigacionRepository->consultarDetalleDeUnGrupoDeInvestigacion(21)->toArray();
      $entidad = ArrayHelper::validarDatoNullDeUnArray($entidad);
      // $entidad = $this->grupoInvestigacionRepository->consultarDetalleDeUnGrupoDeInvestigacion($articulacionObj->entidad->grupoinvestigacion->id)->toArray();
    } else {
      $entidad = $this->articulacionRepository->consultarArticulacionTalento($id)->toArray();
    }
    return response()->json([
      'detalles' => $entidad,
      'articulacion' => $articulacion
    ]);
  }

  // Consulta los detalles de los entregables de una articulacion (Solo los checkboxes)
  public function detallesDeLosEntregablesDeUnaArticulacion($id)
  {
    $entregables = $this->articulacionRepository->consultaEntregablesDeUnaArticulacion($id)->last()->toArray();
    $entregables = ArrayHelper::validarEntregablesNullDeUnArrayString($entregables);
    $articulacion = $this->articulacionRepository->consultarArticulacionPorId($id)->last()->toArray();
    return response()->json([
      'entregables' => $entregables,
      'articulacion' => $articulacion,
    ]);
  }

  // Consulta los datos de una articulación por su id
  public function detallesDeUnArticulacion($id)
  {
    $detalles = $this->articulacionRepository->consultarArticulacionPorId($id)->last()->toArray();
    $detalles = ArrayHelper::validarDatoNullDeUnArray($detalles);
    return response()->json([
      'detalles' => $detalles,
    ]);
  }

  // Modificar los entregable para una articulación
  public function updateEntregables(Request $request, $id)
  {
    if (\Session::get('login_role') == User::IsGestor()) {
      !isset($request['entregable_acta_inicio']) ? $request['entregable_acta_inicio'] = 0 : $request['entregable_acta_inicio'] = 1;
      !isset($request['entregable_acuerdo_confidencialidad_compromiso']) ? $request['entregable_acuerdo_confidencialidad_compromiso'] = 0 : $request['entregable_acuerdo_confidencialidad_compromiso'] = 1;
      !isset($request['entregable_acta_seguimiento']) ? $request['entregable_acta_seguimiento'] = 0 : $request['entregable_acta_seguimiento'] = 1;
      !isset($request['entregable_acta_cierre']) ? $request['entregable_acta_cierre'] = 0 : $request['entregable_acta_cierre'] = 1;
      !isset($request['entregable_informe_final']) ? $request['entregable_informe_final'] = 0 : $request['entregable_informe_final'] = 1;
      !isset($request['entregable_encuesta_satisfaccion']) ? $request['entregable_encuesta_satisfaccion'] = 0 : $request['entregable_encuesta_satisfaccion'] = 1;
      !isset($request['entregable_otros']) ? $request['entregable_otros'] = 0 : $request['entregable_otros'] = 1;
      $entregablesArticulacion = $this->articulacionRepository->updateEntregablesArticulacion($request, $id);
      alert()->success('Modificación Exitosa!','Los entregables de la articulación se han modificado con éxito.')->showConfirmButton('Ok', '#3085d6');
      return redirect('articulacion');
    }
    if (\Session::get('login_role') == User::IsDinamizador()) {
      $articulacion = $this->articulacionRepository->consultarArticulacionPorId($id)->last();
      if ($request['txtrevisado'] == 0) {
        $articulacionRevisadoFinal = $this->articulacionRepository->updateRevisadoFinalArticulacion($request, $id);
        alert()->success('Modificación Exitosa!','El revisado final de la articulación se ha modificado con éxito.')->showConfirmButton('Ok', '#3085d6');
        return redirect('articulacion');
      } else {
        if ($articulacion->estado != 'Ejecución') {
          alert()->warning('Advertencia!','Para cambiar el revisado final de una articulación, esta debe estar en estado de Ejecución.')->showConfirmButton('Ok', '#3085d6');
          return back();
        } else {
          $articulacionRevisadoFinal = $this->articulacionRepository->updateRevisadoFinalArticulacion($request, $id);
          alert()->success('Modificación Exitosa!','El revisado final de la articulación se ha modificado con éxito.')->showConfirmButton('Ok', '#3085d6');
          return redirect('articulacion');
        }
      }
    }
  }

  // Vista para subir los entregables de una articulación
  public function entregables($id)
  {
    $articulacion = $this->articulacionRepository->consultarArticulacionPorId($id)->last();
    if ( \Session::get('login_role') == User::IsGestor() ) {
      // $articulacion = $this->articulacionRepository->consultarArticulacionPorId($id)->last();
      return view('articulaciones.gestor.entregables',[
        'articulacion' => $articulacion,
      ]);
    } else if ( \Session::get('login_role') == User::IsDinamizador() ) {
      return view('articulaciones.dinamizador.entregables', [
        'articulacion' => $articulacion,
      ]);
    } else if (\Session::get('login_role') == User::IsAdministrador()) {
      return view('articulaciones.administrador.entregables', [
        'articulacion' => $articulacion,
      ]);
    } else {
      return back();
    }
  }

  // Datatable para mostrar las articulaciones POR NODO
  public function datatableArticulacionesPorNodo($id)
  {
    if (request()->ajax()) {
      if (\Session::get('login_role') == User::IsDinamizador()) {
        $articulaciones =$this->articulacionRepository->consultarArticulacionesDeUnNodo( auth()->user()->dinamizador->nodo_id );
      } else {
        $articulaciones =$this->articulacionRepository->consultarArticulacionesDeUnNodo( $id );
      }
      return datatables()->of($articulaciones)
      ->addColumn('details', function ($data) {
        $button = '
        <a class="btn light-blue m-b-xs" onclick="detallesDeUnaArticulacion(' . $data->id . ')">
        <i class="material-icons">info</i>
        </a>
        ';
        return $button;
      })->addColumn('edit', function ($data) {
        $edit = '<a class="btn m-b-xs" href='.route('articulacion.edit', $data->id).'><i class="material-icons">edit</i></a>';
        return $edit;
      })->addColumn('entregables', function ($data) {
        $button = '
        <a class="btn blue-grey m-b-xs" href='. route('articulacion.entregables', $data->id) .'>
        <i class="material-icons">library_books</i>
        </a>
        ';
        return $button;
      })->editColumn('revisado_final', function ($data) {
        if ($data->revisado_final == 'Por Evaluar') {
          return '<div class="card-panel blue lighten-4"><span><i class="material-icons left">query_builder</i>'.$data->revisado_final.'</span></div>';
        } else if ($data->revisado_final == 'Aprobado') {
          return '<div class="card-panel green lighten-4"><span><i class="material-icons left">done_all</i>'.$data->revisado_final.'</span></div>';
        } else {
          return '<div class="card-panel red lighten-4"><span><i class="material-icons left">close</i>'.$data->revisado_final.'</span></div>';
        }
        return '<span class="red-text">'.$data->revisado_final.'</span>';
      })->editColumn('estado', function($data){
        if ($data->estado == 'Inicio') {
          return $data->estado . '</br><div class="progress grey lighten-2"><div class="determinate red" style="width: 33%"></div></div>';
        } else if ($data->estado == 'Ejecución' || $data->estado == 'Co-Ejecución') {
          return $data->estado . '</br><div class="progress grey lighten-2"><div class="determinate yellow" style="width: 66%"></div></div>';
        } else {
          return $data->estado . '</br><div class="progress grey lighten-2"><div class="determinate green" style="width: 100%"></div></div>';
        }
      })->rawColumns(['details', 'edit', 'entregables', 'revisado_final', 'estado'])->make(true);
    }
  }

  // Datatable para mostrar las articulaciones POR GESTOR
  public function datatableArticulaciones($id)
  {
    if ( \Session::get('login_role') == User::IsGestor() ) {
      if (request()->ajax()) {
        $articulaciones = $this->articulacionRepository->consultarArticulacionesDeUnGestor( auth()->user()->gestor->id );
        // dd($articulaciones);
        return datatables()->of($articulaciones)
        ->addColumn('details', function ($data) {
          $button = '
          <a class="btn light-blue m-b-xs" onclick="detallesDeUnaArticulacion(' . $data->id . ')">
          <i class="material-icons">info</i>
          </a>
          ';
          return $button;
        })->addColumn('edit', function ($data) {
          $edit = '<a class="btn m-b-xs" href='.route('articulacion.edit', $data->id).'><i class="material-icons">edit</i></a>';
          return $edit;
        })->addColumn('entregables', function ($data) {
          $button = '
          <a class="btn blue-grey m-b-xs" href='. route('articulacion.entregables', $data->id) .'>
          <i class="material-icons">library_books</i>
          </a>
          ';
          return $button;
        })->editColumn('estado', function($data){
          if ($data->estado == 'Inicio') {
            return $data->estado . '</br><div class="progress grey lighten-2"><div class="determinate red" style="width: 33%"></div></div>';
          } else if ($data->estado == 'Ejecución' || $data->estado == 'Co-Ejecución') {
            return $data->estado . '</br><div class="progress grey lighten-2"><div class="determinate yellow" style="width: 66%"></div></div>';
          } else {
            return $data->estado . '</br><div class="progress grey lighten-2"><div class="determinate green" style="width: 100%"></div></div>';
          }
        })->editColumn('revisado_final', function ($data) {
          if ($data->revisado_final == 'Por Evaluar') {
            return '<div class="card-panel blue lighten-4"><span><i class="material-icons left">query_builder</i>'.$data->revisado_final.'</span></div>';
          } else if ($data->revisado_final == 'Aprobado') {
            return '<div class="card-panel green lighten-4"><span><i class="material-icons left">done_all</i>'.$data->revisado_final.'</span></div>';
          } else {
            return '<div class="card-panel red lighten-4"><span><i class="material-icons left">close</i>'.$data->revisado_final.'</span></div>';
          }
          return '<span class="red-text">'.$data->revisado_final.'</span>';
        })->rawColumns(['details', 'edit', 'entregables', 'revisado_final', 'estado'])->make(true);
      }
    } else if (\Session::get('login_role') == User::IsDinamizador()) {
      $articulaciones = $this->articulacionRepository->consultarArticulacionesDeUnGestor( $id );
      return datatables()->of($articulaciones)
      ->addColumn('details', function ($data) {
        $button = '
        <a class="btn light-blue m-b-xs" onclick="detallesDeUnaArticulacion(' . $data->id . ')">
        <i class="material-icons">info</i>
        </a>
        ';
        return $button;
      })->addColumn('edit', function ($data) {
        $edit = '<a class="btn m-b-xs" href='.route('articulacion.edit', $data->id).'><i class="material-icons">edit</i></a>';
        return $edit;
      })->addColumn('entregables', function ($data) {
        $button = '
        <a class="btn blue-grey m-b-xs" href='. route('articulacion.entregables', $data->id) .'>
        <i class="material-icons">library_books</i>
        </a>
        ';
        return $button;
      })->editColumn('estado', function($data){
        if ($data->estado == 'Inicio') {
          return $data->estado . '</br><div class="progress grey lighten-2"><div class="determinate red" style="width: 33%"></div></div>';
        } else if ($data->estado == 'Ejecución' || $data->estado == 'Co-Ejecución') {
          return $data->estado . '</br><div class="progress grey lighten-2"><div class="determinate yellow" style="width: 66%"></div></div>';
        } else {
          return $data->estado . '</br><div class="progress grey lighten-2"><div class="determinate green" style="width: 100%"></div></div>';
        }
      })->editColumn('revisado_final', function ($data) {
        if ($data->revisado_final == 'Por Evaluar') {
          return '<div class="card-panel blue lighten-4"><span><i class="material-icons left">query_builder</i>'.$data->revisado_final.'</span></div>';
        } else if ($data->revisado_final == 'Aprobado') {
          return '<div class="card-panel green lighten-4"><span><i class="material-icons left">done_all</i>'.$data->revisado_final.'</span></div>';
        } else {
          return '<div class="card-panel red lighten-4"><span><i class="material-icons left">close</i>'.$data->revisado_final.'</span></div>';
        }
        return '<span class="red-text">'.$data->revisado_final.'</span>';
      })->rawColumns(['details', 'edit', 'entregables', 'revisado_final', 'estado'])->make(true);
    }
  }

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    switch (\Session::get('login_role')) {
      case User::IsAdministrador():
        return view('articulaciones.administrador.index', [
          'nodos' => Nodo::SelectNodo()->get(),
        ]);
        break;
      case User::IsDinamizador():
        return view('articulaciones.dinamizador.index', [
          'gestores' => Gestor::ConsultarGestoresPorNodo(auth()->user()->dinamizador->nodo_id)->pluck('nombres_gestor', 'id'),
        ]);
        break;
      case User::IsGestor():
        return view('articulaciones.gestor.index');
        break;

      default:
        return back();
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
    if (\Session::get('login_role') == User::IsGestor()) {
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
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    $articulacion = Articulacion::find($id);
    if ($articulacion->estado == Articulacion::IsCierre()) {
      alert()->warning('Advertencia!','No se puede realizar esta acción por el estado de la articulación es Cierre.')->showConfirmButton('Ok', '#3085d6');
      return back();
    } else {
      $pivot = array();
      if (Articulacion::find($id)->tipo_articulacion == Articulacion::IsEmprendedor()) {
        $pivot = $this->articulacionRepository->consultarArticulacionTalento($id);
      }
      if (\Session::get('login_role') == User::IsGestor()) {
        return view('articulaciones.gestor.edit', [
          'articulacion' => $articulacion,
          'pivot' => $pivot,
        ]);
      }

    }
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
    $req = new ArticulacionFormRequest;
    $validator = \Validator::make($request->all(), $req->rules(), $req->messages());
    if ($validator->fails()) {
      return response()->json([
        'fail' => true,
        'errors' => $validator->errors(),
      ]);
    }
    $result = $this->articulacionRepository->update($request, $id);
    // exit;
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

}
