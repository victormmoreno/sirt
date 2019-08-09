<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EntrenamientoFormRequest;
use App\Models\{Idea, Nodo};
use App\Repositories\Repository\{EntrenamientoRepository, IdeaRepository};
use Illuminate\Support\Facades\{DB, Session};
use App\User;
use Carbon\Carbon;
use Alert;
// use Alert2;

class EntrenamientoController extends Controller
{

  public $entrenamientoRepository;
  public $ideaRepository;

  public function __construct(EntrenamientoRepository $entrenamientoRepository, IdeaRepository $ideaRepository)
  {
    $this->entrenamientoRepository = $entrenamientoRepository;
    $this->ideaRepository = $ideaRepository;
    $this->middleware('auth', ['role_session:Infocenter|Administrador|Dinamizador']);
  }

  /**
  * Modifica los entregables de un entrenamiento
  *
  * @param Request request Datos del formulario de las evidencias de un entrenamiento
  * @param int id Id del entrenamiento al que se le van a modificar los entregables
  * @return Response
  * @author Victor Manuel Moreno Vega
  */
  public function updateEvidencias(Request $request, $id)
  {
    $update = $this->entrenamientoRepository->updateEvidencias($request, $id);
    if ($update) {
      Alert::success('Modificación Existosa!', 'Los entregables del entrenamiento se han modificado!')->showConfirmButton('Ok', '#3085d6');
      return redirect('entrenamientos');
    } else {
      Alert::error('Modificación Errónea!', 'Los entregables del entrenamiento no se han modificado!')->showConfirmButton('Ok', '#3085d6');
      return back();
    }
  }

  /**
  * Retorna la vista donde el infocenter podrá subir las evidencias de lo entrenamientos (Por el id)
  * @param int id Id del entrenamientos del que se registrarán y subiran las evidencias
  * @return \Illuminate\Http\Response
  * @author Victor Manuel Moreno Vega
  */
  public function evidencias($id)
  {
    $entrenamiento = $this->entrenamientoRepository->consultarEntrenamientoPorId($id);
    if ( \Session::get('login_role') == User::IsInfocenter() ) {
      return view('entrenamientos.infocenter.evidencias', [
        'entrenamiento' => $entrenamiento,
      ]);
    }
  }


  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  * @author Victor Manuel Moreno Vega
  */
  public function index()
  {

    if ( \Session::get('login_role') == User::IsInfocenter() ) {
      if (request()->ajax()) {
        $entrenamientos = $this->entrenamientoRepository->consultarEntrenamientosPorNodo( auth()->user()->infocenter->nodo_id );
        return datatables()->of($entrenamientos)
        ->addColumn('details', function ($data) {
          $button = '
          <a class="btn light-blue m-b-xs modal-trigger" href="#modal1" onclick="detallesIdeasDelEntrenamiento('. $data->id .')">
          <i class="material-icons">info</i>
          </a>
          ';
          return $button;
        })->addColumn('update_state', function ($data) {
          $delete = '<a class="btn red lighten-3 m-b-xs" onclick="inhabilitarEntrenamientoPorId('.$data->id.', event)"><i class="material-icons">delete_sweep</i></a>';
          return $delete;
        })->addColumn('evidencias', function ($data) {
          $evidencias = '
          <a class="btn blue-grey m-b-xs" href='. route('entrenamientos.evidencias', $data->id) .'>
            <i class="material-icons">library_books</i>
          </a>
          ';
          return $evidencias;
        })->addColumn('edit', function ($data) {
          $edit = '<a href="' . route("entrenamientos.edit", $data->id) . '" class="btn m-b-xs"><i class="material-icons">edit</i></a>';
          return $edit;
        })->rawColumns(['details', 'edit', 'update_state', 'evidencias'])->make(true);
      }
      $nodo = Nodo::userNodo(auth()->user()->infocenter->nodo_id)->first()->nombre;
      return view('entrenamientos.infocenter.index', compact('nodo'));
    } else if (\Session::get('login_role') == User::IsAdministrador()) {
      $nodos = Nodo::SelectNodo()->get();
      return view('entrenamientos.administrador.index', compact('nodos'));
    } else if (\Session::get('login_role') == User::IsDinamizador()) {
      return view('entrenamientos.dinamizador.index');
    }
  }
  // Datatable para los entrenamientos del nodo (Tabla del dinamizador)
  public function datatableEntrenamientosPorNodo_Dinamizador()
  {
    if (request()->ajax()) {
      $entrenamientos = $this->entrenamientoRepository->consultarEntrenamientosPorNodo( auth()->user()->dinamizador->nodo_id );
      return datatables()->of($entrenamientos)
      ->addColumn('details', function ($data) {
        $button = '
        <a class="btn light-blue m-b-xs modal-trigger" href="#modal1" onclick="detallesIdeasDelEntrenamiento('. $data->id .')">
        <i class="material-icons">info</i>
        </a>
        ';
        return $button;
      })->rawColumns(['details'])->make(true);
    }
  }

