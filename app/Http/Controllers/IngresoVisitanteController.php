<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Requests\VisitanteFormRequest;
use Illuminate\Support\Facades\{Session};
// use App\Repositories\Repository\{VisitanteRepository};
use App\{User, Models\Ingreso, Models\TipoVisitante};
use Alert;

class IngresoVisitanteController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    if ( Session::get('login_role') == User::IsIngreso() ) {
      return view('ingreso.ingreso.index');
    } else if ( Session::get('login_role') == User::IsDinamizador() ) {
      return view('ingreso.dinamizador.index');
    } else {
      return view('ingreso.administrador.index');
    }
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
