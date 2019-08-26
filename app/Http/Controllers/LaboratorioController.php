<?php

namespace App\Http\Controllers;

use App\Models\Laboratorio;
use App\Repositories\Repository\LaboratorioRepository;
use App\Repositories\Repository\LineaRepository;
use App\User;
use Illuminate\Http\Request;
use Repositories\Repository\NodoRepository;

class LaboratorioController extends Controller
{

    public $laboratorioRepository;

    public function __construct(LaboratorioRepository $laboratorioRepository)
    {
        $this->middleware('auth');
        $this->laboratorioRepository = $laboratorioRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('laboratorio.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(NodoRepository $nodoRepository, LineaRepository $lineaRepository)
    {
        // $user = auth()->user()->getRoleNames();
        $this->authorize('create', Laboratorio::class);
        // $user = collect(auth()->user()->getRoleNames())->contains(User::IsAdministrador());
        // dd($user );
        // $this->authorize('create', User::class);
        // if (session()->get('login_role') == User::IsAdministrador()) {
        //     $nodos = $nodoRepository->getSelectNodo();
        //     return view('laboratorio.administrador.create', [
        //         'nodos' => $nodos,
        //     ]);
        // } else if (session()->get('login_role') == User::IsDinamizador()) {
        //     // $nodo   = auth()->user()->dinamizador->nodo->id;
        //     // $nodo   = auth()->user()->dinamizador->nodo->getLaboratorioIds();
        //     $nodo   = auth()->user()->dinamizador->nodo->laboratorios->pluck('id');
        //     dd($nodo);
        //     $lineas = $lineaRepository->getAllLineaNodo($nodo);
        //     return view('laboratorio.dinamizador.create', [
        //         'lineas' => $lineas,
        //     ]);
        // }
        // 
        return view('laboratorio.create');

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
     * @param  \App\Laboratorio  $laboratorio
     * @return \Illuminate\Http\Response
     */
    public function show(Laboratorio $laboratorio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laboratorio  $laboratorio
     * @return \Illuminate\Http\Response
     */
    public function edit(Laboratorio $id)
    {
        $this->authorize('edit',$id);

        return $id;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laboratorio  $laboratorio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Laboratorio $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laboratorio  $laboratorio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Laboratorio $laboratorio)
    {
        //
    }
}