  // Datatable para los entrenamientos por nodo, (Por parte del administrador)
  public function datatableEntrenamientosPorNodo($id)
  {
    if (request()->ajax()) {
      $entrenamientos = $this->entrenamientoRepository->consultarEntrenamientosPorNodo( $id );
      return datatables()->of($entrenamientos)
      ->addColumn('details', function ($data) {
        $button = '
        <a class="btn light-blue m-b-xs modal-trigger" href="#modal1" onclick="detallesIdeasDelEntrenamiento('. $data->id .')">
        <i class="material-icons">info</i>
        </a>
        ';
        return $button;
      })->rawColumns(['details'])->make(true);
    }
  }

  // Consulta las ideas que asistieron al entrenamiento
  public function details($id)
  {
    return response()->json($this->entrenamientoRepository->consultarIdeasDelEntrenamiento($id));
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  * @author Victor Manuel Moreno Vega
  */
  public function create()
  {
    $nodo = Nodo::userNodo(auth()->user()->infocenter->nodo_id)->first()->nombre;
    $ideas = Idea::ConsultarIdeasEnInicio(auth()->user()->infocenter->nodo_id)->get();
    if ( \Session::get('login_role') == User::IsInfocenter() ) {
      return view('entrenamientos.infocenter.create', compact('nodo' ,'ideas'));
    }

  }

  /**
  * Cambiar el estado de la ideas de proyecto que están asociadas a un entrenamiento e inhabilitado este
  * @param int id Id del entrenamiento que se va a inhabilitar
  * @param string estado El estado a que se le cambiarán el estado a las ideas de proyecto
  * @return Response\Ajax
  * @author Victor Manuel Moreno Vega
  */
  public function inhabilitarEntrenamiento($id, $estado)
  {
    if (request()->ajax()) {
      if ( Session::get('login_role') == User::IsInfocenter() ) {
        $ideasDelEntrenamiento = $this->entrenamientoRepository->consultarIdeasDelEntrenamiento($id);
        $ideasEnComite = "";
        foreach ($ideasDelEntrenamiento as $key => $value) {
          $v = $this->ideaRepository->consultarIdeaEnComite($value->id);
          if ($v != "") {
            if ($key != 0) {
              $ideasEnComite = $ideasEnComite . ', ' . $v->codigo_idea;
            } else {
              $ideasEnComite = $v->codigo_idea;
            }
          }
        }
        if ($ideasEnComite != "") {
          return response()->json([
            'ideas' => $ideasEnComite,
            'update' => "1"
          ]);
        } else {
          /**
          * Función que cambia el estado de las ideas de proyecto que están asociadas al entrenamiento
          */
          $updateEntrenamiento = "";
          DB::beginTransaction();
          try {
            foreach ($ideasDelEntrenamiento as $key => $value) {
              $this->ideaRepository->updateEstadoIdea($value->id, $estado);
            }
            $archivosEntrenamiento = $this->entrenamientoRepository->consultarArchivosDeUnEntrenamiento($id);
            foreach ($archivosEntrenamiento as $key => $value) {
              $this->entrenamientoRepository->deleteArchivoEntrenamientoPorEntrenamiento($value->id);
            }
            $this->entrenamientoRepository->deleteEntrenamientoIdea($id);
            $this->entrenamientoRepository->deleteEntrenamiento($id);
            DB::commit();
            $updateEntrenamiento = "true";
          } catch (\Exception $e) {
            DB::rollback();
            $updateEntrenamiento = "false";
          }
          return response()->json([
            'update' => $updateEntrenamiento,
            'estado' => $estado
          ]);

        }
      }
    }

  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  * @author Victor Manuel Moreno Vega
  */
  public function store(EntrenamientoFormRequest $request)
  {
    if(session('ideasEntrenamiento') == false) {
      alert()->warning('Advertencia!','Para registrar el entrenamiento debe asociar por lo menos una idea de proyecto.')->showConfirmButton('Ok', '#3085d6');
      return back()->withInput();
    } else {
      if (count($this->entrenamientoRepository->consultarEntrenamientoPorFechas(auth()->user()->infocenter->nodo_id, $request->txtfecha_sesion1, $request->txtfecha_sesion2)) != 0 ) {
        alert()->warning('Advertencia!','Ya se encuentra un entrenamiento registrado en estas fechas.')->showConfirmButton('Ok', '#3085d6');
        return back()->withInput();
      } else {
        DB::transaction(function () use ($request) {
          if (!isset($request->txtcorreos)) {
            $request->txtcorreos = "0";
          }
          if (!isset($request->txtfotos)) {
            $request->txtfotos = "0";
          }
          if (!isset($request->txtlistado_asistencia)) {
            $request->txtlistado_asistencia = "0";
          }
          $entrenamiento = $this->entrenamientoRepository->store($request);
          foreach (session('ideasEntrenamiento') as $key => $value) {
            $this->entrenamientoRepository->storeEntrenamientoIdea($value, $entrenamiento->id);
            // $value['Convocado'] == 1 ? $this->ideaRepository->updateEstadoIdea($value->id, 'Convocado') : $this->ideaRepository->updateEstadoIdea($value->id, 'No Convocado');
            if ($value['Convocado'] == 1) {
              $this->ideaRepository->updateEstadoIdea($value['id'], 'Convocado');
            } else {
              $this->ideaRepository->updateEstadoIdea($value['id'], 'No Convocado');
            }
          }
        });
        session(['ideasEntrenamiento' => []]);
        alert()->success('El Entrenamiento ha sido creado satisfactoriamente','Registro Exitoso.')->showConfirmButton('Ok', '#3085d6');
        return redirect('entrenamientos');
      }
    }
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  * @author Victor Manuel Moreno Vega
  */
  public function edit($id)
  {
    // exit;

    $nodo = Nodo::userNodo(auth()->user()->infocenter->nodo_id)->first()->nombre;
    $ideas = Idea::ConsultarIdeasEnInicio(auth()->user()->infocenter->nodo_id)->get();
    $entrenamiento = $this->entrenamientoRepository->consultarEntrenamientoPorId($id);
    // $detalles = $this->entrenamientoRepository->consultarIdeasDelEntrenamiento($id);
    if ( \Session::get('login_role') == User::IsInfocenter() ) {
      return view('entrenamientos.infocenter.edit', compact('nodo' ,'ideas', 'entrenamiento'));
    }
  }

  //Manejo de sesiones para la lista de las ideas de un entrenamiento
  public function add_idea(Request $request)
  {
    $input = $request->all();

    $idea = Idea::ConsultarIdeaId($input['Idea'])->get($input['Idea'])->last();
    // echo $idea->estado_idea;

    if ($idea->estado_idea == 'Inicio') {

      if (session("ideasEntrenamiento") != null) {

        $existe = false;
        $dato   = null;

        $ideas = session("ideasEntrenamiento");
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
        session(["ideasEntrenamiento" => $ideas]);
      } else {
        session(["ideasEntrenamiento" => [$idea]] );
      }

      return json_encode(['data' => 2]);
    } else {
      return json_encode(['data' => 1]);
    }
  }

  // Devuelve los elemento de la sesion de las ideas del entrenamiento
  public function get_ideasEntrenamiento()
  {
      if ( Session::get('login_role') == User::IsInfocenter() ) {
        return json_encode(session("ideasEntrenamiento"));
      }
  }

  // Elimina la idea de la tabla de las ideas en el formulario para registrar un neuvo entrenamiento
  public function eliminar_idea($id)
  {
    $var = session("ideasEntrenamiento");

    foreach ($var as $key => $value) {

      $new = $value->id;

      if ($new == $id) {
        unset($var[$key]);
      }
    }
    session(["ideasEntrenamiento" => $var]);
    return json_encode(['data' => 1]);
  }

  // Carga si se convocó o no la idea a la sesion (Los siguientes métodos hacen lo mismo pero para los diferentes checkboxes)
  public function getConfirm($id, $estado)
  {
    $ideas = session("ideasEntrenamiento");
    foreach ($ideas as $key => $value) {
      if ($value["id"] == $id) {
        $dato = $value;
        if ($estado == 1) {
          $dato['Confirm'] = 0;
        } else {
          $dato['Confirm'] = 1;
        }
      }
    }
    return json_encode(['data' => 1]);
  }

  public function getCanvas($id, $estado)
  {
    $ideas = session("ideasEntrenamiento");
    foreach ($ideas as $key => $value) {
      if ($value["id"] == $id) {
        $dato = $value;
        if ($estado == 1) {
          $dato['Canvas'] = 0;
        } else {
          $dato['Canvas'] = 1;
        }
      }
    }
    return json_encode(['data' => 1]);
  }

  public function getAssistF($id, $estado)
  {
    $ideas = session("ideasEntrenamiento");
    foreach ($ideas as $key => $value) {
      if ($value["id"] == $id) {
        $dato = $value;
        if ($estado == 1) {
          $dato['AssistF'] = 0;
        } else {
          $dato['AssistF'] = 1;
        }
      }
    }
    return json_encode(['data' => 1]);
  }

  public function getAssistS($id, $estado)
  {
    $ideas = session("ideasEntrenamiento");
    foreach ($ideas as $key => $value) {
      if ($value["id"] == $id) {
        $dato = $value;
        if ($estado == 1) {
          $dato['AssistS'] = 0;
        } else {
          $dato['AssistS'] = 1;
        }
      }
    }
    return json_encode(['data' => 1]);
  }

  public function getConvocado($id, $estado)
  {
    $ideas = session("ideasEntrenamiento");
    foreach ($ideas as $key => $value) {
      if ($value["id"] == $id) {
        $dato = $value;
        if ($estado == 1) {
          $dato['Convocado'] = 0;
        } else {
          $dato['Convocado'] = 1;
        }
      }
    }
    return json_encode(['data' => 1]);
  }

}
