<?php

namespace App\Http\Controllers\Nodo;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Nodo\DataTables\NodoDataTable;
use App\Http\Requests\NodoFormRequest;
use App\Repositories\Repository\DepartamentoRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Repositories\Repository\NodoRepository;

class NodoController extends Controller
{

    public $nodoRepository;
    public $departamentoRepository;

    public function __construct(NodoRepository $nodoRepository, DepartamentoRepository $departamentoRepository)
    {
        // $this->middleware('auth');
        $this->middleware('role_session:Administrador|Dinamizador|Talento');
        $this->nodoRepository         = $nodoRepository;
        $this->departamentoRepository = $departamentoRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(NodoDataTable $dataTable)
    {
        switch (session()->get('login_role') && auth()->user()->hasAnyRole([User::IsAdministrador()])) {
            case User::IsAdministrador():
                if (request()->ajax()) {
                    return datatables()->of($this->nodoRepository->getAlltNodo())
                        ->addColumn('detail', function ($data) {
                            $button = '<a class="waves-effect waves-light btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver Lineas" onclick="" data-tooltip-id="b24478ad-402e-0583-7a3a-de01b3861e9a"><i class="material-icons">info_outline</i></a>';

                            return $button;
                        })
                        ->addColumn('edit', function ($data) {
                            $button = '<a href="' . route("nodo.edit", $data->id) . '" class="waves-effect waves-light btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';

                            return $button;
                        })
                        ->rawColumns(['detail', 'edit'])
                        ->make(true);
                    

                    // return $dataTable->before(function (\Yajra\DataTables\DataTableAbstract $dataTable) {
                    //     return $dataTable->addColumn('detail', function ($data) {
                    //         $button = '<a class="waves-effect waves-light btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver Lineas" onclick="" data-tooltip-id="b24478ad-402e-0583-7a3a-de01b3861e9a"><i class="material-icons">info_outline</i></a>';

                    //             return $button;
                    //         })->addColumn('edit', function ($data) {
                    //             $button = '<a href="' . route("nodo.edit", $data->id) . '" class="waves-effect waves-light btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';

                    //             return $button;
                    //         })
                    //         ->rawColumns(['detail','edit']);
                    //     })
                        
                    //     ->withHtml(function (\Yajra\DataTables\Html\Builder $builder) {
                    //         $builder->columns($this->getColumns())
                    //                     ->parameters([
                    //                            'dom'          => 'Bfrtip',
                    //                            'buttons'      => ['export', 'print', 'reset', 'reload'],
                    //                      ]);
                    //     })  
                    //     ->render('nodos.administrador.index');
                }
                return view('nodos.administrador.index');

                break;
            default:
                abort('404');
                break;
        }

    }

    protected function getColumns()
    {
        return [
            'id',
            'nombres',
            'created_at',
            'updated_at',
        ];
    }

    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->parameters([
                'dom'     => 'Bfrtip',
                'buttons' => ['export', 'print', 'reset', 'reload'],
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('nodos.administrador.create', [
            'lineas'        => $this->nodoRepository->getAllLineas(),
            'regionales'    => $this->nodoRepository->getAllRegionales(),
            'departamentos' => $this->departamentoRepository->getAllDepartamentos(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NodoFormRequest $request)
    {
        //metodo para guardad
        $nodoCreate = $this->nodoRepository->storeNodo($request);

        if ($nodoCreate == true) {

            alert()->success('Registro Exitoso.', 'El nodo ha sido creado satisfactoriamente');
        } else {
            alert()->error('Registro Erróneo.', 'El nodo no se ha creado.');
        }
        return redirect()->route('nodo.index');
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
        // $nodo = $this->nodoRepository->findByid($id);
        return view('nodos.administrador.edit', [
            'entidad'       => $this->nodoRepository->findByid($id),
            'lineas'        => $this->nodoRepository->getAllLineas(),
            'regionales'    => $this->nodoRepository->getAllRegionales(),
            'departamentos' => $this->departamentoRepository->getAllDepartamentos(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NodoFormRequest $request, $id)
    {

        $entidadNodo = $this->nodoRepository->findById($id);
        // dd($nodo);
        $nodoUdate = $this->nodoRepository->update($request, $entidadNodo);

        if ($nodoUdate == true) {

            alert()->success('Modificación Exitoso.', 'El nodo ha sido modificado satisfactoriamente');
        } else {
            alert()->error('Modificación Erróneo.', 'El nodo no se ha modificado.');
        }
        return redirect()->route('nodo.index');
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
