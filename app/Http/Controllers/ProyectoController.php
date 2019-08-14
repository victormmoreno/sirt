<?php

namespace App\Http\Controllers;

use Alert;
use App;
use App\Helpers\ArrayHelper;
use App\Http\Requests\ProyectoFormRequest;
use App\Models\{AreaConocimiento, Centro, Entidad, Gestor, EstadoPrototipo, EstadoProyecto, GrupoInvestigacion, Idea, Nodo, Proyecto, Sector, Sublinea, Tecnoacademia, TipoArticulacionProyecto, ArticulacionProyecto};
use App\Repositories\Repository\{EmpresaRepository, EntidadRepository, ProyectoRepository, UserRepository\GestorRepository, ArticulacionProyectoRepository};
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\{Str, Facades\Session, Facades\Validator};

class ProyectoController extends Controller
{

  private $empresaRepository;
  private $proyectoRepository;
  private $gestorRepository;
  private $entidadRepository;
  private $articulacionProyectoRepository;

  public function __construct(EmpresaRepository $empresaRepository, ProyectoRepository $proyectoRepository, GestorRepository $gestorRepository, EntidadRepository $entidadRepository, ArticulacionProyectoRepository $articulacionProyectoRepository)
  {
    $this->empresaRepository = $empresaRepository;
    $this->proyectoRepository = $proyectoRepository;
    $this->gestorRepository = $gestorRepository;
    $this->entidadRepository = $entidadRepository;
    $this->articulacionProyectoRepository = $articulacionProyectoRepository;
    $this->middleware(['auth']);
  }

  public function detallesDeLosEntregablesDeUnProyecto($id)
  {
    if (request()->ajax()) {
      $entregables = $this->consultarEntregablesDeUnProyectoController($id)->original['entregables'];
      return response()->json([
        'entregables' => $entregables,
        'proyecto'    => $this->proyectoRepository->consultarDetallesDeUnProyectoRepository($id),
      ]);
    }
  }

  public function consultarEntregablesDeUnProyectoController($id)
  {
    if (request()->ajax()) {
      $entregables = ArrayHelper::validarEntregablesNullDeUnArrayString($this->proyectoRepository->consultarEntregablesDeUnProyectoRepository($id)->toArray());
      return response()->json([
        'entregables' => $entregables,
      ]);
    } else {
      return ArrayHelper::validarEntregablesNullDeUnArrayString($this->proyectoRepository->consultarEntregablesDeUnProyectoRepository($id)->toArray());
    }
  }

