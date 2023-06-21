<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\{ComiteAgendamientoFormRequest, ComiteRealizarFormRequest, ComiteAsignarFormRequest};
use App\Repositories\Repository\{ComiteRepository};
use App\Models\{Nodo, Idea, Comite, EstadoIdea, Gestor};
use Illuminate\Support\Facades\{Session, Validator};
Use App\User;

class ComiteController extends Controller
{

  private $comiteRepository;
  private $gestorRepository;

  public function __construct(ComiteRepository $comiteRepository)
  {
    $this->setComiteRepository($comiteRepository);
    $this->middleware('auth');
  }

  /**
   * Muestra el detalle de un comité
   * @param int $id Id del comité
   * @return Response
   * @author dum
   */
  public function detalle(int $id)
  {
    $comite = Comite::findOrFail($id);
    if(!request()->user()->can('show', $comite)) {
      alert('No autorizado', 'No tienes permisos para ver la información de este comité', 'error')->showConfirmButton('Ok', '#3085d6');
      return back();
    }
    return view('comite.detalle', ['comite' => $comite]);
  }

  /**
   * Formulario para asignar las ideas de proyecto a los gestores del nodo
   * @param int $id Id del comité
   */
  public function asignar(int $id)
  {
    $comite = Comite::findOrFail($id);
    if (!request()->user()->can('asignar_ideas', $comite)) {
      alert()->warning('Error!','No tienes permisos para para asignar las ideas de este comité a los expertos.')->showConfirmButton('Ok', '#3085d6');
      return back(); 
    }
    $gestores = User::ConsultarFuncionarios($comite->ideas->first()->nodo_id, User::IsExperto())->get();
    return view('comite.asignar_ideas', [
      'comite' => $comite,
      'gestores' => $gestores
    ]);
  }

