<?php

namespace App\Http\Controllers;


use App\Events\Idea\IdeaHasReceived;
use App\Http\Requests\IdeaFormRequest;
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

    //---------------
    public function ideas()
    {
      return 'Msj';
    }


    /*=====  End of metodo para mostrar el registro de ideas en la pagina principal de la aplicacion  ======*/

    //---------------
    public function ideas()
    {
      return 'Msj';
    }


    /*=============================================================================
    =            metodo para mostrar el listado de ideas al infocenter            =
    =============================================================================*/

    public function getIdeas(Request $request)
    {

        if ( $request->input('client') ) {
            return Idea::all()->get();
        }

        $columns = ['fecha', 'nombrec', 'apellidoc','correo','telefono','nombreproyecto'];
        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query = Idea::select('id', 'fecha', 'nombrec','apellidoc','correo','telefono','nombreproyecto')->orderBy($columns[$column], $dir);
        if ($searchValue) {
            $query->where(function($query) use ($searchValue) {
                $query->where('nombrec', 'like', '%' . $searchValue . '%')
                ->orWhere('nombrec', 'like', '%' . $searchValue . '%');
            });
        }
        $ideas = $query->paginate($length);



         return ['data' => $ideas, 'draw' => $request->input('draw')];
    }

    /*=====  End of metodo para mostrar el listado de ideas al infocenter  ======*/



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        $user = User::infoUserNodo('Infocenter',$idea->nodo_id)->first();

        $notificacions = $user->unreadNotifications;


        if (isset($user) && !empty($idea->correo)) {
            $user->notify(new IdeaRecibidaInfocenter($idea, $user));
            Mail::to($idea->correo)->queue(new IdeaEnviadaEmprendedor($idea,$user));
            // event(new IdeaHasReceived($idea));
            event(new IdeaSend($notificacions));
        }

         return "Idea Enviada";
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
}
