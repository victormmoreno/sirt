<?php

namespace App\Http\Controllers;

use App\Noticias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use LimitIterator;

class NoticiasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Mostrar los datos guardados en la base de datos.
        $datos['noticias']=Noticias::orderBy('id','DESC')->paginate(3);
        return view('noticias.index',$datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('noticias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $campos=[
            'Titulo' => 'required|string|max:150',
            'Imagen' => 'required|file|max:255|mimes:jpeg,png,jpg|dimensions:width=603,height=402',
            'Descripcion' => 'required|string|max:300'
        ];

        $Mensaje=["required"=>'El campo :attribute es requerido',
        "dimensions" => "El campo debe tener las siguientes dimensiones :width x :height"];
        $this->validate($request,$campos,$Mensaje);

        //Se agregan todos los datos, excepto el token que funciona como seguridad de datos en Laravel
        $datosNoticia=request()->except('_token');


        if($request->hasFile('Imagen')){
            $datosNoticia['Imagen']=$request->file('Imagen')->store('uploads','public');
        }

        //Agrego los datos que inserté a la base de datos publicaciones
        Noticias::insert($datosNoticia);

        //return response()->json($datosEmpleado);
        return redirect('noticias')->with('Mensaje','Noticia agregada con éxito');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Noticias  $noticias
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Devuelve toda la información correspondiente al id
        $noticias=Noticias::findOrFail($id);
        //retorno de la vista donde se van hacer los cambios
        return view('noticias.edit',compact('noticias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Noticias  $noticias
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $campos=[
            'Titulo' => 'required|string|max:150',
            'Descripcion' => 'required|string|max:300'
        ];

        if($request->hasFile('Imagen')){
            $campos+=['Imagen' => 'required|file|max:255|mimes:jpeg,png,jpg|dimensions:width=603,height=402'];
        }

        $Mensaje=["required"=>'El campo :attribute es requerido'];
        $this->validate($request,$campos,$Mensaje);

        /**
         * Se agregan todos los datos, excepto el token que funciona como seguridad de datos en Laravel
         * y method que es el indicador de acceso a UPDATE.
         */
        $datosNoticia=request()->except(['_token','_method']);
        if($request->hasFile('Imagen')){
            $noticias=Noticias::findOrFail($id);
            //se debe borrar la imagen de manera física para actualizar la imagen desde storage
            Storage::delete('public/'.$noticias->Imagen);
            $datosNoticia['Imagen']=$request->file('Imagen')->store('uploads','public');
        }
        Noticias::where('id','=',$id)->update($datosNoticia);

        //Devuelve toda la información correspondiente al id
        $noticias=Noticias::findOrFail($id);
        return redirect('noticias')->with('Mensaje','Noticia modificada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Noticias  $noticias
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //A través del índice se puede eliminar la información.
        $noticias=Noticias::findOrFail($id);//consulta informacion
        if(Storage::delete('public/'.$noticias->Imagen)){
            Noticias::destroy($id);
        }
        //Redirección a index para verificar que se eliminó el registro
        return redirect('noticias')->with('Mensaje','Noticia eliminada');
    }

}

