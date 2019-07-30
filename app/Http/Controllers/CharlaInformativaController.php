<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CharlaInformativaFormRequest;
use Illuminate\Support\Facades\{Session, Validator};
use App\{User, Models\CharlaInformativa};
use App\Repository\Repositories\{CharlaInformativaRepository};

class CharlaInformativaController extends Controller
{

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  /**
   * Objeto de la clase CharlaInformativaRepository
   * @var object
   */
  private $charlaInformativaRepository;
  public function index()
  {
    if ( Session::get('login_role') == User::IsInfocenter() ) {
      return view('charlas.infocenter.index');
    } else if ( Session::get('login_role') == User::IsDinamizador() ) {

    } else {

    }
  }
  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view('charlas.infocenter.create');
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(CharlaInformativaFormRequest $request)
  {
    $store = $this->charlaInformativoRepository->storeCharlaInformativaRepository($request);
    if ($store) {
      Alert::success('Registro Exitoso!', 'La Charla Informativa se ha registrado satisfactoriamente')->showConfirmButton('Ok!', '#3085d6');
      return redirect('charla');
    } else {
      Alert::error('Registro Erróneo!', 'La Charla Informativa no se ha registrado')->showConfirmButton('Ok!', '#3085d6');
      return back()->withInput();
    }
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
