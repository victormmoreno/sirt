<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Proyecto, TipoArticulacionProyecto, Sublinea, Sector, AreaConocimiento, EstadoProyecto, GrupoInvestigacion};
use App\Repositories\Repository\{EmpresaRepository};

class ProyectoController extends Controller
{
  public $empresaRepository;

  public function __construct(EmpresaRepository $empresaRepository)
  {
    $this->empresaRepository = $empresaRepository;
    $this->middleware([
      'auth',
    ]);
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
      <input type="radio" class="with-gap" name="txtentidad_grupo_id" onclick="asociarGrupoInvestigacionAProyecto('.$data->id_entidad.', \''.$data->codigo_grupo.'\', \''.$nombre.'\')" id="radioButton'.$data->id_entidad.'"
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
        <input type="radio" class="with-gap" name="txtentidad_id" onclick="asociarEmpresaAProyecto('.$data->id_entidad.', '.$data->nit.', \''.$nombre.'\')" id="radioButton'.$data->id_entidad.'"
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
    switch (auth()->user()->rol()->first()->nombre) {
      case 'Gestor':
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
    switch (auth()->user()->rol()->first()->nombre) {
      case 'Gestor':
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
