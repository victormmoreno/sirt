<?php

namespace App\Http\Controllers;


use Alert;
use App\Events\Idea\IdeaSend;
use App\Helpers\ArrayHelper;
use App\Http\Requests\{IdeaFormRequest, IdeaEditFormRequest, IdeaEGIFormRequest};
use App\Mail\IdeaEnviadaEmprendedor;
use App\Models\{EstadoIdea, Idea, Nodo};
use App\Repositories\Repository\ConfiguracionRepository\ServidorVideoRepository;
use App\Repositories\Repository\IdeaRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\{Cache, Mail, Session};



class IdeaController extends Controller
{

  public $ideaRepository;

  public function __construct(IdeaRepository $ideaRepository)
  {
    $this->ideaRepository = $ideaRepository;
    $this->middleware('auth',['except' =>['index','store']]);
  }

  /**
   * Datatable que muestra las ideas de proyecto de un nodo
   * @param int id Consulta TODAS las ideas de proyecto de tecnoparque por nodo que hay en la base de datos
   * @return Datatable
   */
  public function dataTableIdeasTodosPorNodo($id)
  {
    $idnodo = "";
    if ( Session::get('login_role') == User::IsGestor() ) {
      $idnodo = auth()->user()->gestor->nodo_id;
    } else if ( Session::get('login_role') == User::IsInfocenter() ) {
      $idnodo = auth()->user()->infocenter->nodo_id;
    } else if ( Session::get('login_role') == User::IsDinamizador() ) {
      $idnodo = auth()->user()->dinamizador->nodo_id;
    } else {
      $idnodo = $id;
    }
    $ideas = Idea::ConsultarTodasLasIdeasDeUnNodo($idnodo)->get()->toArray();
    $ideas = ArrayHelper::validarDatoNullDeUnObject($ideas);

    return datatables()->of($ideas)
    ->editColumn('admitido', function ($data) {
      if ($data['admitido'] == "0") {
        $admitido = 'No';
      } else if ($data['admitido'] == "1") {
        $admitido = 'Si';
      } else {
        $admitido = 'No hay información disponible';
      }
      return $admitido;
    })->make(true);
  }

  /**
   * Cambia el estado de idea a una idea de proyecto
   * @param int id Id de la idea que se le va a cambiar el estado
   * @param string estado nombre del estado al que se va a cambiar la idea
   * @return void
   */
  public function updateEstadoIdea($id, $estado)
  {
    $idea = Idea::ConsultarIdeaId($id)->first();
    if ($idea->estado_idea == 'Inicio') {
      $this->ideaRepository->updateEstadoIdea($id, $estado);
      return response()->json([
        'route' => route('idea.ideas'),
      ]);
    }
  }

  /*========================================================================================================
  =            metodo para mostrar el registro de ideas en la pagina principal de la aplicacion            =
  ========================================================================================================*/

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index(ServidorVideoRepository $servidorVideoRepository)
  {
    $nodos = $this->ideaRepository->getSelectNodo();
    $servidorVideo = $servidorVideoRepository->getAllServidorVideo();

    return view('ideas.fanpage', compact('nodos','servidorVideo'));
  }

  // ------------------------------- Método registrar una idea de proyecto con empresas o grupos de investigación
  public function empresasGI()
  {
    if ( \Session::get('login_role') == User::IsInfocenter() ) {
      return view('ideas.infocenter.egi');
    }
  }

  /*=====  End of metodo para mostrar el registro de ideas en la pagina principal de la aplicacion  ======*/
  //--------------- Index para las ideas para los roles de Infocenter,
  public function ideas()
  {
    if ( \Session::get('login_role') == User::IsInfocenter() ) {
      if (request()->ajax()) {
        $consultaIdeas = Idea::ConsultarIdeasDelNodo(auth()->user()->infocenter->nodo_id)->get();
        return datatables()->of($consultaIdeas)
        ->addColumn('details', function ($data) {
          $button = '
          <a class="btn light-blue m-b-xs modal-trigger" href="#modal1" onclick="detallesIdeaPorId('. $data->consecutivo .')">
            <i class="material-icons">info</i>
          </a>
          ';
          return $button;
        })->addColumn('soft_delete', function ($data) {
          if ($data->estado != 'Inicio') {
            $delete = '<a class="btn red lighten-3 m-b-xs" disabled><i class="material-icons">delete_sweep</i></a>';
          } else {
            $delete = '<a class="btn red lighten-3 m-b-xs" onclick="cambiarEstadoIdeaDeProyecto('.$data->consecutivo.', \'Inhabilitado\')"><i class="material-icons">delete_sweep</i></a>';
          }
          return $delete;
        })->addColumn('dont_apply', function ($data) {
          if ($data->estado != 'Inicio') {
            $notapply = '<a class="btn brown lighten-3 m-b-xs" disabled><i class="material-icons">thumb_down</i></a>';
          } else {
            $notapply = '<a class="btn brown lighten-3 m-b-xs" onclick="cambiarEstadoIdeaDeProyecto('.$data->consecutivo.', \'No Aplica\')"><i class="material-icons">thumb_down</i></a>';
          }
          return $notapply;
        })->addColumn('edit', function ($data) {
          $edit = '<a href="' . route("idea.edit", $data->consecutivo) . '" class="btn m-b-xs"><i class="material-icons">edit</i></a>';
          return $edit;
        })->rawColumns(['details', 'edit', 'soft_delete', 'dont_apply'])->make(true);
      }
      $nodo = Nodo::userNodo(auth()->user()->infocenter->nodo_id)->first()->nombre;
      return view('ideas.infocenter.index', compact('nodo'));
    } else if ( \Session::get('login_role') == User::IsGestor() ) {
      return view('ideas.gestor.index');
    } else if ( \Session::get('login_role') == User::IsAdministrador() ) {
      $nodos = Nodo::SelectNodo()->get();
      return view('ideas.administrador.index', compact('nodos'));
    } else if ( \Session::get('login_role') == User::IsDinamizador() ) {
      return view('ideas.dinamizador.index');
    }
  }

