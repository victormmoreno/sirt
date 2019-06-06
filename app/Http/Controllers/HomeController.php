<?php

namespace App\Http\Controllers;

use App\Models\Nodo;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        // if (auth()->user()->hasRole('Infocenter')) {
        // $nodo = Nodo::where('id','=',auth()->user()->infocenter->nodo_id)->first()->nombre;
        // $nodo = Nodo::userNodo(auth()->user()->infocenter->nodo_id)->first()->nombre;
        
        // $user  = auth()->user()->infocenter->nodo_id;
        // dd($nodo);

            // dd($administradores);
            return view('home');
        // } else if(auth()->user()->hasRole('Dinamizador')){
        //     echo "Infocenter";
        // }else{
        //   abort(403);
        // }

    }
}
