<?php

namespace App\Http\Controllers;

use App\Models\CostoAdministrativo;
use App\Repositories\Repository\CostoAdministrativoRepository;
use Illuminate\Http\Request;

class CostoAdministrativoController extends Controller
{
    private $costoAdministrativoRepository;

    public function __construct(CostoAdministrativoRepository $costoAdministrativoRepository)
    {
        $this->costoAdministrativoRepository = $costoAdministrativoRepository;
        $this->middleware('auth');
        // abort('403');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $costos = CostoAdministrativo::with(['nodocostosadministrativos'])->get();
        // return $costos;
        return view('costoadministrativo.index');
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

    /**
     * Asigna un valor a $costoAdministrativoRepository
     * @param object $costoAdministrativoRepository
     * @return void
     * @author devjul
     */
    private function setCostoAdministrativoRepository($costoAdministrativoRepository)
    {
        $this->costoAdministrativoRepository = $costoAdministrativoRepository;
    }

    /**
     * Retorna el valor de $costoAdministrativoRepository
     * @return object
     * @author devjul
     */
    private function getCostoAdministrativoRepository()
    {
        return $this->costoAdministrativoRepository;
    }
}
