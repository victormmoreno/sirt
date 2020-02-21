<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\{Talento, Gestor, Nodo};
use App\Repositories\Repository\UserRepository\TalentoRepository;
use App\Repositories\Repository\UserRepository\UserRepository;
use App\User;
use Illuminate\Http\Request;
use App\Repositories\Datatables\UserDatatables;

class TalentoController extends Controller
{
    public $talentoRepository;
    public $userRepository;
    public $userdatables;

    public function __construct(TalentoRepository $talentoRepository, UserRepository $userRepository, UserDatatables $userdatables)
    {
        $this->middleware('auth');
        $this->talentoRepository = $talentoRepository;
        $this->userRepository    = $userRepository;
        $this->userdatables = $userdatables;
    }

    /**
     * Consulta la edad de un talento
     *
     * @param int $id id del talento
     * @return int
     * @author dum
     */
    public function getEdad($id)
    {
        $talento = Talento::find($id);
        $edad = $talento->user->fechanacimiento->age;
        return $edad;
    }

    public function datatableTalentosDeTecnoparque()
    {
        if (request()->ajax()) {
            $talentos = Talento::ConsultarTalentosDeTecnoparque()->get();
            return datatables()->of($talentos)
                ->addColumn('add_articulacion', function ($data) {
                    $add = '<a onclick="addTalentoArticulacion(' . $data->id . ')" class="btn blue m-b-xs"><i class="material-icons">done</i></a>';
                    return $add;
                })->addColumn('add_proyecto', function ($data) {
                    $add = '<a onclick="addTalentoProyecto(' . $data->id . ')" class="btn blue m-b-xs"><i class="material-icons">done</i></a>';
                    return $add;
                })->addColumn('add_propiedad', function ($data) {
                    $propiedad = '<a onclick="addPersonaPropiedad(' . $data->user_id . ')" class="btn blue m-b-xs"><i class="material-icons">done</i></a>';
                    return $propiedad;
                })->rawColumns(['add_articulacion', 'add_proyecto', 'add_propiedad'])->make(true);
        }
        abort('404');
    }



    public function consultarUnTalentoPorId($id)
    {
        return response()->json([
            'talento' => Talento::ConsultarTalentoPorId($id)->get()->last(),
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {

            $users = $this->talentoRepository->getAllTalentos()
                        ->orderby('users.created_at', 'desc')
                        ->get();

            return $this->userdatables->datatableUsers($request, $users);
        }

        switch (session()->get('login_role')) {
            case User::IsAdministrador():
                return view('users.administrador.talento.index', [
                    'nodos' => Nodo::SelectNodo()->get(),
                    'view' => 'activos'
                ]);
                break;
            case User::IsDinamizador():
                $gestores = Gestor::ConsultarGestoresPorNodo(auth()->user()->dinamizador->nodo_id)->where('users.estado', User::IsActive())->pluck('nombres_gestor', 'id');
                return view('users.dinamizador.talento.index', [
                    'gestores' => $gestores,
                    'view' => 'activos'
                ]);
                break;

            default:
                abort('403');
                break;
        }
    }

    /*============================================================================
    =            metodo para mostrar todos los usuarios en datatables            =
    ============================================================================*/

    public function getUsersTalentosForDatatables(Request $request)
    {
        if (request()->ajax()) {
            $users = $this->talentoRepository->getAllTalentos()
                ->orderby('users.created_at', 'desc')
                ->get();

            return $this->userdatables->datatableUsers($request, $users);
        }
        abort('404');

    }

    /*=====  End of metodo para mostrar todos los usuarios en datatables  ======*/

    public function talentosTrash(Request $request)
    {
        switch (session()->get('login_role')) {
            case User::IsAdministrador():            
                return view('users.administrador.talento.index', [
                    'nodos' => Nodo::SelectNodo()->get(),
                    'view' => 'inactivos'
                    ]);
                break;
                
            case User::IsGestor():            
                return view('users.gestor.talento.index', ['view' => 'inactivos']);
                break;
            default:
                abort('404');
                break;
        }
    }


    public function getDatatablesUsersTalentosByDatatablesTrash(Request $request, $anio)
    {
        if (request()->ajax()) {

            if (session()->get('login_role') == User::IsGestor()) {
                $auth = auth()->user()->gestor->id;
                $nodo = auth()->user()->gestor->nodo_id;
                $users = $this->userRepository->getUsersTalentosByProject($nodo, $auth, $anio)->onlyTrashed()->groupBy('users.id')
                ->get();

                return $this->userdatables->datatableUsers($request, $users);
            } else if (session()->get('login_role') == User::IsDinamizador()) {
                $nodo = auth()->user()->dinamizador->nodo_id;
                $users = $this->userRepository->getUsersTalentosByProject($nodo, $auth = null, $anio)->onlyTrashed()->groupBy('users.id')
                ->get();
                return $this->userdatables->datatableUsers($request, $users);
            }
        }
        abort('404');
    }
        
}
