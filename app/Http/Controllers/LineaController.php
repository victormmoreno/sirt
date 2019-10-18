<?php

namespace App\Http\Controllers;

use Alert;
use App\Http\Requests\LineaFormRequest;
use App\Models\LineaTecnologica;
use App\Repositories\Repository\LineaRepository;
use App\User;
use DataTables;
use Illuminate\Http\Request;

class LineaController extends Controller
{
    private $lineaRepository;

    public function __construct(LineaRepository $lineaRepository)
    {
        $this->middleware(['auth']);
        $this->middleware(['role_session:Administrador|Dinamizador|Gestor|Talento'])->except('getAllLineasForNodo');
        $this->lineaRepository = $lineaRepository;
    }

    /*=====================================================================
    =            metodo API para consultar las lineas por nodo            =
    =====================================================================*/

    public function getAllLineasForNodo($nodo = '1')
    {
        if (request()->ajax()) {
            return response()->json([
                'lineasForNodo' => $this->lineaRepository->getAllLineaNodo($nodo),
            ]);
        } else {
            abort('403');
        }
    }

    /*=====  End of metodo API para consultar las lineas por nodo  ======*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return DataTables::eloquent(LineaTecnologica::select(['id', 'nombre', 'slug', 'abreviatura', 'descripcion']))
                ->addColumn('action', function ($data) {
                    $button = '<a href="' . route("lineas.edit", $data->slug) . '" class="waves-effect waves-light btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';
                    return $button;
                })
                ->addColumn('show', function ($data) {
                    $button = '<a href="' . route("lineas.show", $data->slug) . '" class="  btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="ver más"><i class="material-icons">info_outline</i></a>';
                    return $button;
                })
                ->editColumn('descripcion', function ($data) {
                    return !empty($data->descripcion) ? $data->descripcion : 'No registra';
                })
                ->rawColumns(['action', 'show', 'descripcion'])
                ->toJson();
        }
        $this->authorize('index', LineaTecnologica::class);
        $relations = [
                    'sublineas', 
                    'gestores', 'gestores.user',
                    'laboratorios'
                ];
        switch (session()->get('login_role')) {
            case User::IsAdministrador():
                return view('lineas.index');
                break;
            case User::IsDinamizador():

                $nodo = auth()->user()->dinamizador->nodo->id;
                $linea = $this->lineaRepository->lineasWithRelations($relations)->whereHas('nodos', function ($query) use ($nodo) {
                    $query->where('nodos.id', $nodo);
                })->get();

                return view('lineas.index');
                break;

            case User::IsGestor():

                $lineatecnologica = auth()->user()->gestor->lineatecnologica->id;
                $linea            = $this->lineaRepository->lineasWithRelations($relations)->find($lineatecnologica);
                return $linea;
                break;
            default:
                abort('403');
                break;
        }

    }



    /**
     * Show the form for creating a new resource.s
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', LineaTecnologica::class);
        return view('lineas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LineaFormRequest $request)
    {
        $this->authorize('store', User::class);

        $linea = LineaTecnologica::create([
            "abreviatura" => $request->input('txtabreviatura'),
            "nombre"      => $request->input('txtnombre'),
            "slug"        => str_slug($request->input('txtnombre'), '-'),
            "descripcion" => $request->input('txtdescripcion'),
        ]);

        if ($linea != null) {
            Alert::success("La Linea {$linea->nombre} ha sido creado satisfactoriamente.", 'Registro Exitoso', "success");
        } else {
            Alert::error("La linea  no se ha creado.", 'Registro Erróneo', "error");
        }
        return redirect('lineas');
    }

    /**
     * Show the form for show the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function show($linea)
    {
        $linea = $this->lineaRepository->findLineaForShow($linea);

        $this->authorize('show', $linea);
        
        return view('lineas.show', ['linea' => $linea]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($linea)
    {
       $linea =  LineaTecnologica::with(['lineastecnologicasnodos'])->findOrFailLinea($linea);
       
        $this->authorize('edit', $linea);
        return view('lineas.edit', compact('linea'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LineaFormRequest $request, $id)
    {
        $linea = LineaTecnologica::findOrFail($id);

        $this->authorize('update', $linea);

        if ($linea != null) {
            $linea->abreviatura = $request->input('txtabreviatura');
            $linea->nombre      = $request->input('txtnombre');
            $linea->slug        = str_slug($request->input('txtnombre'), '-');
            $linea->descripcion = $request->input('txtdescripcion');
            $linea->update();

            Alert::success("La Linea {$linea->nombre} ha sido  modificado exitosamente.", 'Modificación Exitosa', "success");

        } else {
            Alert::error("La Linea no se ha modificado.", 'Modificación Errónea', "error");
        }
        return redirect('lineas');
    }

}
