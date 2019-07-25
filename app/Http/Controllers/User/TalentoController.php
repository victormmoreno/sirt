<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Talento;
use App\Repositories\Repository\UserRepository\TalentoRepository;
use App\Repositories\Repository\UserRepository\UserRepository;
use App\User;
use Illuminate\Http\Request;

class TalentoController extends Controller
{
    public $talentoRepository;
    public $userRepository;

    public function __construct(TalentoRepository $talentoRepository, UserRepository $userRepository)
    {
        $this->middleware('auth');
        $this->talentoRepository = $talentoRepository;
        $this->userRepository    = $userRepository;
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
            })->rawColumns(['add_articulacion', 'add_proyecto'])->make(true);
        }
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
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of($this->talentoRepository->getAllTalentos())
                ->addColumn('detail', function ($data) {

                    $button = '<a class="  btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver Detalle" href="#modal1" onclick="UserAdministradorInfocenter.detalleInfocenter(' . $data->id . ')"><i class="material-icons">info_outline</i></a>';

                    return $button;
                })
                
                ->editColumn('estado', function ($data) {
                    if ($data->estado == User::IsActive()) {
                        if ($data->id == auth()->user()->id) {
                            return $data->estado = 'Habilitado <span class="new badge" data-badge-caption="ES USTED"></span>';
                        }
                        return $data->estado = 'Habilitado';
                    } else {
                        return $data->estado = 'Inhabilitado ';
                    }
                })
                ->rawColumns(['detail', 'estado'])
                ->make(true);
        }

      
        return view('users.administrador.talento.index', [
            'nodos' => $this->userRepository->getAllNodos(),
        ]);
    }

    /*============================================================================
    =            metodo para mostrar todos los usuarios en datatables            =
    ============================================================================*/
    
    public function getUsersTalentosForDatatables()
    {
        return datatables()->of($this->talentoRepository->getAllTalentos())
                ->addColumn('detail', function ($data) {

                    $button = '<a class="  btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver Detalle" href="#modal1" onclick="UserAdministradorInfocenter.detalleInfocenter(' . $data->id . ')"><i class="material-icons">info_outline</i></a>';

                    return $button;
                })
                
                ->editColumn('estado', function ($data) {
                    if ($data->estado == User::IsActive()) {
                        if ($data->id == auth()->user()->id) {
                            return $data->estado = 'Habilitado <span class="new badge" data-badge-caption="ES USTED"></span>';
                        }
                        return $data->estado = 'Habilitado';
                    } else {
                        return $data->estado = 'Inhabilitado ';
                    }
                })
                ->rawColumns(['detail', 'estado'])
                ->make(true);
    
    }
    
    /*=====  End of metodo para mostrar todos los usuarios en datatables  ======*/
    

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

}
