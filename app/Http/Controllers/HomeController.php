<?php

namespace App\Http\Controllers;

use App\Models\Nodo;
use App\Models\Idea;

use App\User;
use Illuminate\Support\Facades\Session;
use App\Repositories\Repository\ProyectoRepository;

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
        $users = User::query()
        ->join('model_has_roles', function ($join) {
            $join->on('users.id', '=', 'model_has_roles.model_id')
                ->where('model_has_roles.model_type', User::class);
        })
        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id');
        switch (Session::get('login_role')) {
            case User::IsActivador():
                $dinamizadores = User::query()
                ->join('model_has_roles', function ($join) {
                    $join->on('users.id', '=', 'model_has_roles.model_id')
                        ->where('model_has_roles.model_type', User::class);
                })
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')->role(User::IsDinamizador());
                $admin = User::query()
                ->join('model_has_roles', function ($join) {
                    $join->on('users.id', '=', 'model_has_roles.model_id')
                        ->where('model_has_roles.model_type', User::class);
                })
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')->role(User::IsAdministrador());
                $expertos = User::query()
                ->join('model_has_roles', function ($join) {
                    $join->on('users.id', '=', 'model_has_roles.model_id')
                        ->where('model_has_roles.model_type', User::class);
                })
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')->role(User::IsExperto());
                $talentos = User::query()
                ->join('model_has_roles', function ($join) {
                    $join->on('users.id', '=', 'model_has_roles.model_id')
                        ->where('model_has_roles.model_type', User::class);
                })
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')->role(User::IsTalento());
                return view('home.administrador', [
                    'countNodos' => Nodo::countNodos(),
                    'totalDinamizadores' => $dinamizadores->get()->count(),
                    'countDinamizadoresActivos' => $dinamizadores->where('estado', User::IsActive())->get()->count(),
                    'totalGestores' =>  $expertos->get()->count(),
                    'countGestoresActivos' =>  $expertos->where('estado', User::IsActive())->get()->count(),
                    'totalTalentos' => $talentos->get()->count(),
                    'countTalentosActivos' =>  $talentos->where('estado', User::IsActive())->get()->count(),
                    'administradores' => $admin->select('documento', 'nombres', 'apellidos')->get(),
                ]);
            case User::IsDinamizador():
                $expertos = User::ConsultarFuncionarios(request()->user()->getNodoUser(), User::IsExperto())->get();
                return view('home.home', [
                    'expertos' => $expertos,
                    'ideas_sin_pbt' => Idea::ConsultarIdeasAprobadasEnComite(request()->user()->getNodoUser(), null)->get()->count(),
                    'proyectos_limite_inicio' => $this->proyectoRepository->selectProyectosLimiteInicio(request()->user()->getNodoUser(), null)->count(),
                    'proyectos_limite_planeacion' => $this->proyectoRepository->selectProyectosLimitePlaneacion(request()->user()->getNodoUser(), null)->groupBy('codigo_proyecto')->get()->count()
                ]);
                break;
            case User::IsExperto():
                return view('home.home', [
                    'ideas_sin_pbt' => Idea::ConsultarIdeasAprobadasEnComite(request()->user()->getNodoUser(), request()->user()->id)->get()->count(),
                    'proyectos_limite_inicio' => $this->proyectoRepository->selectProyectosLimiteInicio(request()->user()->getNodoUser(), request()->user()->id)->count(),
                    'proyectos_limite_planeacion' => $this->proyectoRepository->selectProyectosLimitePlaneacion(request()->user()->getNodoUser(), request()->user()->id)->groupBy('codigo_proyecto')->get()->count()
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
    }
}
