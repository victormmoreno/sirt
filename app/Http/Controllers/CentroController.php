<?php

namespace App\Http\Controllers;

use App\Repositories\Repository\CentroRepository;
use Illuminate\Http\Request;

class CentroController extends Controller
{
    public $centroRepository;

    public function __construct(CentroRepository $centroRepository)
    {
        $this->centroRepository = $centroRepository;
    }


    /*=======================================================================================
    =            metodo API para consultar los centros de formacion por regional            =
    =======================================================================================*/
    
    public function getAllCentrosForRegional($regional)
    {
        $centros = $this->centroRepository->getAllCentrosRegional($regional);

        return response()->json([
            'centros' =>  $centros,
        ]);
    }
    
    /*=====  End of metodo API para consultar los centros de formacion por regional  ======*/
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
