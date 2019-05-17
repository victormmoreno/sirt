<?php

namespace App\Http\Controllers;
use App\Models\Nodo;
use App\Models\Idea;
use App\Models\EstadoIdea;
use App\Http\Requests\IdeaFormRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\IdeaReceived;

use Illuminate\Http\Request;

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
    public function store(Request $request)
    {

        $idea = Idea::create([
            "fecha" => Carbon::now(),
            "nombrec"  => $request->input('txtnombres'),
            "apellidoc"   => $request->input('txtapellidos'),
            "correo" => $request->input('txtcorreo'),
            "telefono" => $request->input('txttelefono'),
            "nombreproyecto" => $request->input('txtnombreproyecto'),
            "aprendizsena" => $request->input('txtaprendizsena'),
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

        Mail::to('jlondono433@misena.edu.co')->send(new IdeaReceived($idea));

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