  /**
  * @param Collection $proyecto Proyectos
  * @param Request $request
  * @return Response
  * @author Victor Manuel Moreno Vega
  */
  private function datatableProyectos($request, $proyectos)
  {
    return datatables()->of($proyectos)
    ->addColumn('details', function ($data) {
      $details = '
      <a class="btn light-blue m-b-xs" onclick="detallesDeUnProyecto(' . $data->id . ')">
      <i class="material-icons">info</i>
      </a>
      ';
      return $details;
    })->addColumn('edit', function ($data) {
      if ($data->estado_nombre == 'Cierre PMV' || $data->estado_nombre == 'Cierre PF' || $data->estado_nombre == 'Suspendido') {
        $edit = '<a class="btn m-b-xs" disabled><i class="material-icons">edit</i></a>';
      } else {
        $edit = '<a class="btn m-b-xs" href=' . route('proyecto.edit', $data->id) . '><i class="material-icons">edit</i></a>';
      }
      return $edit;
    })->addColumn('entregables', function ($data) {
      $entregables = '
      <a class="btn blue-grey m-b-xs" href=' . route('proyecto.entregables', $data->id) . '>
      <i class="material-icons">library_books</i>
      </a>
      ';
      return $entregables;
    })->editColumn('revisado_final', function ($data) {
      if ($data->revisado_final == 'Por Evaluar') {
        return '<div class="card-panel blue lighten-4"><span><i class="material-icons left">query_builder</i>' . $data->revisado_final . '</span></div>';
      } else if ($data->revisado_final == 'Aprobado') {
        return '<div class="card-panel green lighten-4"><span><i class="material-icons left">done_all</i>' . $data->revisado_final . '</span></div>';
      } else {
        return '<div class="card-panel red lighten-4"><span><i class="material-icons left">close</i>' . $data->revisado_final . '</span></div>';
      }
      return '<span class="red-text">' . $data->revisado_final . '</span>';
    })->addColumn('talentos', function ($data) {
      $talentos = '
      <a class="btn cyan m-b-xs" onclick="verTalentosDeUnProyecto(' . $data->articulacion_proyecto_id . ')">
      <i class="material-icons">assignment_ind</i>
      </a>
      ';
      return $talentos;
    })
    ->filter(function ($instance) use ($request) {
      if (!empty($request->get('codigo_proyecto'))) {
        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
          return Str::contains($row['codigo_proyecto'], $request->get('codigo_proyecto')) ? true : false;
        });
      }
      if (!empty($request->get('nombre'))) {
        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
          return Str::contains($row['nombre'], $request->get('nombre')) ? true : false;
        });
      }
      if (!empty($request->get('sublinea_nombre'))) {
        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
          return Str::contains($row['sublinea_nombre'], $request->get('sublinea_nombre')) ? true : false;
        });
      }
      if (!empty($request->get('estado_nombre'))) {
        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
          return Str::contains($row['estado_nombre'], $request->get('estado_nombre')) ? true : false;
        });
      }
      if (!empty($request->get('revisado_final'))) {
        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
          return Str::contains($row['revisado_final'], $request->get('revisado_final')) ? true : false;
        });
      }
      if (!empty($request->get('gestor'))) {
        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
          return Str::contains($row['gestor'], $request->get('gestor')) ? true : false;
        });
      }
      if (!empty($request->get('search'))) {
        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
          if (Str::contains(Str::lower($row['codigo_proyecto']), Str::lower($request->get('search')))){
            return true;
          }else if (Str::contains(Str::lower($row['nombre']), Str::lower($request->get('search')))) {
            return true;
          }else if (Str::contains(Str::lower($row['sublinea_nombre']), Str::lower($request->get('search')))) {
            return true;
          }else if (Str::contains(Str::lower($row['estado_nombre']), Str::lower($request->get('search')))) {
            return true;
          }else if (Str::contains(Str::lower($row['revisado_final']), Str::lower($request->get('search')))) {
            return true;
          }else if (Str::contains(Str::lower($row['gestor']), Str::lower($request->get('search')))) {
            return true;
          }
          return false;
        });
      }
    })->rawColumns(['details', 'edit', 'entregables', 'talentos', 'revisado_final'])->make(true);
  }

  /**
   * Muestra los proyectos de un nodo por año (de la fecha de cierre)
   * @param int $idnodo Id del nodo
   * @param string $anho Año para filtrar
   * @return Response
   * @author Victor Manuel Moreno Vega
   */
  public function datatableProyectosDelNodoPorAnho(Request $request, $idnodo, $anho)
  {
    if (request()->ajax()) {
      $id = "";
      if (\Session::get('login_role') == User::IsDinamizador()) {
        $id = auth()->user()->dinamizador->nodo_id;
      } else {
        $id = $idnodo;
      }
      $proyectos = $this->proyectoRepository->ConsultarProyectosPorNodoYPorAnho($id, $anho);
      return $this->datatableProyectos($request, $proyectos);
    }
  }

  /**
  * Consulta los detalle de un proyecto
  * @param int $id Id del proyecto
  * @return Response
  * @author Victor Manuel Moreno Vega
  */
  public function consultarDetallesDeUnProyecto($id)
  {
    if (request()->ajax()) {
      $proyecto = ArrayHelper::validarDatoNullDeUnArray($this->proyectoRepository->consultarDetallesDeUnProyectoRepository($id)->toArray());
      return response()->json([
      'proyecto' => $proyecto,
      ]);
    }
  }

  /**
  * Consulta los talentos de un proyecto
  * @param int $id Id de la activdad
  * @return Response
  * @author Victor Manuel Moreno Vega
  */
  public function consultarTalentosDeUnProyecto($id)
  {
    if (request()->ajax()) {
      $talentos = $this->articulacionProyectoRepository->consultarTalentosDeUnaArticulacionProyectoRepository($id);
      if (count($talentos) == 0) {
        $proyecto = "";
      } else {
        $proyecto = $talentos[0]->codigo_actividad;
      }

      return response()->json([
      'talentos' => $talentos,
      'proyecto' => $proyecto,
      ]);
    }
  }

  // modifica los entregables de un proyecto
  public function updateEntregables(Request $request, $id)
  {
    if (Session::get('login_role') == User::IsGestor()) {
      $validator = Validator::make($request->all(), [
        'txturl_videotutorial' => Rule::requiredIf(isset($request->txtvideo_tutorial)) . '|url|nullable'
      ], ['txturl_videotutorial.required' => 'La Url del Video es obligatoria.', 'txturl_videotutorial.url' => 'El formato de la Url del Video no es válido.']);

      if ($validator->fails()) {
        return back()
        ->withErrors($validator)
        ->withInput();
      }


      $update = $this->proyectoRepository->updateEntregablesProyectoRepository($request, $id);
      if ($update) {
        Alert::success('Modificación Existosa!', 'Los entregables del proyecto se han modificado!')->showConfirmButton('Ok', '#3085d6');
        return redirect('proyecto');
      } else {
        Alert::error('Modificación Errónea!', 'Los entregables del proyecto no se han modificado!')->showConfirmButton('Ok', '#3085d6');
      }
    } else {
      $proyecto = $this->proyectoRepository->consultarDetallesDeUnProyectoRepository($id);
      if ($proyecto->nombre_estadoproyecto != 'En ejecución' && $request->txtrevisado_final != ArticulacionProyecto::IsPorEvaluar()) {
        Alert::html('Advertencia!', 'Para realizar esta acción, el estado del proyecto debe ser "<b>En ejecución</b>"', 'warning')->showConfirmButton('Ok', '#3085d6');
        return back();
      } else {
        $update = $this->proyectoRepository->updateRevisadoFinalProyectoRepository($request, $id);
        if ($update) {
          Alert::success('Modificación Existosa!', 'El revisado final del proyecto se ha modificado!')->showConfirmButton('Ok', '#3085d6');
          return redirect('proyecto');
        } else {
          Alert::error('Modificación Errónea!', 'El revisado final del proyecto no se modificado!')->showConfirmButton('Ok', '#3085d6');
        }
      }
    }
  }

  // Vista de la vista de los entregables de un proyecto
  public function entregables($id)
  {
    $proyecto = $this->proyectoRepository->consultarDetallesDeUnProyectoRepository($id);
    $entregables = (object) $this->consultarEntregablesDeUnProyectoController($id);
    $entregables->url_videotutorial = $proyecto->url_videotutorial;
    if (\Session::get('login_role') == User::IsGestor()) {
      return view('proyectos.gestor.entregables', [
      'proyecto' => $proyecto,
      'entregables' => $entregables
      ]);
    } else if (\Session::get('login_role') == User::IsDinamizador()) {
      return view('proyectos.dinamizador.entregables', [
      'proyecto' => $proyecto,
      'entregables' => $entregables
      ]);
    } else {
      return view('proyectos.administrador.entregables', [
      'proyecto' => $proyecto,
      'entregables' => $entregables
      ]);
    }
  }

  /**
  * Consulta los proyectos de un gestor por año (De la fecha de cierre)
  * @param Request $request
  * @param int $id Id del gestor
  * @param string $anho Año por el que se filtran los proyectos
  * @return Response
  * @author Victor Manuel Moreno Vega
  */
  public function datatableProyectosDelGestorPorAnho(Request $request, $id, $anho)
  {
    if (request()->ajax()) {
      $idgestor = $id;
      if (\Session::get('login_role') == User::IsGestor()) {
        $idgestor = auth()->user()->gestor->id;
      }
      $proyectos = $this->proyectoRepository->ConsultarProyectosPorGestorYPorAnho($idgestor, $anho);
      return $this->datatableProyectos($request, $proyectos);
    }
  }

  // Datatable para listar las ideas de proyectos con emprendedores (que aprobaron el CSIBT)
  public function datatableIdeasConEmprendedores()
  {
    if (request()->ajax()) {
      $ideas = Idea::ConsultarIdeasAprobadasEnComite(auth()->user()->gestor->nodo_id)->get();
      // dd($ideas);
      return datatables()->of($ideas)
      ->addColumn('checkbox', function ($data) {
        $checkbox = '
        <a class="btn blue" onclick="asociarIdeaDeProyectoAProyecto(' . $data->consecutivo . ', \'' . $data->nombre_proyecto . '\', \'' . $data->codigo_idea . '\')">
          <i class="material-icons">done</i>
        </a>
        ';
        return $checkbox;
      })->rawColumns(['checkbox'])->make(true);
    }
  }

  // Datatable para listar las ideas de proyectos con emprendedores (que aprobaron el CSIBT)
  public function datatableIdeasConEmpresasGrupo()
  {

    // dd('$ideas');
    if (request()->ajax()) {
      $ideas = Idea::ConsultarIdeasConEmpresasGrupos(auth()->user()->gestor->nodo_id)->get();
      // dd($ideas);
      return datatables()->of($ideas)
      ->addColumn('checkbox', function ($data) {
        $checkbox = '
        <a class="btn blue" onclick="asociarIdeaDeProyectoAProyecto(' . $data->consecutivo . ', \'' . $data->nombre_proyecto . '\', \'' . $data->codigo_idea . '\')">

          <i class="material-icons">done</i>
        </a>
        ';
        return $checkbox;
      })->rawColumns(['checkbox'])->make(true);
    }
  }

  // Datatable para listar los nodos de tecnoparque
  public function datatableCentroFormacionTecnoparque()
  {
    if (request()->ajax()) {
      $centros = Centro::CentroDeFormacionDeTecnoparque()->get();
      return datatables()->of($centros)
      ->addColumn('checkbox', function ($data) {
        $checkbox = '
        <input type="radio" class="with-gap" name="txtentidad_centrofomacion_id"
        onclick="asociarCentroDeFormacionAProyecto(' . $data->id_entidad . ', \'' . $data->codigo_centro . '\', \'' . $data->nombre . '\')" id="radioButton' . $data->id_entidad . '"
        value="' . $data->id_entidad . '"/>
        <label for ="radioButton' . $data->id_entidad . '"></label>
        ';
        return $checkbox;
      })->rawColumns(['checkbox'])->make(true);
    }
  }

  // Datatable para listar los nodos de tecnoparque
  public function datatableNodosTecnoparque()
  {
    if (request()->ajax()) {
      $nodos = Nodo::NodoDeTecnoparque()->get();
      return datatables()->of($nodos)
      ->addColumn('checkbox', function ($data) {
        $checkbox = '
        <input type="radio" class="with-gap" name="txtentidad_nodo_id"
        onclick="asociarNodoAProyecto(' . $data->id_entidad . ', \'' . $data->codigo_centro . '\', \'' . $data->nombre_nodo . '\', \'' . $data->centro . '\')" id="radioButton' . $data->id_entidad . '"
        value="' . $data->id_entidad . '"/>
        <label for ="radioButton' . $data->id_entidad . '"></label>
        ';
        return $checkbox;
      })->rawColumns(['checkbox'])->make(true);
    }
  }

  public function datatableTecnoacademiasTecnoparque()
  {
    if (request()->ajax()) {
      $tecnoacademias = Tecnoacademia::ConsultarTecnoAcademias()->get();
      return datatables()->of($tecnoacademias)
      ->addColumn('checkbox', function ($data) {
        $nombre   = strval($data->nombre);
        $checkbox = '
        <input type="radio" class="with-gap" name="txtentidad_tecnoacademia_id"
        onclick="asociarTecnoacademiaAProyecto(' . $data->id_entidad . ', \'' . $data->codigo_centro . '\', \'' . $nombre . '\', \'' . $data->codigo . '\')" id="radioButton' . $data->id_entidad . '"
        value="' . $data->id_entidad . '"/>
        <label for ="radioButton' . $data->id_entidad . '"></label>
        ';
        return $checkbox;
      })->rawColumns(['checkbox'])->make(true);
    }
  }

  // Consulta los grupos de investigación (se filtra por grupo de investigación)
  public function datatableGruposInvestigacionTecnoparque($tipo)
  {
    if (request()->ajax()) {
      if ($tipo == GrupoInvestigacion::IsInterno()) {
        $grupo = GrupoInvestigacion::ConsultarGruposDeInvestigaciónTecnoparqueSena()->get();
      } else {
        $grupo = GrupoInvestigacion::ConsultarGruposDeInvestigaciónTecnoparqueExterno()->get();
      }
    }
    return datatables()->of($grupo)
    ->addColumn('checkbox', function ($data) {
      $nombre   = strval($data->nombre);
      $checkbox = '
      <input type="radio" class="with-gap" name="txtentidad_grupo_id"
      onclick="asociarGrupoInvestigacionAProyecto(' . $data->id_entidad . ', \'' . $data->codigo_grupo . '\', \'' . $nombre . '\')" id="radioButton' . $data->id_entidad . '"
      value="' . $data->id_entidad . '"/>
      <label for ="radioButton' . $data->id_entidad . '"></label>
      ';
      return $checkbox;
    })->rawColumns(['checkbox'])->make(true);
  }

  // Datatable de las empresas de tecnoparque
  public function datatableEmpresasTecnoparque()
  {
    if (request()->ajax()) {
      $empresas = $this->empresaRepository->consultarEmpresasDeRedTecnoparque();
      return datatables()->of($empresas)
      ->addColumn('checkbox', function ($data) {
        $nombre   = strval($data->nombre_empresa);
        $checkbox = '
        <input type="radio" class="with-gap" name="txtentidad_id"
        onclick="asociarEmpresaAProyecto(' . $data->id_entidad . ', ' . $data->nit . ', \'' . $nombre . '\')" id="radioButton' . $data->id_entidad . '"
        value="' . $data->id_entidad . '"/>
        <label for ="radioButton' . $data->id_entidad . '"></label>
        ';
        return $checkbox;
      })->rawColumns(['checkbox'])->make(true);
    }
  }

  //
  public function datatableEntidadesTecnoparque($id)
  {
    if (request()->ajax()) {
      $nombre    = TipoArticulacionProyecto::where('id', $id)->get()->last();
      $nombre    = $nombre->nombre;
      $entidades = "";
      if ($nombre == 'Grupos y Semilleros del SENA') {
        $entidades = GrupoInvestigacion::ConsultarGruposDeInvestigaciónTecnoparqueSena()->get();
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
    switch (\Session::get('login_role')) {
      case User::IsGestor():
      return view('proyectos.gestor.index');
      break;
      case User::IsDinamizador():
      return view('proyectos.dinamizador.index', [
      'gestores' => Gestor::ConsultarGestoresPorNodo(auth()->user()->dinamizador->nodo_id)->pluck('nombres_gestor', 'id'),
      ]);
      break;

      case User::IsAdministrador():
      return view('proyectos.administrador.index', [
      'nodos' => Nodo::SelectNodo()->get(),
      ]);
      break;

      default:
      // code...
      break;
    }
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    switch (\Session::get('login_role')) {
      case User::IsGestor():
      // dd(AreaConocimiento::ConsultarAreasConocimiento()->pluck('nombre', 'id'));
      // dd();
      return view('proyectos.gestor.create', [
      'tipoarticulacion'  => TipoArticulacionProyecto::all()->pluck('nombre', 'id'),
      'sublineas'         => Sublinea::SubLineasDeUnaLinea(auth()->user()->gestor->lineatecnologica->id)->get()->pluck('nombre', 'id'),
      'sectores'          => Sector::SelectAllSectors()->get()->pluck('nombre', 'id'),
      'areasconocimiento' => AreaConocimiento::ConsultarAreasConocimiento()->pluck('nombre', 'id'),
      'estadosproyecto'   => EstadoProyecto::ConsultarEstadosDeProyectoNoCierre()->pluck('nombre', 'id'),
      ]);
      break;

      default:
      // code...
      break;
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
    $req       = new ProyectoFormRequest;
    $validator = Validator::make($request->all(), $req->rules(), $req->messages());
    if ($validator->fails()) {
      return response()->json([
      'fail'   => true,
      'errors' => $validator->errors(),
      ]);
    }
    $result = $this->proyectoRepository->store($request);
    if ($result == false) {
      return response()->json([
      'fail'         => false,
      'redirect_url' => false,
      ]);
    } else {
      return response()->json([
      'fail'         => false,
      'redirect_url' => url(route('proyecto')),
      ]);
    }
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param int  $id
  * @return \Illuminate\Http\Response
  * @author Victor Manuel Moreno Vega
  */
  public function edit($id)
  {
    $proyecto = $this->proyectoRepository->consultarDetallesDeUnProyectoRepository($id);

    if ($proyecto->nombre_estadoproyecto == 'Cierre PMV' || $proyecto->nombre_estadoproyecto == 'Cierre PF' || $proyecto->nombre_estadoproyecto == 'Suspendido') {
      Alert::error('Error!', 'Este proyecto ya se ha cerrado, no puede realizar esta acción!')->showConfirmButton('Ok', '#3085d6');
      return back();
    } else {
      switch (\Session::get('login_role')) {
        case User::IsGestor():
        $entidad = "";
        $articulacion_repository = "";
        /**
        * Consulta cual es la entidad asociada para consultar su información y mostrarla en la vista
        */
        if ($proyecto->nombre_tipoarticulacion == 'Grupos y Semilleros del SENA' || $proyecto->nombre_tipoarticulacion == 'Grupos y Semilleros Externos') {
          $entidad = $this->entidadRepository->consultarGrupoInvestigacionEntidadRepository($proyecto->entidad_id);
        }

        if ($proyecto->nombre_tipoarticulacion == 'Tecnoacademias') {
          $entidad = $this->entidadRepository->consultarTecnoacademiaEntidadRepository($proyecto->entidad_id);
        }

        if ($proyecto->nombre_tipoarticulacion == 'Empresas') {
          $entidad = $this->entidadRepository->consultarEmpresaEntidadRepository($proyecto->entidad_id);
        }

        if ($proyecto->nombre_tipoarticulacion == 'Tecnoparques') {
          $entidad = $this->entidadRepository->consultarNodoEntidadRepository($proyecto->entidad_id);
        }

        if ($proyecto->nombre_tipoarticulacion == 'Centros de Formación') {
          $entidad = $this->entidadRepository->consultarCentroFormacionEntidadRepository($proyecto->entidad_id);
        }
        return view('proyectos.gestor.edit', [
        'tipoarticulacion'  => TipoArticulacionProyecto::all()->pluck('nombre', 'id'),
        'sublineas' => Sublinea::SubLineasDeUnaLinea(auth()->user()->gestor->lineatecnologica->id)->get()->pluck('nombre', 'id'),
        'sectores' => Sector::SelectAllSectors()->get()->pluck('nombre', 'id'),
        'areasconocimiento' => AreaConocimiento::ConsultarAreasConocimiento()->pluck('nombre', 'id'),
        'estadosproyecto' => EstadoProyecto::ConsultarTodosEstadosDeProyecto()->pluck('nombre', 'id'),
        'proyecto' => $proyecto,
        'pivot' => $this->articulacionProyectoRepository->consultarTalentosDeUnaArticulacionProyectoRepository(Proyecto::find($id)->articulacion_proyecto_id),
        'entidad' => $entidad,
        'estadosprototipos' => EstadoPrototipo::all()->pluck('nombre', 'id'),
        ]);
        break;

        case User::IsDinamizador():
        $gestores = $this->gestorRepository->consultarGestoresPorLineaTecnologicaYNodoRepository($proyecto->lineatecnologica_id, auth()->user()->dinamizador->nodo_id)->pluck('gestor', 'id');
        return view('proyectos.dinamizador.edit', [
        'proyecto' => $proyecto,
        'gestores' => $gestores,
        ]);
        break;

        default:
        // code...
        break;
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
    if (\Session::get('login_role') == User::IsDinamizador()) {
      $messages = [
      'txtgestor_id.required' => 'El Gestor es obligatorio.',
      ];

      $validator = Validator::make($request->all(), [
      'txtgestor_id' => 'required',
      ], $messages);

      if ($validator->fails()) {
        return back()
        ->withErrors($validator)
        ->withInput();
      }

      $update = $this->proyectoRepository->updateProyectoDinamizadorRepository($request, $id);
      if ($update) {
        Alert::success('Se ha cambiado el gestor del proyecto!', 'Modificación Existosa!')->showConfirmButton('Ok', '#3085d6');
        return redirect('proyecto');
      } else {
        Alert::error('No se ha cambiado el gestor del proyecto!', 'Modificación Errónea!')->showConfirmButton('Ok', '#3085d6');
      }
      // return back();
    } else {
      $proyecto = $this->proyectoRepository->consultarDetallesDeUnProyectoRepository($id);
      $req = new ProyectoFormRequest;
      $validator = Validator::make($request->all(), $req->rules(), $req->messages());
      if ($validator->fails()) {
        return response()->json([
        'fail' => true,
        'errors' => $validator->errors(),
        ]);
      }
      /**
      * Para poder cerrar el proyecto se debe haber aprobado/no aprobado por el dinamizado anteriormente
      */
      if ($request->txtestadoproyecto_id == EstadoProyecto::where('nombre', 'Cierre PMV')->first()->id || $request->txtestadoproyecto_id == EstadoProyecto::where('nombre', 'Cierre PF')->first()->id || $request->txtestadoproyecto_id == EstadoProyecto::where('nombre', 'Suspendido')->first()->id) {
        if ($proyecto->revisado_final != 'Aprobado' && $proyecto->revisado_final != 'No Aprobado') {
          return response()->json([
          'revisado_final' => 'Por Evaluar',
          ]);
        }
      }

      $result = $this->proyectoRepository->update($request, $id);
      // dd($result);
      if ($result) {
        return response()->json([
        'result' => true,
        ]);
      } else {
        return response()->json([
        'result' => false,
        ]);
      }

    }
  }

  /*===============================================
  =========================
  =            metodo para consultar los proyectos en ejecucion de un gestor            =
  ========================================================================*/

  public function projectsForGestor($id)
  {

    $projects = $this->proyectoRepository->getProjectsForGestor($id, ['Inicio', 'Planeacion', 'En ejecución']);

      // $projects = $this->proyectoRepository->getProjectsForGestor(
      //       $id,
      //       [
      //           'estadoproyecto'                  => function ($query) {
      //               $query->select('id', 'nombre');
      //           },
      //           'articulacion_proyecto'           => function ($query) {
      //               $query->select('id', 'actividad_id');
      //           },
      //           'articulacion_proyecto.actividad' => function ($query) {
      //               $query->select('id', 'codigo_actividad', 'nombre');
      //           },
      //       ],
      //       [
      //           'Inicio',
      //           'Planeacion',
      //           'En ejecución',
      //       ]
      //   );


      return response()->json([
      'projects' => $projects,
      ]);

  }

  /*=====  End of metodo para consultar los proyectos en ejecucion de un gestor  ======*/

  }
