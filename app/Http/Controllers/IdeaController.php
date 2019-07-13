<?php

namespace App\Http\Controllers;


use App\Events\Idea\IdeaHasReceived;
use App\Http\Requests\{IdeaFormRequest, IdeaEditFormRequest, IdeaEGIFormRequest};
use App\Mail\IdeaEnviadaEmprendedor;
use App\Models\{EstadoIdea, Idea, Nodo};
use App\Notifications\IdeaRecibidaInfocenter;
use App\Repositories\Repository\IdeaRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Cache, Mail};
use App\Events\Idea\IdeaSend;
use Alert;



class IdeaController extends Controller
{

    public $ideaRepository;

    public function __construct(IdeaRepository $ideaRepository)
    {
        $this->ideaRepository = $ideaRepository;
        // $nodo = Nodo::userNodo(auth()->user()->gestor->nodo_id)->first()->nombre;
        // dd(auth()->user()->gestor->nodo_id);
        $this->middleware('auth',['except' =>['index','store']]);
    }

    /*========================================================================================================
    =            metodo para mostrar el registro de ideas en la pagina principal de la aplicacion            =
    ========================================================================================================*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        $nodos = $this->ideaRepository->getSelectNodo();
        // $nodos = Idea::getAllIdeas();
        // dd($nodos);

        return view('ideas.fanpage', compact('nodos'));
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
      // var_dump( Idea::ConsultarIdeasDelNodo(auth()->user()->gestor->nodo_id)->get());
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
            $delete = '<a class="btn red lighten-3 m-b-xs"><i class="material-icons">delete_sweep</i></a>';
            return $delete;
          })->addColumn('dont_apply', function ($data) {
            $notapply = '<a class="btn brown lighten-3 m-b-xs"><i class="material-icons">thumb_down</i></a>';
            return $notapply;
          })->addColumn('edit', function ($data) {
            $edit = '<a href="' . route("idea.edit", $data->consecutivo) . '" class="btn m-b-xs"><i class="material-icons">edit</i></a>';
            return $edit;
          })->rawColumns(['details', 'edit', 'soft_delete', 'dont_apply'])->make(true);
          // $this->ideasEmpGI();
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
      if (\Session::get('login_role') == User::IsGestor()) {
        $id = auth()->user()->gestor->nodo_id;
      } else if (\Session::get('login_role') == User::IsDinamizador()) {
        $id = auth()->user()->dinamizador->nodo_id;
      }

      if (request()->ajax()) {
        $consultaIdeasEmpGI = Idea::ConsultarIdeasEmpGIDelNodo($id);
        return datatables()->of($consultaIdeasEmpGI)->make(true);
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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

        // $user = User::infoUserNodo('Infocenter',$idea->nodo_id)->first();
        // alert()->success('La empresa ha sido creada satisfactoriamente','Registro Exitoso.')->showConfirmButton('Ok', '#3085d6');
        if ($idea != null) {
          alert()->success('Registro Exitoso!','La idea ha sido creado satisfactoriamente.')->showConfirmButton('Ok', '#3085d6');
        }else{
          alert()->error('Registro Erróneo!','La idea  no se ha creado.')->showConfirmButton('Ok', '#3085d6');
        }

         return redirect('ideas');
    }

    public function storeEGI(IdeaEGIFormRequest $request)
    {
      // dd($request->txttipo_idea[1]);
      // $request1 = $request;
      $idea = $this->ideaRepository->StoreIdeaEmpGI($request);
      if ($idea != null) {
          Alert::success('Registro Exitoso!', 'La idea se ha registrado exitosamente')->showConfirmButton('Ok', '#3085d6');
      }else{
          Alert::error("La idea  no se ha creado.",'Registro Erróneo')->showConfirmButton('Ok', '#3085d6');
      }
      return redirect('idea');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $idea = $this->ideaRepository->findByid($id);
        return $idea;
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

      // if ($updateIdea != null) {
      //   Alert::success("La idea {$idea->nombreproyecto} ha sido actualizada satisfactoriamente.",'Actualización Exitoso',"success");
      // } else {
      //   Alert::error("La idea  no se ha creado.",'Registro Erróneo', "error");
      // }

    }

    public function detallesIdeas($id)
    {
      return response()->json([
          'detalles' => Idea::ConsultarIdeaId($id)->first(),
      ]);
      // return reponse()->json([ 'user' => Idea::ConsultarIdeaId($id)->first()]);
    }

    // Se muestra los detalles de una idea según su id
    public function details($id)
    {
      if (request()->ajax()) {
        $consultaIdeasEmpGI = Idea::ConsultarIdeasEmpGIDelNodo(auth()->user()->infocenter->nodo_id);
        return datatables()->of($consultaIdeasEmpGI)->make(true);
      }
      // echo json_encode(Idea::ConsultarIdeaId($id)->first());
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
