<?php

namespace App\Http\Controllers;

use App\Models\{AreaConocimiento, Centro, Gestor, EstadoProyecto, GrupoInvestigacion, Idea, Nodo, Proyecto, Sublinea, Tecnoacademia, TipoArticulacionProyecto, ArticulacionProyecto};
use App\Repositories\Repository\{EmpresaRepository, EntidadRepository, ProyectoRepository, UserRepository\GestorRepository, ConfiguracionRepository\ServidorVideoRepository};
use Illuminate\Support\{Str, Facades\Session, Facades\Validator};
use App\Http\Requests\ProyectoFaseInicioFormRequest;
use App\Helpers\ArrayHelper;
use Illuminate\Http\Request;
use App\User;
use Alert;

class ProyectoController extends Controller
{

  private $empresaRepository;
  private $proyectoRepository;
  private $gestorRepository;
  private $entidadRepository;
  private $articulacionProyectoRepository;
  private $servidorVideoRepository;

  public function __construct(ServidorVideoRepository $servidorVideoRepository, EmpresaRepository $empresaRepository, ProyectoRepository $proyectoRepository, GestorRepository $gestorRepository, EntidadRepository $entidadRepository)
  {
    $this->setEmpresaRepository($empresaRepository);
    $this->setProyectoRepository($proyectoRepository);
    $this->setGestorRepository($gestorRepository);
    $this->setEntidadRepository($entidadRepository);
    $this->setServidorVideoRepository($servidorVideoRepository);
    $this->middleware(['auth']);
  }

  /**
   * Elimina un proyecto de la base de datos
   * @param int $id Id del proyecto a eliminar
   * @return Response
   * @author dum
   */
  public function eliminarProyecto_Controller($id)
  {

    if (Session::get('login_role') == User::IsDinamizador()) {
      // $this->getProyectoRepository()->eliminarProyecto_Repository($id);
      $delete = $this->getProyectoRepository()->eliminarProyecto_Repository($id);
      return response()->json([
        'retorno' => $delete
      ]);
    } else {
      abort('403');
    }
  }

  /**
   * Vista para la aprobación del proyecto
   *
   * @param int $id Id del proyecto
   * @return Response*
   * @author dum
   */
  public function aprobacion($id)
  {
    // return PdfProyectoController::printAcuerdoConfidencialidadCompromiso();
    $proyecto = Proyecto::find($id);
    $pivot = $this->getProyectoRepository()->pivotAprobaciones($id)->get();
    $aprobado = $this->getProyectoRepository()->pivotAprobacionesUnica($id, auth()->user()->id, Session::get('login_role'));

    if (Session::get('login_role') == User::IsGestor()) {
      return view('proyectos.gestor.aprobacion', [
        'proyecto' => $proyecto,
        'pivot' => $pivot,
        'aprobado' => $aprobado
      ]);
    } else if (Session::get('login_role') == User::IsDinamizador()) {
      return view('proyectos.dinamizador.aprobacion', [
        'proyecto' => $proyecto,
        'pivot' => $pivot,
        'aprobado' => $aprobado
      ]);
    } else {
      return view('proyectos.talento.aprobacion', [
        'proyecto' => $proyecto,
        'pivot' => $pivot,
        'aprobado' => $aprobado
      ]);
    }
  }

  /**
   * Datatable que muestra los proyectos que están pendiente de aprobación de un usuario (dinamizador, talento, gestor)
   *
   * @return Response
   * @author dum
   */
  public function datatableProyectosPendientes()
  {
    $id = "";

    if (Session::get('login_role') == User::IsDinamizador()) {
      $id = auth()->user()->dinamizador->user->id;
    } else if (Session::get('login_role') == User::IsGestor()) {
      $id = auth()->user()->gestor->user->id;
    } else {
      $id = auth()->user()->talento->user->id;
    }

    $proyectos = $this->getProyectoRepository()->proyectosPendientesDeAprobacion_Repository($id);
    return datatables()->of($proyectos)
      ->addColumn('aprobar', function ($data) {
        $aprobar = '
      <a class="btn light-blue m-b-xs" href="' . route('proyecto.aprobacion', $data->id) . '">
        <i class="material-icons">remove_red_eye</i>
      </a>
      ';
        return $aprobar;
      })->rawColumns(['aprobar'])->make(true);
  }

