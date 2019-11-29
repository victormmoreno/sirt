<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\{Session};
use Illuminate\Http\Request;
use App\User;

class PublicacionController extends Controller
{
  /**
   * Página index para las publicaciones
   *
   * @param type var Description
   * @author dum
   */
  public function index()
  {
    if ( Session::get('login_role') == User::IsDesarrollador() ) {
      return view('publicaciones.desarrollador.index');
    }
  }

  public function create()
  {
    if ( Session::get('login_role') == User::IsDesarrollador() ) {
      return view('publicaciones.desarrollador.create');
    }
  }
}
