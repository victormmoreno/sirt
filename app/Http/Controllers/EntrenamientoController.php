<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EntrenamientoFormRequest;
use App\Models\Idea;
use App\Models\Nodo;
use App\Repositories\Repository\EntrenamientoRepository;
use App\User;
use Carbon\Carbon;
use Alert;

class EntrenamientoController extends Controller
{

  public $entrenamientoRepository;

  public function __construct(EntrenamientoRepository $entrenamientoRepository)
  {
    $this->entrenamientoRepository = $entrenamientoRepository;
    $this->middleware('auth');
  }
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $nodo = Nodo::userNodo(auth()->user()->infocenter->nodo_id)->first()->nombre;

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
        $delete = '<a class="btn red lighten-3 m-b-xs"><i class="material-icons">delete_sweep</i></a>';
        return $delete;
      })->addColumn('edit', function ($data) {
        $edit = '<a href="' . route("entrenamientos.edit", $data->id) . '" class="btn m-b-xs"><i class="material-icons">edit</i></a>';
        return $edit;
      })->rawColumns(['details', 'edit', 'update_state'])->make(true);
    }

    if ( auth()->user()->rol()->first()->nombre == 'Infocenter' ) {
      return view('entrenamientos.infocenter.index', compact('nodo'));
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
    // $ideas = Idea::ConsultarIdeasEnInicio(auth()->user()->infocenter->nodo_id)->get();
    // dd(session("ideasEntrenamiento"));
    if ( auth()->user()->rol()->first()->nombre == 'Infocenter' ) {
      return view('entrenamientos.infocenter.create', compact('nodo' ,'ideas'));
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
    dd($request->all());
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
