<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Proyecto, TipoArticulacionProyecto, Sublinea, Sector, AreaConocimiento, EstadoProyecto, GrupoInvestigacion, Tecnoacademia, Nodo, Centro, Idea, Entidad};
use App\Repositories\Repository\{EmpresaRepository, ProyectoRepository};
use App\Http\Requests\ProyectoFormRequest;
use Illuminate\Support\Facades\Validator;
use Alert;
use App\Helpers\ArrayHelper;
Use App\User;

class ProyectoController extends Controller
{
  public $empresaRepository;
  public $proyectoRepository;

  public function __construct(EmpresaRepository $empresaRepository, ProyectoRepository $proyectoRepository)
  {
    $this->empresaRepository = $empresaRepository;
    $this->proyectoRepository = $proyectoRepository;
    $this->middleware([
      'auth',
    ]);
  }

  public function consultarDetallesDeUnProyecto($id)
  {
    if (request()->ajax()) {
      $proyecto = ArrayHelper::validarDatoNullDeUnArray($this->proyectoRepository->consultarDetallesDeUnProyectoRepository($id)->toArray());
      // $proyecto = ArrayHelper::validarDatoNullDeUnArray($proyecto);
      return response()->json([
        'proyecto' => $proyecto,
      ]);
    }
  }

  // Consulta los talentos que hay en un proyecto
  public function consultarTalentosDeUnProyecto($id)
  {
    if (request()->ajax()) {
      $talentos = $this->proyectoRepository->consultarTalentosDeUnProyectoRepository($id);
      if (count($talentos) == 0) {
        $proyecto = "";
      } else {
        $proyecto = $talentos[0]->codigo_proyecto;
      }

      return response()->json([
        'talentos' => $talentos,
        'proyecto' => $proyecto
      ]);
    }
  }

  // Vista de la vista de los entregables de un proyecto
  public function entregables($id)
  {
    // code...
  }

  // Consulta los proyectos de un gestor por año (De la fecha de cierre)
  public function datatableProyectosDelGestorPorAnho($idgestor, $anho)
  {
    if (request()->ajax()) {
      $idgestor = "";
      if (\Session::get('login_role') == User::IsGestor()) {
        $idgestor = auth()->user()->gestor->id;
      }
      $proyectos = $this->proyectoRepository->ConsultarProyectosPorGestorYPorAnho($idgestor, $anho);
      return datatables()->of($proyectos)
      ->addColumn('details', function ($data) {
        $details = '
        <a class="btn light-blue m-b-xs" onclick="detallesDeUnProyecto(' . $data->id . ')">
        <i class="material-icons">info</i>
        </a>
        ';
        return $details;
      })->addColumn('edit', function ($data) {
        $edit = '<a class="btn m-b-xs" href='.route('proyecto.edit', $data->id).'><i class="material-icons">edit</i></a>';
        return $edit;
      })->addColumn('entregables', function ($data) {
        $entregables = '
        <a class="btn blue-grey m-b-xs" href='. route('proyecto.entregables', $data->id) .'>
        <i class="material-icons">library_books</i>
        </a>
        ';
        return $entregables;
      })->addColumn('talentos', function ($data) {
        $talentos = '
        <a class="btn cyan m-b-xs" onclick="verTalentosDeUnProyecto(' . $data->id . ')">
        <i class="material-icons">assignment_ind</i>
        </a>
        ';
        return $talentos;
      })->rawColumns(['details', 'edit', 'entregables', 'talentos'])->make(true);
    }
  }

