<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Actividad;
use App\User;

class CostoController extends Controller
{

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $costo = Actividad::find(38);
    $costo = $costo->usoinfraestructuras;
    $costosEquipos = 0;
    foreach ($costo as $key => $value) {
      $costosEquipos = $value->usoequipos->sum('pivot.costo_equipo');
    }

    dd($costosEquipos);
    if ( Session::get('login_role') == User::IsGestor() ) {
      $actividades = Actividad::ConsultarActividades()->where('gestor_id', auth()->user()->gestor->id)->get()->pluck('proyecto', 'id');
      return view('costos.gestor.index', [
        'actividades' => $actividades
      ]);
    }
  }

  /**
   * undocumented function summary
   *
   * Undocumented function long description
   *
   * @param type var Description
   * @return return type
   */
  public function costosDeUnaActividad($id)
  {
    $costos = Actividad::find($id);
    $costos = $costos->usoinfraestructuras;
    return response()->json([
      'costos' => $costos
    ]);
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
