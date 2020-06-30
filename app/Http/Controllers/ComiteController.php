<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\{ComiteAgendamientoFormRequest, ComiteRealizarFormRequest, ComiteAsignarFormRequest};
use App\Repositories\Repository\{ComiteRepository, IdeaRepository};
use App\Models\{Nodo, Idea, Comite, EstadoIdea, Gestor};
use Illuminate\Support\Facades\{Session, Validator};
Use App\User;

class ComiteController extends Controller
{

  private $comiteRepository;
  private $ideaRepository;

  public function __construct(ComiteRepository $comiteRepository, IdeaRepository $ideaRepository)
  {
    $this->setComiteRepository($comiteRepository);
    $this->setIdeaRepository($ideaRepository);
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
    if ( Session::get('login_role') == User::IsInfocenter() && $comite->estado->nombre == 'Agendamiento' ) {
      return view('comite.infocenter.detalle_agendamiento', [
        'comite' => $comite
      ]);
    } else if ( Session::get('login_role') == User::IsInfocenter() && $comite->estado->nombre == 'Realizado' ) {
      return view('comite.infocenter.detalle_realizado', [
        'comite' => $comite
      ]);
    } else if (Session::get('login_role') == User::IsInfocenter() && $comite->estado->nombre == 'Proyectos asignados') {
      return view('comite.infocenter.detalle_asignado', [
        'comite' => $comite
      ]);
    } else if (Session::get('login_role') == User::IsDinamizador() && $comite->estado->nombre == 'Agendamiento') {
      return view('comite.dinamizador.detalle_agendamiento', [
        'comite' => $comite
      ]);
    } else if (Session::get('login_role') == User::IsDinamizador() && $comite->estado->nombre == 'Realizado') {
      return view('comite.dinamizador.detalle_realizado', [
        'comite' => $comite
      ]);
    } else if (Session::get('login_role') == User::IsDinamizador() && $comite->estado->nombre == 'Proyectos asignados') {
      return view('comite.dinamizador.detalle_asignado', [
        'comite' => $comite
      ]);
    } else if (Session::get('login_role') == User::IsGestor() && $comite->estado->nombre == 'Agendamiento') {
      return view('comite.gestor.detalle_agendamiento', [
        'comite' => $comite
      ]);
    } else if (Session::get('login_role') == User::IsGestor() && $comite->estado->nombre == 'Realizado') {
      return view('comite.gestor.detalle_realizado', [
        'comite' => $comite
      ]);
    } else if (Session::get('login_role') == User::IsGestor() && $comite->estado->nombre == 'Proyectos asignados') {
      return view('comite.gestor.detalle_asignado', [
        'comite' => $comite
      ]);
    }
  }

