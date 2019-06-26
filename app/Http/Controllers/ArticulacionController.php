<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sector;
use App\Models\Departamento;
use App\Models\Talento;

class ArticulacionController extends Controller
{

  // private $grupoInvestigacionRepository;
  // private $empresaRepository;

  public function __construct()
  {
    // $this->grupoInvestigacionRepository = $grupoInvestigacionRepository;
    // $this->empresaRepository = $empresaRepository;
    $this->middleware([
      'auth',
    ]);
  }

  // Código de la articulación
  //ART190624-1632111
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    switch (auth()->user()->rol()->first()->nombre) {
      case 'Administrador':

      break;
      case 'Dinamizador':

      break;
      case 'Gestor':
      return view('articulaciones.gestor.index');
      break;

      default:
      // code...
      break;
    }
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    if (auth()->user()->rol()->first()->nombre == 'Gestor') {
      return view('articulaciones.gestor.create');
    }
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    // $ip = \Request::getClientIp(true);
    // dd($ip);
    dd(request());
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