  public function detallesDeLosEntregablesDeUnProyecto($id)
  {
    if (request()->ajax()) {
      $entregables = $this->consultarEntregablesDeUnProyectoController($id)->original['entregables'];
      return response()->json([
        'entregables' => $entregables,
        'proyecto'    => $this->getProyectoRepository()->consultarDetallesDeUnProyectoRepository($id),
      ]);
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
      })->addColumn('download_seguimiento', function ($data) {
        $delete = '<a class="btn green lighten-1 m-b-xs" href=' . route('pdf.proyecto.usos', $data->id) . ' target="_blank"><i class="far fa-file-pdf"></i></a>';
        return $delete;
      })->addColumn('delete', function ($data) {
        $delete = '<a class="btn red lighten-3 m-b-xs" onclick="eliminarProyectoPorId_event(' . $data->id . ', event)"><i class="material-icons">delete_sweep</i></a>';
        return $delete;
      })->addColumn('edit', function ($data) {
        $edit = '<a class="btn m-b-xs" href=' . route('proyecto.inicio', $data->id) . '><i class="material-icons">edit</i></a>';
        return $edit;
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
        if (!empty($request->get('nombre_fase'))) {
          $instance->collection = $instance->collection->filter(function ($row) use ($request) {
            return Str::contains($row['nombre_fase'], $request->get('nombre_fase')) ? true : false;
          });
        }
        if (!empty($request->get('gestor'))) {
          $instance->collection = $instance->collection->filter(function ($row) use ($request) {
            return Str::contains($row['gestor'], $request->get('gestor')) ? true : false;
          });
        }
        if (!empty($request->get('search'))) {
          $instance->collection = $instance->collection->filter(function ($row) use ($request) {
            if (Str::contains(Str::lower($row['codigo_proyecto']), Str::lower($request->get('search')))) {
              return true;
            } else if (Str::contains(Str::lower($row['nombre']), Str::lower($request->get('search')))) {
              return true;
            } else if (Str::contains(Str::lower($row['nombre_fase']), Str::lower($request->get('search')))) {
              return true;
            } else if (Str::contains(Str::lower($row['gestor']), Str::lower($request->get('search')))) {
              return true;
            }
            return false;
          });
        }
      })->rawColumns(['details', 'edit', 'talentos', 'delete', 'download_seguimiento'])->make(true);
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
      if (Session::get('login_role') == User::IsDinamizador()) {
        $id = auth()->user()->dinamizador->nodo_id;
      } else {
        $id = $idnodo;
      }
      $proyectos = $this->getProyectoRepository()->ConsultarProyectosPorNodoYPorAnho($id, $anho);
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
    $proyecto = ArrayHelper::validarDatoNullDeUnArray($this->getProyectoRepository()->consultarDetallesDeUnProyectoRepository($id)->toArray());
    if (request()->ajax()) {
      return response()->json([
        'proyecto' => $proyecto,
      ]);
    } else {
      return $proyecto;
    }
  }

  /**
   * modifica los entregables de un proyecto
   *
   * @param Request $request
   * @param int $id Id del proyecto
   * @return Response
   * @author Victor Manuel Moreno Vega
   */
  public function updateEntregables(Request $request, $id)
  {
    if (Session::get('login_role') == User::IsGestor()) {
      $validator = Validator::make($request->all(), [
        'txturl_videotutorial' => ['url', 'max:1000', 'nullable'],
      ], [
        'txturl_videotutorial.url' => 'El formato de la Url del Video no es válido.',
        'txturl_videotutorial.max' => 'La Url del Video debe ser máximo de 1000 carácteres.',
      ]);
      if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
      }

      $update = $this->getProyectoRepository()->updateEntregablesProyectoRepository($request, $id);
      if ($update) {
        Alert::success('Modificación Exitosa!', 'Los entregables del proyecto se han modificado!')->showConfirmButton('Ok', '#3085d6');
        return redirect('proyecto');
      } else {
        Alert::error('Modificación Errónea!', 'Los entregables del proyecto no se han modificado!')->showConfirmButton('Ok', '#3085d6');
        return back();
      }
    } else {
      $proyecto = $this->getProyectoRepository()->consultarDetallesDeUnProyectoRepository($id);
      if ($proyecto->nombre_estadoproyecto != 'En ejecución' && $request->txtrevisado_final != ArticulacionProyecto::IsPorEvaluar()) {
        Alert::html('Advertencia!', 'Para realizar esta acción, el estado del proyecto debe ser "<b>En ejecución</b>"', 'warning')->showConfirmButton('Ok', '#3085d6');
        return back();
      } else {
        $update = $this->getProyectoRepository()->updateRevisadoFinalProyectoRepository($request, $id);
        if ($update) {
          Alert::success('Modificación Exitosa!', 'El revisado final del proyecto se ha modificado!')->showConfirmButton('Ok', '#3085d6');
          return redirect('proyecto');
        } else {
          Alert::error('Modificación Errónea!', 'El revisado final del proyecto no se modificado!')->showConfirmButton('Ok', '#3085d6');
          return back();
        }
      }
    }
  }

  /**
   * Vista para el formulario de los entregables de un proyecto
   *
   * @param int $id Id del proyecto
   * @return Response
   * @author dum
   */
  public function entregables_inicio($id)
  {
    $proyecto = Proyecto::find($id);
    if (Session::get('login_role') == User::IsGestor()) {
      return view('proyectos.gestor.entregables_inicio', [
        'proyecto' => $proyecto
      ]);
    } else if (Session::get('login_role') == User::IsDinamizador()) {
      return view('proyectos.dinamizador.entregables', [
        'proyecto' => $proyecto
      ]);
    } else {
      return view('proyectos.administrador.entregables', [
        'proyecto' => $proyecto
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
      if (Session::get('login_role') == User::IsGestor()) {
        $idgestor = auth()->user()->gestor->id;
      }
      // dd('z wardo');
      $proyectos = $this->getProyectoRepository()->ConsultarProyectosPorGestorYPorAnho($idgestor, $anho);
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
      $empresas = $this->getEmpresaRepository()->consultarEmpresasDeRedTecnoparque();
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
    // dd();
    switch (Session::get('login_role')) {
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

      case User::IsTalento():
        return view('proyectos.talento.index');
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

    if (Session::get('login_role') == User::IsGestor()) {
      return view('proyectos.gestor.create', [
        'sublineas' => Sublinea::SubLineasDeUnaLinea(auth()->user()->gestor->lineatecnologica->id)->get()->pluck('nombre', 'id'),
        'areasconocimiento' => AreaConocimiento::ConsultarAreasConocimiento()->pluck('nombre', 'id'),
      ]);
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
    // dd($request);
    // return response()->json(['fail' => true]);
    $req       = new ProyectoFaseInicioFormRequest;
    $validator = Validator::make($request->all(), $req->rules(), $req->messages());
    if ($validator->fails()) {
      return response()->json([
        'state'   => 'error_form',
        'errors' => $validator->errors(),
      ]);
    } else {
      $result = $this->getProyectoRepository()->store($request);
      if ($result) {
        return response()->json(['state' => 'registro']);
      } else {
        return response()->json(['state' => 'no_registro']);
      }
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
    $proyecto = Proyecto::find($id);

    switch (Session::get('login_role')) {
      case User::IsGestor():
        return view('proyectos.gestor.fase_inicio', [
          'sublineas' => Sublinea::SubLineasDeUnaLinea(auth()->user()->gestor->lineatecnologica->id)->get()->pluck('nombre', 'id'),
          'areasconocimiento' => AreaConocimiento::ConsultarAreasConocimiento()->pluck('nombre', 'id'),
          'proyecto' => $proyecto
        ]);
        break;

      case User::IsDinamizador():
        $gestores = $this->getGestorRepository()->consultarGestoresPorLineaTecnologicaYNodoRepository($proyecto->lineatecnologica_id, auth()->user()->dinamizador->nodo_id)->pluck('gestor', 'id');
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

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    if (Session::get('login_role') == User::IsDinamizador()) {
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

      $update = $this->getProyectoRepository()->updateProyectoDinamizadorRepository($request, $id);
      if ($update) {
        Alert::success('Se ha cambiado el gestor del proyecto!', 'Modificación Exitosa!')->showConfirmButton('Ok', '#3085d6');
        return redirect('proyecto');
      } else {
        Alert::error('No se ha cambiado el gestor del proyecto!', 'Modificación Errónea!')->showConfirmButton('Ok', '#3085d6');
        return back();
      }
    } else {
      $proyecto = $this->getProyectoRepository()->consultarDetallesDeUnProyectoRepository($id);
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

      $result = $this->getProyectoRepository()->update($request, $id);
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

    $projects = $this->getProyectoRepository()->getProjectsForGestor($id, ['Inicio', 'Planeacion', 'En ejecución']);


    return response()->json([
      'projects' => $projects,
    ]);
  }

  /*=====  End of metodo para consultar los proyectos en ejecucion de un gestor  ======*/

  /**
   * Asigna un valor a $proyectoRepository
   * @param object $proyectoRepository
   * @return void type
   * @author dum
   */
  private function setProyectoRepository($proyectoRepository)
  {
    $this->proyectoRepository = $proyectoRepository;
  }

  /**
   * Retorna el valor de $proyectoRepository
   * @return object
   * @author dum
   */
  private function getProyectoRepository()
  {
    return $this->proyectoRepository;
  }

  /**
   * Asgina un valor a $empresaRepository
   * @param object $empresaRepository
   * @return void
   * @author dum
   */
  private function setEmpresaRepository($empresaRepository)
  {
    $this->empresaRepository = $empresaRepository;
  }

  /**
   * Retorna el valor de $empresaRepository
   * @return object
   * @author dum
   */
  private function getEmpresaRepository()
  {
    return $this->empresaRepository;
  }

  /**
   * Asigna un valor a $gestorRepository
   * @param object $gestorRepository
   * @return void
   * @author dum
   */
  private function setGestorRepository($gestorRepository)
  {
    $this->gestorRepository = $gestorRepository;
  }

  /**
   * Retorna el valor de $gestorRepository
   * @return object
   * @author dum
   */
  private function getGestorRepository()
  {
    return $this->gestorRepository;
  }

  /**
   * Asigna un valor a $entidadRepository
   * @param object $entidadRepository
   * @return void
   * @author dum
   */
  private function setEntidadRepository($entidadRepository)
  {
    $this->entidadRepository = $entidadRepository;
  }

  /**
   * Retorna el valor de $entidadRepository
   * @return object
   * @author dum
   */
  private function getEntidadRepository()
  {
    return $this->entidadRepository;
  }

  /**
   * Asigna un valor a $servidorVideoRepository
   * @param object $servidorVideoRepository
   * @return void
   * @author dum
   */
  private function setServidorVideoRepository($servidorVideoRepository)
  {
    $this->servidorVideoRepository = $servidorVideoRepository;
  }

  /**
   * Retorna el valor de $servidorVideoRepository
   * @return object
   * @author dum
   */
  private function getServidorVideoRepository()
  {
    return $this->servidorVideoRepository;
  }
}