  /**
   * Formulario para asignar las ideas de proyecto a los gestores del nodo
   * @param int $id Id del comité
   */
  public function asignar(int $id)
  {
    $comite = Comite::findOrFail($id);
    $gestores = Gestor::ConsultarGestoresPorNodo(auth()->user()->dinamizador->nodo_id)->pluck('nombres_gestor', 'id');
    return view('comite.dinamizador.asignar_ideas', [
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
    $estados = EstadoIdea::whereIn('nombre', ['Inicio', 'Reagendamiento', 'Inhabilitado', 'Admitido'])->get();
    return view('comite.infocenter.realizar_comite', [
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
    if ( Session::get('login_role') == User::IsInfocenter() ) {
      if (request()->ajax()) {
        $csibt = $this->getComiteRepository()->consultarComitesPorNodo( auth()->user()->infocenter->nodo_id );
        return datatables()->of($csibt)
        ->addColumn('details', function ($data) {
          $details = '<a class="btn m-b-xs" href="' . route('csibt.detalle', $data->id) . '"><i class="material-icons">search</i></a>';
          return $details;
        })->rawColumns(['details'])->make(true);
      }
      return view('comite.infocenter.index');
    } else if ( Session::get('login_role') == User::IsGestor() ) {
      if (request()->ajax()) {
        $csibt = $this->getComiteRepository()->consultarComitesPorNodo( auth()->user()->gestor->nodo_id );
        return datatables()->of($csibt)
        ->addColumn('details', function ($data) {
          $details = '<a class="btn m-b-xs" href="' . route('csibt.detalle', $data->id) . '"><i class="material-icons">search</i></a>';
          return $details;
        })->rawColumns(['details'])->make(true);
      }
      return view('comite.gestor.index');
    } else if ( Session::get('login_role') == User::IsAdministrador() ) {
      $nodos = Nodo::SelectNodo()->get();
      return view('comite.administrador.index', compact('nodos'));
    } else if ( Session::get('login_role') == User::IsDinamizador() ) {
      if (request()->ajax()) {
        $csibt = $this->getComiteRepository()->consultarComitesPorNodo( auth()->user()->dinamizador->nodo_id );
        return datatables()->of($csibt)
        ->addColumn('details', function ($data) {
          $details = '<a class="btn m-b-xs" href="' . route('csibt.detalle', $data->id) . '"><i class="material-icons">search</i></a>';
          return $details;
        })->rawColumns(['details'])->make(true);
      }
      return view('comite.dinamizador.index');
    }
  }

  // Datatable para mostrar los archivos de un comité (Infocenter)
  public function datatableArchivosDeUnComite($id)
  {
    if (request()->ajax()) {
      if ( Session::get('login_role') == User::IsInfocenter() ) {
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
      } else {
        $archivosComite = $this->getComiteRepository()->consultarRutasArchivosDeUnComite( $id );
        return datatables()->of($archivosComite)
        ->addColumn('download', function ($data) {
          $download = '
          <a target="_blank" href="' . route('csibt.files.download', $data->id) . '" class="btn blue darken-4 m-b-xs">
          <i class="material-icons">file_download</i>
          </a>
          ';
          return $download;
        })->addColumn('file', function ($data) {
          $file = '
          <i class="material-icons">insert_drive_file</i> ' . basename( url($data->ruta) ) . '
          ';
          return $file;
        })->rawColumns(['download', 'file'])->make(true);

      }
    }
  }

  public function datatableCsibtPorNodo_Administrador($id)
  {
    if (request()->ajax()) {
      return datatables()->of($this->getComiteRepository()->consultarComitesPorNodo($id))
      ->addColumn('details', function ($data) {
        $button = '
        <a class="btn light-blue m-b-xs modal-trigger" href="#modal1" onclick="csibt.consultarComitesPorNodo('. $data->id .')">
        <i class="material-icons">info</i>
        </a>
        ';
        return $button;
      })->addColumn('evidencias', function ($data) {
        $button = '
        <a class="btn blue-grey m-b-xs" href="' . route('csibt.evidencias', $data->id) . '">
        <i class="material-icons">library_books</i>
        </a>
        ';
        return $button;
      })->rawColumns(['details', 'evidencias'])->make(true);
    }
  }

  // Método para modificar las evidencias de un comité
  public function updateEvidencias(Request $request, $id)
  {
    !isset($request['ev_correos']) ? $request['ev_correos'] = 0 : $request['ev_correos'] = 1;
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
    // session(['ideasComiteCreate' => []]);

    if ( Session::get('login_role') == User::IsInfocenter() ) {
       $ideas = Idea::ConsultarIdeasConvocadasAComite( auth()->user()->infocenter->nodo_id )->get();
       // dd($ideas);
      return view('comite.infocenter.create2', compact('ideas'));
    }
  }

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
    if ( Session::get('login_role') == User::IsInfocenter() ) {
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
    } else {
      abort('403');
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
   * @return Response
   * @author dum
   */
  public function notificar_agendamientoController(int $id)
  {
    $result = $this->getComiteRepository()->notificar_agendamiento($id);
    if ($result) {
      alert()->success('Notificación Exitosa!','La citación para el comité se ha enviado con éxito.')->showConfirmButton('Ok', '#3085d6');
    } else {
      alert()->error('Modificación Exitosa!','La citación para el comité no se ha enviado.')->showConfirmButton('Ok', '#3085d6');
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
    $result = $this->getComiteRepository()->notificar_resultados($id, $idComite);
    $idea = Idea::findOrFail($id);
    if ($result) {
      // alert()->success('Notificación Exitosa!','Se ha enviado un mensaje a la dirección: '.$idea->correo_contacto.' con los resultados del comité.')->showConfirmButton('Ok', '#3085d6');
      return response()->json([
        'state' => 'notifica',
        'idea' => $idea
        ]);
    } else {
      return response()->json([
        'state' => 'no_notifica',
        'idea' => $idea
      ]);
    }
  }
  

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  // public function store(ComiteFormRequest $request)
  // {
    
  //   if ( session('ideasComiteCreate') == false ) {
  //     alert()->warning('Advertencia!','Para registrar el comité debe asociar por lo menos una idea de proyecto.')->showConfirmButton('Ok', '#3085d6');
  //     return back()->withInput();
  //   } else {
  //     // $contComites = COUNT($this->getComiteRepository()->consultarComitePorNodoYFecha( auth()->user()->infocenter->nodo_id, $request->txtfechacomite_create ));
  //     $contComites = COUNT(session('ideasComiteCreate'));
  //     if ( $contComites > 8 ) {
  //       alert()->warning('Advertencia!','Solo se puede asociar un máximo de 8 ideas de proyectos al comité (Se puede registrar otro comité en el mismo día).')->showConfirmButton('Ok', '#3085d6');
  //       return back()->withInput();
  //     } else {
  //       DB::transaction(function () use ($request) {
  //         $codigoComite = Carbon::parse($request['txtfechacomite_create']);
  //         $nodo = sprintf("%02d", auth()->user()->infocenter->nodo_id);
  //         $infocenter = sprintf("%03d", auth()->user()->infocenter->id);
  //         $idComite = Comite::selectRaw('MAX(id+1) AS max')->get()->last();
  //         $idComite->max == null ? $idComite->max = 1 : $idComite->max = $idComite->max;
  //         $idComite->max = sprintf("%04d", $idComite->max);
  //         $codigoComite = 'C' . $nodo . $infocenter . '-' . $codigoComite->isoFormat('YYYY') . '-' .$idComite->max;
  //         $comite = $this->getComiteRepository()->store($request, $codigoComite);
  //         foreach (session('ideasComiteCreate') as $key => $value) {
  //           $this->getComiteRepository()->storeComiteIdea($value, $comite->id);
  //           $value['FechaComite'] = $comite->fechacomite;
  //           if ($value['Admitido'] == 1) {
              // $pdf = PdfComiteController::printPDF($value);
              // event(new ComiteWasRegistered($value, $pdf));
  //             $this->getIdeaRepository()->updateEstadoIdea($value['id'], 'Admitido');
  //           } else {
  //             $pdf = PdfComiteController::printPDFNoAceptado($value);
  //             event(new ComiteWasRegistered($value, $pdf));
  //             $this->getIdeaRepository()->updateEstadoIdea($value['id'], 'No Admitido');
  //           }
  //         }
  //       });
  //       session(['ideasComiteCreate' => []]);
  //       alert()->success('El CSIBT ha sido creado satisfactoriamente','Registro Exitoso.')->showConfirmButton('Ok', '#3085d6');
  //       return redirect('csibt');
  //     }
  //   }
  // }

  // Muestra las evidencias/entregables de un comité
  public function evidencias($id)
  {
    if ( Session::get('login_role') == User::IsInfocenter() ) {
      $comite = Comite::findOrFail($id);
      return view('comite.infocenter.evidencias', compact('comite'));
    } else if (Session::get('login_role') != User::IsIngreso() && Session::get('login_role') != User::IsTalento())  {
      $comite = Comite::findOrFail($id);
      return view('comite.evidencias', compact('comite'));
    }
  }

  // /**
  // * Display the specified resource.
  // *
  // * @param  int  $id
  // * @return \Illuminate\Http\Response
  // */
  // public function show($id)
  // {
  //   if (request()->ajax()) {
  //     return json_encode([
  //       'ideasDelComite' => $this->getComiteRepository()->consultarIdeasDelComite($id)
  //     ]);
  //   }
  // }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit(int $id)
  {
    if ( Session::get('login_role') == User::IsInfocenter() ) {
      $ideas = Idea::ConsultarIdeasConvocadasAComite( auth()->user()->infocenter->nodo_id )->get();
      $csibt = Comite::findOrFail($id);
      return view('comite.infocenter.edit_agendamiento', [
        'ideas' => $ideas,
        'comite' => $csibt
      ]);
    }
  }

  // Métodos que manejar la sesion del comité
  public function addIdeaDeProyectoCreate(Request $request)
  {
    $input = $request->all();

    $idea = Idea::ConsultarIdeaId($input['Idea'])->get($input['Idea'])->last();


    // Aquí se agregan los campos de las ideas de proyecto
    $idea['Hora'] = $input['hora'];
    $idea['Asistencia'] = $input['asistencia'];
    // $idea['Observaciones'] = $input['observaciones'];
    $input['observaciones'] == null ? $idea['Observaciones'] = '' : $idea['Observaciones'] = $input['observaciones'];
    $idea['Admitido'] = $input['admitido'];

    if (session("ideasComiteCreate") != null) {

      $existe = false;
      $dato   = null;

      $ideas = session("ideasComiteCreate");
      foreach ($ideas as $key => $value) {
        if ($value["id"] == $input["Idea"]) {
          $dato = $value;

          unset($ideas[$key]);

          $existe = true;
        }
      }

      if (!$existe) {
        array_push($ideas, $idea);
      } else {
        return json_encode(['data' => 3]);
      }
      session(["ideasComiteCreate" => $ideas]);
    } else {
      session(["ideasComiteCreate" => [$idea]] );
    }

    return json_encode(['data' => 2]);
  }

  // Devuelve los elemento de la sesion de las ideas del comité (Create)
  public function get_ideasComiteCreate()
  {
    return json_encode(session("ideasComiteCreate"));
  }

  // Elimina la idea de la tabla de las ideas en el formulario para registrar un nuevo comité
  public function get_eliminarIdeaComiteCreate($id)
  {
    $var = session("ideasComiteCreate");

    foreach ($var as $key => $value) {

      $new = $value->id;

      if ($new == $id) {
        unset($var[$key]);
      }
    }
    session(["ideasComiteCreate" => $var]);
    return json_encode([
      'data' => 1
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

  /**
   * Asigna un valor a $ideaRepository
   *
   * @param IdeaRepository
   * @return void
   * @author dum
   */
  private function setIdeaRepository(IdeaRepository $ideaRepository)
  {
    $this->ideaRepository =  $ideaRepository;
  }

  /**
   * Retorna el valor de $ideaRepository
   *
   * @return IdeaRepository
   * @author dum
   */
  private function getIdeaRepository()
  {
    return $this->ideaRepository;
  }
}
