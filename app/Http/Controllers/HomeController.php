<?php

namespace App\Http\Controllers;

use App\Models\Nodo;
use App\User;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $nodo = auth()->user()->dinamizador->nodo->id;
        // $user = User::whereHas('gestor.nodo', function ($query) use ($nodo) {
        //         $query->where('id', $nodo);
        //     })->orWhereHas('infocenter.nodo', function ($query) use ($nodo) {
        //         $query->where('id', $nodo);
        //     })->orWhereHas('ingreso.nodo', function ($query) use ($nodo) {
        //         $query->where('id', $nodo);
        //     })->pluck('id');
        // dd($nododinamizador);
        // 



        // $user = auth()->user()->dinamizador->nodo->infocenter->user;
        // dd($user);

      switch ( Session::get('login_role') ) {
        case 'Dinamizador':
          return view('home.dinamizador');
          break;

        case 'Gestor':
          return view('home.home');
          break;

        default:
          // code...
          break;
      }

        
        // $value = Session::get('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d');
         // session()->put('login_role', 'value');

         //    $value = Session::all();

         //    dd($value);

        // if (auth()->user()->hasRole('Infocenter')) {
        // $nodo = Nodo::where('id','=',auth()->user()->infocenter->nodo_id)->first()->nombre;


        // $nodo = Nodo::userNodo(auth()->user()->infocenter->nodo_id)->first()->nombre;


        // $user  = auth()->user()->infocenter->nodo_id;

       //  $filtered = collect(auth()->user()->roles)->firstWhere('name', 'Administrador')->name;
       // // $filtered->all();
       //  dd($filtered);
       //      // dd($administradores);
       //      return view('home.home');
        // } else if(auth()->user()->hasRole('Dinamizador')){
        //     echo "Infocenter";
        // }else{
        //   abort(403);
        // }
        //

    }
}
