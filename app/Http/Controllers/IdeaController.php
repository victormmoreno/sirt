<?php

namespace App\Http\Controllers;


use App\Events\Idea\IdeaHasReceived;
use App\Http\Requests\IdeaFormRequest;
use App\Http\Requests\IdeaEditFormRequest;
use App\Mail\IdeaEnviadaEmprendedor;
use App\Models\EstadoIdea;
use App\Models\Idea;
use App\Models\Nodo;
use App\Notifications\IdeaRecibidaInfocenter;
use App\Repositories\Repository\IdeaRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Events\Idea\IdeaSend;
use Alert;



class IdeaController extends Controller
{

    public $ideaRepository;

    public function __construct(IdeaRepository $ideaRepository)
    {
        $this->ideaRepository = $ideaRepository;
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



    /*=====  End of metodo para mostrar el registro de ideas en la pagina principal de la aplicacion  ======*/

    //--------------- Index para las ideas para los roles de Infocenter,
    public function ideas()
    {
      if (request()->ajax()) {
        $consultaIdeas = Idea::ConsultarIdeasDelNodo(1)->get();
        return datatables()->of($consultaIdeas)
        ->addColumn('details', function ($data) {
          $button = '
          <a class="btn light-blue m-b-xs modal-trigger" href="#modal1" onclick="detalles('. $data->consecutivo .')">
          <i class="material-icons">info</i>
          </a>
          ';
          return $button;
        })->addColumn('edit', function ($data) {
          $edit = '<a class="btn m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';
          return $edit;
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
        // $consultaIdeasEmpGI = Idea::select
      }

      if ( auth()->user()->rol()->first()->nombre == 'Infocenter' ) {
        return view('ideas.infocenter.index');
      } else if ( auth()->user()->rol()->first()->nombre == 'Gestor' ) {
        return view('ideas.gestor.index');
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

        if ($idea != null) {
            Alert::success("La idea {$idea->nombreproyecto} ha sido creado satisfactoriamente.",'Registro Exitoso',"success");
        }else{
            Alert::error("La idea  no se ha creado.",'Registro Erróneo', "error");
        }

         return redirect('ideas');
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
      $idea = Idea::ConsultarIdeaId($id)->first();
      $nodos = Nodo::SelectNodo()->get();
      // dd($nodos);
      return view('ideas.infocenter.edit', compact('idea', 'nodos'));
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

    // Se muestra los detalles de una idea según su id
    public function details($id)
    {
      $idea = Idea::ConsultarIdeaId($id)->first();
      echo json_encode($idea);

    }
}
