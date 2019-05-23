<?php

namespace App\Http\Controllers;
use App\Http\Requests\IdeaFormRequest;
use App\Mail\IdeaReceived;
use App\Models\EstadoIdea;
use App\Models\Idea;
use App\Models\Nodo;
use App\Notifications\IdeaReceivedNotification;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class IdeaController extends Controller
{

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
        $nodos = Nodo::SelectNodo()->get();
        return view('ideas.fanpage', compact('nodos'));
    }

    
    /*=====  End of metodo para mostrar el registro de ideas en la pagina principal de la aplicacion  ======*/

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
        
        $idea = Idea::create([
            "fecha" => Carbon::now(),
            "nombrec"  => $request->input('txtnombres'),
            "apellidoc"   => $request->input('txtapellidos'),
            "correo" => $request->input('txtcorreo'),
            "telefono" => $request->input('txttelefono'),
            "nombreproyecto" => $request->input('txtnombreproyecto'),
            "aprendizsena" => $request->input('txtaprendizsena') == 'on' ?  $request['txtaprendizsena'] = 1 : $request['txtaprendizsena'] = 0,
            "pregunta1" => $request->input('pregunta1'),
            "pregunta2" => $request->input('pregunta2'),
            "pregunta3" => $request->input('pregunta3'),
            "descripcion" => $request->input('txtdescripcion'),
            "objetivo" => $request->input('txtobjetivo'),
            "alcance" => $request->input('txtalcance'),
            "tipoidea" => Idea::IsEmprendedor(),
            "nodo_id" => $request->input('txtnodo'),
            "estadoidea_id" => EstadoIdea::FilterEstadoIdea('nombre','Inicio Emprendedor')->first()->id,
        ]);

        $user = User::infoUserNodo('Infocenter',$idea->nodo_id)->first();

        // dd($user);
        // exit;

        $user->notify(new IdeaReceivedNotification($idea));

        if (isset($user) && !empty($idea->correo)) {
            Mail::to($user->email)->queue(new IdeaReceived($idea,$user));
        }


        

         // return redirect()->route('ideas.index');
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
}
