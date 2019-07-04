<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Sector, Departamento, TipoArticulacion, Talento, Articulacion};
use App\Http\Requests\ArticulacionFormRequest;
use Carbon\Carbon;
use App\Repositories\Repository\{ArticulacionRepository, EmpresaRepository, GrupoInvestigacionRepository};
use App\Helpers\ArrayHelper;

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

  // Vista para subir los entregables de una articulación
  public function entregables($id)
  {
    if ( auth()->user()->rol()->first()->nombre == 'Gestor' ) {
      $articulacion = $this->articulacionRepository->consultarArticulacionPorId($id)->last();
      // dd($articulacion);
      return view('articulaciones.gestor.entregables',[
        'articulacion' => $articulacion
      ]);
    }
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
        })->rawColumns(['details', 'edit', 'entregables', 'revisado_final'])->make(true);
      }
    } else if (auth()->user()->rol()->first()->nombre == 'Dinamizador') {

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
    $pivot = array();
    if (Articulacion::find($id)->tipo_articulacion == Articulacion::IsEmprendedor()) {
      $pivot = $this->articulacionRepository->consultarArticulacionTalento($id);
    }
    if (auth()->user()->rol()->first()->nombre == 'Gestor') {
      return view('articulaciones.gestor.edit', [
        'articulacion' => Articulacion::find($id),
        'pivot' => $pivot,
      ]);
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
