<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\{GrupoInvestigacionFormRequest, ContactoEntidadFormRequest};
use App\Models\{GrupoInvestigacion, ClasificacionColciencias, Departamento};
use App\Repositories\Repository\{GrupoInvestigacionRepository, ContactoEntidadRepository};
use App\Helpers\ArrayHelper;
use Illuminate\Support\Facades\Validator;
Use App\User;

class GrupoInvestigacionController extends Controller
{

  private $grupoInvestigacionRepository;
  private $contactoEntidadRepository;

  public function __construct(GrupoInvestigacionRepository $grupoInvestigacionRepository, ContactoEntidadRepository $contactoEntidadRepository)
  {
    $this->grupoInvestigacionRepository = $grupoInvestigacionRepository;
    $this->contactoEntidadRepository = $contactoEntidadRepository;
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



  // Modificar los contactos de un grupo de investigación
  public function updateContactosGrupo(Request $request, $id)
  {
    $req = new ContactoEntidadFormRequest;
    $validator = Validator::make($request->all(), $req->rules(), $req->messages(), $req->attributes());
    if ($validator->fails())
    return response()->json([
      'fail' => true,
      'errors' => $validator->errors(),
      // 'aditional' => $validator->parseData($validator->attributes()),
    ]);
    $result = $this->contactoEntidadRepository->update($request, $id);
    if ($result == false) {
      return response()->json([
          'fail' => false
      ]);
    }
  }

  // Consulta los contactos que tiene un empresa, según el id de la ENTIDAD y el nodo
  public function contactosDelGrupoPorNodo($id)
  {
    if (request()->ajax()) {
      $idnodo_user = "";
      if (\Session::get('login_role') == User::IsGestor()) {
        $idnodo_user = auth()->user()->gestor->nodo_id;
      } else {
        $idnodo_user = auth()->user()->dinamizador->nodo_id;
      }

      $contactos = $this->grupoInvestigacionRepository->consultarContactosPorNodoDeUnGrupo($id, $idnodo_user)->toArray();

      $contactos = ArrayHelper::validarDatoNullDeUnArray($contactos);
      // dd($contactos);
      return response()->json([
        'contactos' => $contactos,
        'route' => url('/grupo/updateContactoDeUnGrupo') . '/' . $id,
      ]);
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
      return view('gruposdeinvestigacion.gestor.index');
      break;
      case User::IsDinamizador():
      return view('gruposdeinvestigacion.dinamizador.index');
      break;
      case User::IsAdministrador():
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
      if (\Session::get('login_role') == User::IsGestor()) {
        return datatables()->of($gruposInvestigacion)
        ->addColumn('details', function ($data) {
          $button = '
          <a class="btn light-blue m-b-xs modal-trigger" onclick="grupoInvestigacionIndex.consultarDetallesDeUnGrupoInvestigacion(' . $data->id . ')" href="#modal1">
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
          // $contact = '
          // <a class="btn orange lighten-3 m-b-xs modal-trigger" href="#modal1" onclick="consultarContactosDeUnaEntidad('. $data->id_entidad .')">
          // <i class="material-icons">local_phone</i>
          // </a>
          // ';
          return $contact;
        })->addColumn('edit', function ($data) {
          $edit = '<a href="'. route("grupo.edit", $data->id) .'" class="btn m-b-xs"><i class="material-icons">edit</i></a>';
          return $edit;
        })->addColumn('add_articulacion', function ($data) {
          $add = '<a onclick="addGrupoArticulacion(' . $data->id . ')" class="btn blue m-b-xs"><i class="material-icons">done</i></a>';
          return $add;
        })->rawColumns(['details', 'edit', 'add_articulacion', 'contacts'])->make(true);
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
    if (\Session::get('login_role') == User::IsGestor()) {
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
    if (\Session::get('login_role') == User::IsGestor()) {
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
