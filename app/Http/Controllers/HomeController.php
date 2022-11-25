<?php

namespace App\Http\Controllers;

use App\Models\Nodo;
use App\Models\Dinamizador;
use App\Models\Gestor;
use App\Models\Talento;
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
        case User::IsActivador() :

            $dinamizadoresActivos = Dinamizador::with('user')
            ->whereHas('user', function($query){
                $query->where('estado', User::IsActive());
            })->get()->count();


            $gestoresActivos = Gestor::with('user')->whereHas('user', function($query){
                $query->where('estado', User::IsActive());
            })->get()->count();

            $talentosActivos = Talento::with('user')->get()->count();

            return view('home.administrador',[
              'countNodos' => Nodo::countNodos(),
              'countDinamizadoresActivos' => $dinamizadoresActivos,
              'totalDinamizadores' => Dinamizador::with('user')->get()->count(),
              'countGestoresActivos' =>  $gestoresActivos,
              'totalGestores' =>  Gestor::with('user')->get()->count(),
              'countTalentosActivos' =>  $talentosActivos,
              'totalTalentos' => Talento::with('user')->get()->count(),
              'administradores' => User::role(User::IsActivador())->select('documento','nombres','apellidos')->get(),
            ]);
        case User::IsDinamizador():
        // $datos = array('actualizacion' => 114215, 'spot' => 123);
          return view('home.home');
          break;

        case User::IsExperto():
          return view('home.gestor');
          break;

        case User::IsDesarrollador():
          return view('home.desarrollador');
          break;

        case User::IsArticulador():
          return view('home.home');
          break;
        default:
          return view('home.home');
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

       //  $filtered = collect(auth()->user()->roles)->firstWhere('name', 'Activador')->name;
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
