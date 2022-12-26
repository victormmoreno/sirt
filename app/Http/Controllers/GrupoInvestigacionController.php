<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\{GrupoInvestigacionFormRequest};
use App\Models\{GrupoInvestigacion, ClasificacionColciencias, Departamento};
use App\Repositories\Repository\{GrupoInvestigacionRepository};
Use App\User;

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


  /*===================================================================================
  =            metodo Api para consultar todos los grupos de investigacion            =
  ===================================================================================*/

  public function getAllGruposInvestigacionForCiudad($ciudad)
  {
      return response()->json([
      'gruposInvestigaciones' => $this->grupoInvestigacionRepository->getAllGruposInvestigacionesForCiudad($ciudad),
      ]);
  }

  /*=====  End of metodo Api para consultar todos los grupos de investigacion  ======*/

  /*====================================================================================================
  =            metodo Api para mostrar los grupos de investigacion por ciudad en datatables            =
  ====================================================================================================*/

  public function getDataTablesForGrupoCiudad($ciudad)
  {
    if (request()->ajax()) {
        return datatables()->of($this->grupoInvestigacionRepository->getAllGruposInvestigacionDatatables($ciudad))
                      ->addColumn('details', function ($data) {
                              $input = '
                                    <input class="with-gap" id="grupoInvestigacion'.$data->id.'" name="grupoInvestigacion" type="radio" value="'.$data->nombre.'" onchange="grupoInvestigacion.getCheckoxSeletedDatatables(this)"/>
                                  <label for="grupoInvestigacion'.$data->id.'"></label>
                              ';
                              return $input;
                      })->rawColumns(['details'])
        ->make(true);
    }
  }

  /*=====  End of metodo Api para mostrar los grupos de investigacion por ciudad en datatables  ======*/

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    if (!request()->user()->can('index', GrupoInvestigacion::class)) {
      alert('No autorizado', 'No puedes ver la información de los grupos de investigación', 'error')->showConfirmButton('Ok', '#3085d6');
      return back();
    }
    return view('gruposdeinvestigacion.index');
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
      return datatables()->of($gruposInvestigacion)
      ->addColumn('details', function ($data) {
        $button = '
        <a class="btn bg-info m-b-xs modal-trigger" onclick="grupoInvestigacionIndex.consultarDetallesDeUnGrupoInvestigacion(' . $data->id . ')" href="#modal1">
          <i class="material-icons">info</i>
        </a>
        ';
        return $button;
      })->addColumn('contacts', function ($data) {
        $contact = '
        <a class="btn orange lighten-3 m-b-xs modal-trigger" id="#contactosDeUnaEntidad_modal" onclick="consultarContactosDeUnaEntidad('.$data->id_entidad.');">
        <i class="material-icons">local_phone</i>
        </a>
        ';
        return $contact;
      })->addColumn('edit', function ($data) {
        $edit = '<a href="'. route("grupo.edit", $data->id) .'" class="btn bg-warning m-b-xs"><i class="material-icons">edit</i></a>';
        return $edit;
      })->addColumn('add_articulacion', function ($data) {
        $add = '<a onclick="addGrupoArticulacion(' . $data->id . ')" class="btn bg-secondary m-b-xs"><i class="material-icons">done</i></a>';
        return $add;
      })->addColumn('add_propietario', function ($data) {
        $add_propietario = '<a onclick="addGrupoPropietario(' . $data->id . ')" class="btn bg-secondary m-b-xs"><i class="material-icons">done</i></a>';
        return $add_propietario;
      })->rawColumns(['details', 'edit', 'add_articulacion', 'contacts', 'add_propietario'])->make(true);
    }
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view('gruposdeinvestigacion.create', [
      'clasificaciones' => ClasificacionColciencias::all(),
      'departamentos' => Departamento::AllDepartamentos()->get(),
    ]);
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

    if ($reg == null) {
      alert()->success('El grupo de investigación ha sido creado satisfactoriamente','Registro Exitoso.')->showConfirmButton('Ok', '#3085d6');
      return redirect()->route('grupo');
    } else {
      alert()->success('El grupo de investigación no se ha creado','Registro Erróneo.')->showConfirmButton('Ok', '#3085d6');
      return back()->withInput();
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
    return view('gruposdeinvestigacion.edit', [
      'clasificaciones' => ClasificacionColciencias::all(),
      'departamentos' => Departamento::AllDepartamentos()->get(),
      'grupo' => GrupoInvestigacion::findOrFail($id),
    ]);
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
    alert()->success("El grupo de investigación ha sido modificada.",'Modificación Exitosa',"success")->showConfirmButton('Ok', '#3085d6');;
    return redirect()->route('grupo');
  }

}