  // Datatable para listar las ideas de proyectos con emprendedores (que aprobaron el CSIBT)
  public function datatableIdeasConEmprendedores()
  {
    if (request()->ajax()) {
      $ideas = Idea::ConsultarIdeasAprobadasEnComite(auth()->user()->gestor->nodo_id )->get();
      // dd($ideas);
      return datatables()->of($ideas)
      ->addColumn('checkbox', function ($data) {
        $checkbox = '
        <a class="btn blue" onclick="asociarIdeaDeProyectoAProyecto('.$data->consecutivo.', \''.$data->nombre_proyecto.'\')">
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
      $ideas = Idea::ConsultarIdeasConEmpresasGrupos( auth()->user()->gestor->nodo_id )->get();
      // dd($ideas);
      return datatables()->of($ideas)
      ->addColumn('checkbox', function ($data) {
        $checkbox = '
        <a class="btn blue" onclick="asociarIdeaDeProyectoAProyecto('.$data->consecutivo.', \''.$data->nombre_proyecto.'\')">
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
        onclick="asociarCentroDeFormacionAProyecto('.$data->id_entidad.', \''.$data->codigo_centro.'\', \''.$data->nombre.'\')" id="radioButton'.$data->id_entidad.'"
        value="'.$data->id_entidad.'"/>
        <label for ="radioButton'.$data->id_entidad.'"></label>
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
        onclick="asociarNodoAProyecto('.$data->id_entidad.', \''.$data->codigo_centro.'\', \''.$data->nombre_nodo.'\', \''.$data->centro.'\')" id="radioButton'.$data->id_entidad.'"
        value="'.$data->id_entidad.'"/>
        <label for ="radioButton'.$data->id_entidad.'"></label>
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
        $nombre = strval($data->nombre);
        $checkbox = '
        <input type="radio" class="with-gap" name="txtentidad_tecnoacademia_id"
        onclick="asociarTecnoacademiaAProyecto('.$data->id_entidad.', \''.$data->codigo_centro.'\', \''.$nombre.'\', \''.$data->codigo.'\')" id="radioButton'.$data->id_entidad.'"
        value="'.$data->id_entidad.'"/>
        <label for ="radioButton'.$data->id_entidad.'"></label>
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
      $nombre = strval($data->nombre);
      $checkbox = '
      <input type="radio" class="with-gap" name="txtentidad_grupo_id"
      onclick="asociarGrupoInvestigacionAProyecto('.$data->id_entidad.', \''.$data->codigo_grupo.'\', \''.$nombre.'\')" id="radioButton'.$data->id_entidad.'"
      value="'.$data->id_entidad.'"/>
      <label for ="radioButton'.$data->id_entidad.'"></label>
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
        $nombre = strval($data->nombre_empresa);
        $checkbox = '
        <input type="radio" class="with-gap" name="txtentidad_id"
        onclick="asociarEmpresaAProyecto('.$data->id_entidad.', '.$data->nit.', \''.$nombre.'\')" id="radioButton'.$data->id_entidad.'"
        value="'.$data->id_entidad.'"/>
        <label for ="radioButton'.$data->id_entidad.'"></label>
        ';
        return $checkbox;
      })->rawColumns(['checkbox'])->make(true);
    }
  }

  //
  public function datatableEntidadesTecnoparque($id)
  {
    if (request()->ajax()) {
      $nombre = TipoArticulacionProyecto::where('id', $id)->get()->last();
      $nombre = $nombre->nombre;
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
        'tipoarticulacion' => TipoArticulacionProyecto::all()->pluck('nombre', 'id'),
        'sublineas' => Sublinea::SubLineasDeUnaLinea( auth()->user()->gestor->lineatecnologica->id )->get()->pluck('nombre', 'id'),
        'sectores' => Sector::SelectAllSectors()->get()->pluck('nombre', 'id'),
        'areasconocimiento' => AreaConocimiento::ConsultarAreasConocimiento()->pluck('nombre', 'id'),
        'estadosproyecto' => EstadoProyecto::ConsultarEstadosDeProyectoNoCierre()->pluck('nombre', 'id'),
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
    $req = new ProyectoFormRequest;
    $validator = Validator::make($request->all(), $req->rules(), $req->messages());
    if ($validator->fails()) {
      return response()->json([
        'fail' => true,
        'errors' => $validator->errors(),
      ]);
    }
    $result = $this->proyectoRepository->store($request);
    if ($result == false) {
      return response()->json([
          'fail' => false,
          'redirect_url' => false
      ]);
    } else {
      return response()->json([
          'fail' => false,
          'redirect_url' => url(route('proyecto'))
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
    switch (\Session::get('login_role')) {
      case User::IsGestor():
      // dd($this->proyectoRepository->consultarDetallesDeUnProyectoRepository($id)->sublinea_id);
        return view('proyectos.gestor.edit', [
          'tipoarticulacion' => TipoArticulacionProyecto::all()->pluck('nombre', 'id'),
          'sublineas' => Sublinea::SubLineasDeUnaLinea( auth()->user()->gestor->lineatecnologica->id )->get()->pluck('nombre', 'id'),
          'sectores' => Sector::SelectAllSectors()->get()->pluck('nombre', 'id'),
          'areasconocimiento' => AreaConocimiento::ConsultarAreasConocimiento()->pluck('nombre', 'id'),
          'estadosproyecto' => EstadoProyecto::ConsultarEstadosDeProyectoNoCierre()->pluck('nombre', 'id'),
          'proyecto' => $this->proyectoRepository->consultarDetallesDeUnProyectoRepository($id),
          'pivot' => $this->proyectoRepository->consultarTalentosDeUnProyectoRepository($id),
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
