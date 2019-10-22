<?php

namespace App\Http\Controllers;

use Alert;
use App\Http\Requests\LineaFormRequest;
use App\Models\LineaTecnologica;
use App\Repositories\Datatables\LineaTecnologicaDatatables;
use App\Repositories\Repository\LineaRepository;
use App\User;
use Illuminate\Http\Request;

class LineaController extends Controller
{
    private $lineaRepository;

    public function __construct(LineaRepository $lineaRepository)
    {

        $this->middleware([
            'auth',
            'role_session:Administrador|Dinamizador|Gestor|Talento',
        ])->except('getAllLineasForNodo');
        $this->setLineaRepository($lineaRepository);

    }

    /**
     * Asigna un valor a $lineaRepository
     * @param object $lineaRepository
     * @return void
     * @author devjul
     */
    private function setLineaRepository($lineaRepository)
    {
        $this->lineaRepository = $lineaRepository;
    }

    /**
     * Retorna el valor de $lineaRepository
     * @return object
     * @author devjul
     */
    private function getLineaRepository()
    {
        return $this->lineaRepository;
    }

    /*=====================================================================
    =            metodo API para consultar las lineas por nodo            =
    =====================================================================*/

    public function getAllLineasForNodo($nodo = '1')
    {
        if (request()->ajax()) {
            return response()->json([
                'lineasForNodo' => $this->getLineaRepository()->getAllLineaNodo($nodo),
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
    public function index(LineaTecnologicaDatatables $lineaTecnologicaDatatables)
    {
        $this->authorize('index', LineaTecnologica::class);

        if (request()->ajax()) {
            return $lineaTecnologicaDatatables->indexDatatable();
        }
        return view('lineas.index');
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

        $linea = $this->getLineaRepository()->store($request);

        if ($linea != null) {
            Alert::success('Registro Exitoso', "La Linea {$linea->nombre} ha sido creado satisfactoriamente.", "success");
        } else {
            Alert::error('Registro Erróneo', "La linea  no se ha creado.", "error");
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
        $linea = $this->getLineaRepository()->findLineaForShow($linea);

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
        $linea = LineaTecnologica::with(['nodos'])->findOrFailLinea($linea);

        $this->authorize('edit', $linea);
        return view('lineas.edit', [
            'linea' => $linea,
        ]);
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

        $linea = $this->getLineaRepository()->update($linea, $request);

        if ($linea != null) {
            Alert::success('Modificación Exitosa', "La Linea {$linea->nombre} ha sido  modificado exitosamente.", "success");

        } else {
            Alert::error("La Linea no se ha modificado.", 'Modificación Errónea', "error");
        }
        return redirect('lineas');
    }

}