  // Datatable que muestra las ideas de proyecto (emprendedores) por nodo
  public function dataTableIdeasEmprendedoresPorNodo($id)
  {
    if (\Session::get('login_role') == User::IsGestor()) {
      $id = auth()->user()->gestor->nodo_id;
    } else if (\Session::get('login_role') == User::IsDinamizador()) {
      $id = auth()->user()->dinamizador->nodo_id;
    }
    $consultaIdeas = Idea::ConsultarIdeasDelNodo($id)->get();
    return datatables()->of($consultaIdeas)
    ->addColumn('details', function ($data) {
      $button = '
      <a class="btn light-blue m-b-xs modal-trigger" href="#modal1" onclick="detallesIdeaPorId('. $data->consecutivo .')">
        <i class="material-icons">info</i>
      </a>
      ';
      return $button;
    })->rawColumns(['details'])->make(true);
  }

  // Datatable que muestra las ideas de proyecto con empresas o grupos de investigación
  public function dataTableIdeasEmpresasGIPorNodo($id)
  {
    if ( \Session::get('login_role') == User::IsGestor() ) {
      $id = auth()->user()->gestor->nodo_id;
    } else if ( \Session::get('login_role') == User::IsDinamizador() ) {
      $id = auth()->user()->dinamizador->nodo_id;
    } else if ( \Session::get('login_role') == User::IsInfocenter() ) {
      $id = auth()->user()->infocenter->nodo_id;
    }

    if (request()->ajax()) {
      $consultaIdeasEmpGI = Idea::ConsultarIdeasEmpGIDelNodo($id);
      return datatables()->of($consultaIdeasEmpGI)->make(true);
    }
  }
  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  //IdeaFormRequest
  public function store(IdeaFormRequest $request)
  {

    $idea = $this->ideaRepository->Store($request);
    if ($idea != null) {

        // $idea = $this->ideaRepository->getIdeaWithRelations($idea);
        return redirect()->back()->withSuccess('success');

    }
    return redirect('ideas');
  }

  public function storeEGI(IdeaEGIFormRequest $request)
  {
    $idea = $this->ideaRepository->StoreIdeaEmpGI($request);
    if ($idea != null) {
      Alert::success('Registro Exitoso!', 'La idea se ha registrado exitosamente')->showConfirmButton('Ok', '#3085d6');
    }else{
      Alert::error("La idea  no se ha creado.",'Registro Erróneo')->showConfirmButton('Ok', '#3085d6');
    }
    return redirect('idea');
  }


  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    if (\Session::get('login_role') == User::Isinfocenter()) {
      $idea = Idea::ConsultarIdeaId($id)->first();
      $nodos = Nodo::SelectNodo()->get();
      return view('ideas.infocenter.edit', compact('idea', 'nodos'));
    } else {
      alert()->error('Error!','No tienes permisos para realizar esta acción.')->showConfirmButton('Ok', '#3085d6');
      return back();
    }
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */

  public function update(IdeaEditFormRequest $request, $id)
  {
    $idea = $this->ideaRepository->findByid($id);
    $updateIdea = $this->ideaRepository->Update($request, $idea);
    if ($updateIdea == true) {
      Alert::success("La Idea se ha modificado.", 'Modificación Exitosa', "success");
    } else {
      Alert::error("La Idea no se ha modificado.", 'Modificación Errónea', "error");
    }

    return redirect('idea');

  }

  public function detallesIdeas($id)
  {
    return response()->json([
    'detalles' => Idea::ConsultarIdeaId($id)->first(),
    ]);
  }

  // Se muestra los detalles de una idea según su id
  public function details($id)
  {
    if (request()->ajax()) {
      $consultaIdeasEmpGI = Idea::ConsultarIdeasEmpGIDelNodo(auth()->user()->infocenter->nodo_id);
      return datatables()->of($consultaIdeasEmpGI)->make(true);
    }
  }
}
