<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArticulacionPbt;
use App\Models\Fase;   
use App\Models\Entidad;
use App\Models\AlcanceArticulacion;
use App\Models\TipoArticulacion;

class ArticulacionPbtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fases = Fase::orderBy('nombre')
       ->whereNotIn('id', [Fase::IsPlaneacion()])
        ->pluck('id', 'nombre');
        // if (\Session::get('login_role') == User::IsAdministrador()) {
        //     return view('ideas.infocenter.index', ['fases' => $fases]);
        // } else if (\Session::get('login_role') == User::IsDinamizador()) {
        //     return view('ideas.articulador.index', ['fases' => $fases]);
        // } else if (\Session::get('login_role') == User::IsArticulador()) {
        //     return view('ideas.articulador.index', ['fases' => $fases]);
        // } else {
            $nodos = Entidad::has('nodo')->with('nodo')->get()->pluck('nombre', 'nodo.id');
            $fases = Fase::orderBy('id')->whereNotIn('id', [Fase::IsPlaneacion()])->pluck('nombre', 'id');
            $alcances = AlcanceArticulacion::orderBy('nombre')->pluck('nombre', 'id');
            $tipoarticulaciones = TipoArticulacion::orderBy('nombre')->pluck('nombre', 'id');
            return view('articulacionespbt.index', ['nodos' => $nodos, 'fases' => $fases, 'alcances' => $alcances, 'tipoarticulaciones' => $tipoarticulaciones]);
        // }
        
    }

    public function datatableIndexFiltros(Request $request)
    {
        switch (\Session::get('login_role')) {
            case User::IsAdministrador():
                $nodo = $request->filter_nodo;
                break;
            case User::IsDinamizador():
                $nodo = auth()->user()->dinamizador->nodo_id;
                break;
            case User::IsArticulador():
                $nodo = auth()->user()->gestor->nodo_id;
                break;
            default:
                return abort('403');
                break;
        }
        $articulaciones = [];
        if (!empty($request->filter_year) && !empty($request->filter_fase) && !empty($request->filter_vieneConvocatoria)) {

            $articulaciones =  ArticulacionPbt::with([
                'fase',
                'tipoarticulacion' => function($query){
                    $query->select('id', 'nombre');
                },
                'alcancearticulacion'=> function($query){
                    $query->select('id', 'nombre');
                },
                'actividad' => function($query){
                    $query->select('id', 'gestor_id', 'nodo_id', 'codigo_actividad', 'nombre', 'fecha_inicio', 'fecha_cierre', 'created_at');
                },
                'actividad.gestor'  => function($query){
                    $query->select('id', 'user_id',  'lineatecnologica_id');
                },
                'actividad.gestor.user' => function($query){
                    $query->select('id', 'documento',  'nombres', 'apellidos');
                },
                'actividad.nodo',
                'actividad.nodo.entidad'=> function($query){
                    $query->select('id', 'ciudad_id',  'nombre', 'slug');
                }
            ])
            ->tipoArticulacion($request->filter_tipo_articulacion)
            ->alcanceArticulacion($request->filter_alcance_articulacion)
            ->nodo($nodo)
            ->starEndDate($request->filter_year)
            ->orderBy('created_at', 'desc')
            ->get();
        }
        return $this->datatableArticulaciones($articulaciones);
    }

    private function datatableArticulaciones($articulaciones)
    {
        return datatables()->of($articulaciones)
        ->editColumn('fase', function ($data) {
            return $data->articulacionpbt->fase->nombre;
        })
        ->editColumn('articulador', function ($data) {
            if (isset($data->actividad->gestor->user->nombres)) {
                return "{$data->actividad->gestor->user->nombres} {$data->actividad->gestor->user->apellidos}";
            }
        })
        // ->editColumn('created_at', function ($data) {
        //     return isset($data->created_at) ? $data->created_at->isoFormat('DD/MM/YYYY') : 'No Registra';
        // })
        // ->editColumn('correo_contacto', function ($data) {
        //     if (isset($data->talento->user->email)) {
        //         return "{$data->talento->user->email}";
        //     } else {
        //         return "{$data->correo_contacto}";
        //     }
        // })
        // ->editColumn('telefono_contacto', function ($data) {
        //     if (isset($data->talento->user->celular)) {
        //         return "{$data->talento->user->celular}";
        //     } else {
        //         return "{$data->telefono_contacto}";
        //     }
        // })
        // ->editColumn('nombre_talento', function ($data) {
        //     if (isset($data->talento->user->nombres)) {
        //         return $data->talento->user->nombres . " " . $data->talento->user->apellidos;
        //     } else {
        //         return "{$data->nombres_contacto} {$data->apellidos_contacto}";
        //     }
        // })
        ->editColumn('nodo', function ($data) {
            return $data->actividad->nodo->entidad->nombre;
        })->addColumn('info', function ($data) {
            $info = '<a class="btn m-b-xs modal-trigger" href='.route('articulaciones.show', $data->id).'>
            <i class="material-icons">search</i>
            </a>';
                return $info;
        })->addColumn('edit', function ($data) {
            $edit = '<a class="btn m-b-xs modal-trigger" href='.route('articulaciones.edit', $data->id).'>
            <i class="material-icons">edit</i>
            </a>';
                return $edit;
        })->rawColumns(['articulador','fase',  'edit',])->make(true);
    }


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
    public function store(Request $request)
    {
        //
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