  /**
   * Formulario para calificar un comité desde el rol de infocenter.
   * @param int $id Id del comité
   * @return Response
   * @author dum
   */
  public function realizar(int $id)
  {
    $comite = Comite::findOrFail($id);
    if (!request()->user()->can('calificar', $comite)) {
      alert()->warning('Error!','No tienes permisos para calificar este comité.')->showConfirmButton('Ok', '#3085d6');
      return back(); 
    }
    $estados = EstadoIdea::whereIn('nombre', [EstadoIdea::IsReprogramado(), EstadoIdea::IsAdmitido(), EstadoIdea::IsRechazadoComite()])->get();
    return view('comite.realizar_comite', [
      'comite' => $comite,
      'estados' => $estados
    ]);
  }

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    return view('comite.index', ['nodos' => Nodo::SelectNodo()->get()]);
  }

  // Datatable para mostrar los archivos de un comité (Infocenter)
  public function datatableArchivosDeUnComite($id)
  {
    if (request()->ajax()) {
      $archivosComite = $this->getComiteRepository()->consultarRutasArchivosDeUnComite( $id );
      return datatables()->of($archivosComite)
      ->addColumn('download', function ($data) {
        $download = '
        <a target="_blank" href="' . route('csibt.files.download', $data->id) . '" class="btn blue darken-4 m-b-xs">
        <i class="material-icons">file_download</i>
        </a>
        ';
        return $download;
      })->addColumn('delete', function ($data) {
        $delete = '<form method="POST" action="' . route('csibt.files.destroy', $data) . '">
        ' . method_field('DELETE') . '' .  csrf_field() . '
        <button class="btn red darken-4 m-b-xs">
        <i class="material-icons">delete_forever</i>
        </button>
        </form>';
        return $delete;
      })->addColumn('file', function ($data) {
        $file = '
        <i class="material-icons">insert_drive_file</i> ' . basename( url($data->ruta) ) . '
        ';
        return $file;
      })->rawColumns(['download', 'delete', 'file'])->make(true);
    }
  }

  public function datatableCsibtPorNodo($id)
  {
    if (request()->ajax()) {
      return datatables()->of($this->getComiteRepository()->consultarComitesPorNodo($id))
      ->addColumn('details', function ($data) {
        $details = '<a class="btn m-b-xs" href="' . route('csibt.detalle', $data->id) . '"><i class="material-icons">search</i></a>';
        return $details;
      })->rawColumns(['details'])->make(true);
    }
  }

  // Método para modificar las evidencias de un comité
  public function updateEvidencias(Request $request, $id)
  {
    if (!request()->user()->can('cargar_evidencias', Comite::find($id))) {
      alert('No autorizado', 'No tienes permisos para cargar información de este comité', 'error')->showConfirmButton('Ok', '#3085d6');
      return back();
    }
    !isset($request['ev_acta']) ? $request['ev_acta'] = 0 : $request['ev_acta'] = 1;
    !isset($request['ev_formato']) ? $request['ev_formato'] = 0 : $request['ev_formato'] = 1;
    !isset($request['ev_listado']) ? $request['ev_listado'] = 0 : $request['ev_listado'] = 1;
    !isset($request['ev_otros']) ? $request['ev_otros'] = 0 : $request['ev_otros'] = 1;
    $evidenciasComite = $this->getComiteRepository()->updateEvidenciasComite($request, $id);
    alert()->success('Modificación Exitosa!','Las evidencias del CSIBT se han modificado con éxito.')->showConfirmButton('Ok', '#3085d6');
    return redirect()->route('csibt.detalle', ['id' => $id]);
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    if (!request()->user()->can('create', Comite::class)) {
      alert('No autorizado', 'No tienes permisos para registrar un comité', 'error')->showConfirmButton('Ok', '#3085d6');
      return back();
    }
    $ideas = Idea::ConsultarIdeasConvocadasAComite( request()->user()->getNodoUser() )->get();
    $gestores = User::ConsultarFuncionarios(request()->user()->getNodoUser(), User::IsExperto())->get();
    return view('comite.create', [
      'ideas' => $ideas,
      'gestores' => $gestores
    ]);
  }

  /**
   * Formulario para cambiar el gestor de una idea de proyecto que fue aprobada en el comité
   * 
   * @param Idea $idea
   * @param Comite $comite
   * @return Response
   */
  public function cambiar_idea_gestor(Idea $idea, Comite $comite)
  {
    if (!request()->user()->can('cambiar_asignacion', [$idea, $comite])) {
      alert('No autorizado', 'No tienes permisos para cambiar al asignación de experto de esta idea', 'error')->showConfirmButton('Ok', '#3085d6');
      return back();
    }
    $gestores = User::ConsultarFuncionarios($comite->ideas()->first()->nodo_id, User::IsExperto())->get();
    return view('comite.update_gestor', [
    'idea' => $idea,
    'comite' => $comite,
    'gestores' => $gestores]);
  }

  /**
   * Cambiar el gestor de una idea de proyecto
   *
   * @param Request $request
   * @param Idea $idea Idea
   * @param Comite $comite Comité
   * @return Response
   * @author dum
   **/
  public function updateGestor(Request $request, Idea $idea, Comite $comite = null)
  {
    $messages = [
      'txtgestor_id.required' => 'El experto es obligatorio.',
    ];

    $validator = Validator::make($request->all(), [
        'txtgestor_id' => 'required',
    ], $messages);

    if ($validator->fails()) {
        return back()
            ->withErrors($validator)
            ->withInput();
    }
    $update = $this->getComiteRepository()->updateGestorIdea($request, $idea);
    if ($update) {
      alert()->success('Se ha cambiado el experto de la idea de proyecto!', 'Modificación Exitosa!')->showConfirmButton('Ok', '#3085d6');
      return redirect(route('idea.detalle', $idea->id));
    } else {
      alert()->error('No se ha cambiado el experto de la idea de proyecto!', 'Modificación Errónea!')->showConfirmButton('Ok', '#3085d6');
      return back();
    }
  }

  /**
   * Registra el agenadamiento de un comité
   * 
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $req = new ComiteAgendamientoFormRequest;
    $validator = Validator::make($request->all(), $req->rules(), $req->messages());
    if ($validator->fails()) {
      return response()->json([
        'state'   => 'error_form',
        'errors' => $validator->errors(),
      ]);
    } else {
      $result = $this->getComiteRepository()->store($request);
      if ($result) {
        return response()->json(['state' => 'registro']);
      } else {
        return response()->json(['state' => 'no_registro']);
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
  public function updateAgendamiento(Request $request, $id)
  {
    $req = new ComiteAgendamientoFormRequest;
    $validator = Validator::make($request->all(), $req->rules(), $req->messages());
    if ($validator->fails()) {
      return response()->json([
        'state'   => 'error_form',
        'errors' => $validator->errors(),
      ]);
    } else {
      $result = $this->getComiteRepository()->updateAgendamiento($request, $id);
      if ($result) {
        return response()->json(['state' => 'update']);
      } else {
        return response()->json(['state' => 'no_update']);
      }
    }
  }

  /**
   * Guarda los datos de un comité
   * @param Request $request
   * @param int $id Id del comité
   * @author dum
   */
  public function updateRealizado(Request $request, int $id)
  {
    $req = new ComiteRealizarFormRequest;
    // dd($request->get('txtestadoidea'));
    // exit();
    $validator = Validator::make($request->all(), $req->rules(), $req->messages());
    if ($validator->fails()) {
      return response()->json([
        'state' => 'error_form',
        'errors' => $validator->errors()
      ]);
    } else {
      $result = $this->getComiteRepository()->updateRealizado($request, $id);
      if ($result) {
        return response()->json(['state' => 'registro']);
      } else {
        return response()->json(['state' => 'no_registro']);
      }
    }
  }
  /**
   * Asigna un gestor encargado a una idea de proyecto
   * @param Request $request
   * @param int $id Id del comité
   * @author dum
   */
  public function updateAsignarGestor(Request $request, int $id)
  {
    $req = new ComiteAsignarFormRequest;
    $validator = Validator::make($request->all(), $req->rules(), $req->messages());
    if ($validator->fails()) {
      return response()->json([
        'state' => 'error_form',
        'errors' => $validator->errors()
      ]);
    } else {
      $result = $this->getComiteRepository()->updateAsignar($request, $id);
      if ($result) {
        return response()->json(['state' => 'registro']);
      } else {
        return response()->json(['state' => 'no_registro']);
      }
    }
  }

  /**
   * Envia un correo con la citación del comité a las personas que registraron las ideas de proyecto
   * @param int $id Id del comité
   * @param int $id Idea de la idea
   * @param string $rol Indica a que tipo de usuario se les va a enviar la notificación
   * @return Response
   * @author dum
   */
  public function notificar_agendamientoController(int $id = null, int $idea = null, string $rol = null)
  {
    $result = $this->getComiteRepository()->notificar_agendamiento($id, $idea, $rol);
    if ($result) {
      alert()->success('Notificación Exitosa!','La citación para el comité se ha enviado con éxito.')->showConfirmButton('Ok', '#3085d6');
    } else {
      alert()->error('Modificación Errónea!','La citación para el comité no se ha enviado.')->showConfirmButton('Ok', '#3085d6');
    }
    return back();
  }

  /**
   * Notifica al dinamizador de que el comité se ha calificado
   * @param int $id Id del comité
   * @return Response
   * @author dum
   */
  public function notificar_realizadoController(int $id)
  {
    $result = $this->getComiteRepository()->notificar_realizado($id);
    if ($result) {
      alert()->success('Notificación Exitosa!','Se ha enviado al dinamizador una notificación indicando que el comité se ha realizado.')->showConfirmButton('Ok', '#3085d6');
    } else {
      alert()->error('Modificación Exitosa!','No se ha podido notificar al dinamizador, inténtelo de nuevo.')->showConfirmButton('Ok', '#3085d6');
    }
    return back();
  }


  /**
   * Notifica mediante un email los resultado del comité a la persona que registró la idea.
   * @param int $id Id de la idea
   * @param int $idComite Id del comité
   * @return Response
   * @author dum
   */
  public function notificar_resultadoController(int $id, int $idComite)
  {
    $idea = Idea::findOrFail($id);
    $comite = Comite::findOrFail($idComite);
    if(!request()->user()->can('notificar_resultado', [$comite, $idea])) {
      alert('No autorizado', 'No tienes permisos para notificar el resultado de esta idea', 'error')->showConfirmButton('Ok', '#3085d6');
      return back();
  }
    $result = $this->getComiteRepository()->notificar_resultados($id, $idComite);
    if ($result) {
      return response()->json([
        'state' => 'notifica',
        'idea' => $idea->user->email
        ]);
    } else {
      return response()->json([
        'state' => 'no_notifica',
        'idea' => $idea->user->email
      ]);
    }
  }

  // Muestra las evidencias/entregables de un comité
  public function evidencias($id)
  {
    $comite = Comite::findOrFail($id);
    if(!request()->user()->can('cargar_evidencias', $comite)) {
      alert('No autorizado', 'No tienes permisos para ver las evidencias de este comité', 'error')->showConfirmButton('Ok', '#3085d6');
      return back();
  }
    return view('comite.evidencias', compact('comite'));
  }

  /**
   * Array con los ids de las ideas de un comité.
   *
   * @param Comite $csibt Description
   * @return array
   * @author dum
   **/
  public function getIdIdeasDelComiteArray(Comite $csibt)
  {
    $idideas = array();
    foreach ($csibt->ideas as $key => $value) {
      $idideas[$key] = $value->id;
    }
    return $idideas;
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit(int $id)
  {
    $csibt = Comite::findOrFail($id);
    $idideas = $this->getIdIdeasDelComiteArray($csibt);
    $ideas = Idea::ConsultarIdeasConvocadasAComite( $csibt->ideas()->first()->nodo_id )->orWhereIn('ideas.id', $idideas)->get();
    $gestores = User::ConsultarFuncionarios($csibt->ideas()->first()->nodo_id, User::IsExperto())->get();
    return view('comite.edit_agendamiento', [
      'ideas' => $ideas,
      'comite' => $csibt,
      'gestores' => $gestores
    ]);
  }

  /**
   * Asigna un valor a $comiteRepository
   *
   * @param ComiteRepository
   * @return void
   * @author dum
   */
  private function setComiteRepository(ComiteRepository $comiteRepository)
  {
    $this->comiteRepository = $comiteRepository;
  }

  /**
   * Retorna el valor de $comiteRepository
   *
   * @return ComiteRepository
   * @author dum
   */
  private function getComiteRepository()
  {
    return $this->comiteRepository;
  }

}
