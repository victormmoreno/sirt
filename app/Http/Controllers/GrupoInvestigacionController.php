<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GrupoInvestigacionFormRequest;
use App\Models\GrupoInvestigacion;
use App\Models\ClasificacionColciencias;
use App\Models\Departamento;
use App\Repositories\Repository\GrupoInvestigacionRepository;

class GrupoInvestigacionController extends Controller
{

  private $grupoInvestigacionRepository;

  public function __construct(GrupoInvestigacionRepository $grupoInvestigacionRepository)
  {
    $this->grupoInvestigacionRepository = $grupoInvestigacionRepository;
    $this->middleware([
        'auth',
    ]);

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
      return view('gruposdeinvestigacion.gestor.index');
      break;
      case 'Dinamizador':
      return view('gruposdeinvestigacion.dinamizador.index');
      break;
      case 'Administrador':
      return view('gruposdeinvestigacion.administrador.index');
      break;
      default:

      break;
    }
  }

  // Ajax que muestra la información de un grupo de investigación
  public function detallesDeUnGrupoInvestigacion($id)
  {
    if (request()->ajax()) {
      $detalles = GrupoInvestigacion::findOrFail($id);
      $detalles->entidad->ciudad->departamento->nombre;
      $detalles->clasificacioncolciencias;
      $detalles->telefono_contacto == null ? $detalles->telefono_contacto = 'No hay información disponible' : $detalles->telefono_contacto;
      $detalles->nombres_contacto == null ? $detalles->nombres_contacto = 'No hay información disponible' : $detalles->nombres_contacto;
      $detalles->correo_contacto == null ? $detalles->correo_contacto = 'No hay información disponible' : $detalles->correo_contacto;
      $detalles->entidad->email_entidad == null ? $detalles->entidad->email_entidad = 'No hay información disponible' : $detalles->entidad->email_entidad;
      return json_encode([
      'detalles' => $detalles,
      ]);
    }
  }

  // Datatable que muestra los grupos de investigación
  public function datatableGruposInvestigacionDeTecnoparque()
  {
    if (request()->ajax()) {
      $gruposInvestigacion = GrupoInvestigacion::ConsultarGruposDeInvestigaciónTecnoparque()->get();
      // dd($gruposInvestigacion);
      if (auth()->user()->rol()->first()->nombre == 'Gestor') {
        return datatables()->of($gruposInvestigacion)
        ->addColumn('details', function ($data) {
          $button = '
          <a class="btn light-blue m-b-xs modal-trigger" onclick="grupoInvestigacionIndex.consultarDetallesDeUnGrupoInvestigacion(' . $data->id . ')" href="#modal1">
            <i class="material-icons">info</i>
          </a>
          ';
          return $button;
        })->addColumn('edit', function ($data) {
          $edit = '<a href="'. route("grupo.edit", $data->id) .'" class="btn m-b-xs"><i class="material-icons">edit</i></a>';
          return $edit;
        })->rawColumns(['details', 'edit'])->make(true);
      } else {
        return datatables()->of($gruposInvestigacion)
        ->addColumn('details', function ($data) {
          $button = '
          <a class="btn light-blue m-b-xs modal-trigger" onclick="grupoInvestigacionIndex.consultarDetallesDeUnGrupoInvestigacion(' . $data->id . ')" href="#modal1">
            <i class="material-icons">info</i>
          </a>
          ';
          return $button;
        })->rawColumns(['details'])->make(true);
      }
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
      return view('gruposdeinvestigacion.gestor.create', [
        'clasificaciones' => ClasificacionColciencias::all(),
        'departamentos' => Departamento::AllDepartamentos()->get(),
      ]);
    }
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(GrupoInvestigacionFormRequest $request)
  {
    $reg = $this->grupoInvestigacionRepository->store($request);
    // dd($reg);
    if ($reg == null) {
      alert()->success('El grupo de investigación ha sido creado satisfactoriamente','Registro Exitoso.')->showConfirmButton('Ok', '#3085d6');
      return redirect()->route('grupo');
    } else {
      alert()->success('El grupo de investigación no se ha creado','Registro Erróneo.')->showConfirmButton('Ok', '#3085d6');
      return back()->withInput();
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
    if (auth()->user()->rol()->first()->nombre == 'Gestor') {
      return view('gruposdeinvestigacion.gestor.edit', [
        'clasificaciones' => ClasificacionColciencias::all(),
        'departamentos' => Departamento::AllDepartamentos()->get(),
        'grupo' => GrupoInvestigacion::findOrFail($id),
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
  public function update(GrupoInvestigacionFormRequest $request, $id)
  {
    // dd($request->input('txtemail_contacto'));
    $grupo = GrupoInvestigacion::findorFail($id);
    $update = $this->grupoInvestigacionRepository->update($request, $grupo);
    alert()->success("La empresa ha sido modificada.",'Modificación Exitosa',"success")->showConfirmButton('Ok', '#3085d6');;
    return redirect()->route('grupo');
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
