<?php

namespace App\Http\Controllers;

use App\Models\Nodo;
use App\Models\Dinamizador;
use App\Models\Gestor;
use App\Models\Talento;
use App\Models\Idea;
use App\Models\Proyecto;
use App\User;
use Illuminate\Support\Facades\Session;
use App\Repositories\Repository\ProyectoRepository;
use Carbon\Carbon;

class HomeController extends Controller
{
  public $proyectoRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProyectoRepository $proyectoRepository)
    {
        $this->middleware(['auth']);
        $this->proyectoRepository = $proyectoRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      // $limite_inicio = Carbon::now()->subDays(config('app.proyectos.duracion.inicio'));
      // dd($limite_inicio);
      switch ( Session::get('login_role') ) {
        case User::IsActivador() :

            $dinamizadores = User::role(User::IsDinamizador());
            $admin = User::role(User::IsAdministrador());

            $expertos = User::role(User::IsExperto());

            $talentos = User::role(User::IsTalento());

            return view('home.administrador',[
              'countNodos' => Nodo::countNodos(),
              'countDinamizadoresActivos' => $dinamizadores->where('estado', User::IsActive())->get()->count(),
              'totalDinamizadores' => $dinamizadores->get()->count(),
              'countGestoresActivos' =>  $expertos->where('estado', User::IsActive())->get()->count(),
              'totalGestores' =>  $expertos->get()->count(),
              'countTalentosActivos' =>  $talentos->where('estado', User::IsActive())->get()->count(),
              'totalTalentos' => $talentos->get()->count(),
              'administradores' => $admin->select('documento','nombres','apellidos')->get(),
            ]);
        case User::IsDinamizador():
          // dd($this->proyectoRepository->selectProyectosLimitePlaneacion(request()->user()->getNodoUser(), null)->groupBy('codigo_actividad')->get()->count());
          $expertos = User::with(['gestor'])
          ->role(User::IsExperto())
          ->nodoUser(User::IsExperto(), request()->user()->getNodoUser())
          ->stateDeletedAt('si')
          ->orderBy('users.created_at', 'desc')
          ->get();
          return view('home.home', [
            'expertos' => $expertos,
            'ideas_sin_pbt' => Idea::ConsultarIdeasAprobadasEnComite(request()->user()->getNodoUser(), null)->get()->count(),
            'proyectos_limite_inicio' => $this->proyectoRepository->selectProyectosLimiteInicio(request()->user()->getNodoUser(), null)->count(),
            'proyectos_limite_planeacion' => $this->proyectoRepository->selectProyectosLimitePlaneacion(request()->user()->getNodoUser(), null)->groupBy('codigo_actividad')->get()->count()
          ]);
          break;
        //   if (session()->get('login_role') == User::IsExperto()) {
        //     $ideas = );
        // } else {
        //     $ideas = Idea::ConsultarIdeasAprobadasEnComite($nodo, $id_experto)->get();
        // }
        case User::IsExperto():
          return view('home.home', [
            'ideas_sin_pbt' => Idea::ConsultarIdeasAprobadasEnComite(request()->user()->getNodoUser(), request()->user()->id)->get()->count(),
            'proyectos_limite_inicio' => $this->proyectoRepository->selectProyectosLimiteInicio(request()->user()->getNodoUser(), request()->user()->gestor->id)->count(),
            'proyectos_limite_planeacion' => $this->proyectoRepository->selectProyectosLimitePlaneacion(request()->user()->getNodoUser(), request()->user()->gestor->id)->groupBy('codigo_actividad')->get()->count()
          ]);
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
