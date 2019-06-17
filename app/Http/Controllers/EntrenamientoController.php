<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EntrenamientoFormRequest;
use App\Models\Idea;
use App\Models\Nodo;
use App\Repositories\Repository\EntrenamientoRepository;
use App\Repositories\Repository\IdeaRepository;
use Illuminate\Support\Facades\DB;
use App\User;
use Carbon\Carbon;
use Alert;
// use Alert2;

class EntrenamientoController extends Controller
{

  public $entrenamientoRepository;
  public $ideaRepository;
  public $cont = 0;

  public function __construct(EntrenamientoRepository $entrenamientoRepository, IdeaRepository $ideaRepository)
  {
    $this->entrenamientoRepository = $entrenamientoRepository;
    $this->ideaRepository = $ideaRepository;
    $this->middleware('auth');
    // if (url()->current() == route('entrenamientos.edit', $entrenamiento->id)) {
    //   dd(url()->current());
    // }
  }
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {

    if ( auth()->user()->rol()->first()->nombre == 'Infocenter' ) {
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
        })->addColumn('edit', function ($data) {
          $edit = '<a href="' . route("entrenamientos.edit", $data->id) . '" class="btn m-b-xs"><i class="material-icons">edit</i></a>';
          return $edit;
        })->rawColumns(['details', 'edit', 'update_state'])->make(true);
      }
      $nodo = Nodo::userNodo(auth()->user()->infocenter->nodo_id)->first()->nombre;
      return view('entrenamientos.infocenter.index', compact('nodo'));
    } else if (auth()->user()->rol()->first()->nombre == 'Administrador') {
      $nodos = Nodo::SelectNodo()->get();
      return view('entrenamientos.administrador.index', compact('nodos'));
    } else if (auth()->user()->rol()->first()->nombre == 'Dinamizador') {
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
    echo json_encode($this->entrenamientoRepository->consultarIdeasDelEntrenamiento($id));
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    $nodo = Nodo::userNodo(auth()->user()->infocenter->nodo_id)->first()->nombre;
    $ideas = Idea::ConsultarIdeasEnInicio(auth()->user()->infocenter->nodo_id)->get();
    if ( auth()->user()->rol()->first()->nombre == 'Infocenter' ) {
      return view('entrenamientos.infocenter.create', compact('nodo' ,'ideas'));
    }

  }

  // Inhabilita el entrenamiento, pero se puede elegir si las ideas asociadas al mismo se cambien el estado a Inicio o se inhabiliten al igual que las ideas
  public function inhabilitarEntrenamiento($id, $estado)
  {
    $ideasDelEntrenamiento = $this->entrenamientoRepository->consultarIdeasDelEntrenamiento($id);
    return json_encode([
      'respuesta' => 1
    ]);
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
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
    // exit;
    if (url()->previous() == route('entrenamientos.edit', $id)) {
      $this->cont++;
    }


    $nodo = Nodo::userNodo(auth()->user()->infocenter->nodo_id)->first()->nombre;
    $ideas = Idea::ConsultarIdeasEnInicio(auth()->user()->infocenter->nodo_id)->get();
    $entrenamiento = $this->entrenamientoRepository->consultarEntrenamientoPorId($id);
    // $detalles = $this->entrenamientoRepository->consultarIdeasDelEntrenamiento($id);
    if ( auth()->user()->rol()->first()->nombre == 'Infocenter' ) {
      return view('entrenamientos.infocenter.edit', compact('nodo' ,'ideas', 'entrenamiento'));
    }
  }

  public function cargarIdeasDelEntrenamientoEnLaSesion(Request $request)
  {
    $detalles = $this->entrenamientoRepository->consultarIdeasDelEntrenamiento($request->entrenamiento);

    foreach ($detalles as $key => $value) {

      $idea = Idea::ConsultarIdeaId($value['id'])->get($value['id'])->last();
      if (session("ideasEntrenamientoEdit") != null) {
        $existe = false;
        $dato   = null;
        $ideas = session("ideasEntrenamientoEdit");
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
        session(["ideasEntrenamientoEdit" => $ideas]);
      } else {
        session(["ideasEntrenamientoEdit" => [$idea]] );
      }

    }


  }

  // Devuelve los elemento de la sesion de las ideas del entrenamiento
  public function get_ideasEntrenamientoEdit()
  {
      return json_encode(session("ideasEntrenamientoEdit"));
  }

  // Carga las ideas del entrenamiento a una sesion (Esta sesion es diferente a la del registro del entrenamiento)
  public function add_IdeasEdit(Request $request)
  {
    $input = $request->all();
    $idea = Idea::ConsultarIdeaId($request['Idea'])->get($request['Idea'])->last();
      if (session("ideasEntrenamientoEdit") != null) {
        $existe = false;
        $dato   = null;
        $ideas = session("ideasEntrenamientoEdit");
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
        session(["ideasEntrenamientoEdit" => $ideas]);
      } else {
        session(["ideasEntrenamientoEdit" => [$idea]] );
      }
      return json_encode(['data' => 2]);
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
        // var_dump(session("ideasEntrenamiento"));
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
      return json_encode(session("ideasEntrenamiento"));
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
