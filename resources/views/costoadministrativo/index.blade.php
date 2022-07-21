@extends('layouts.app')
@section('meta-title', 'Costo Administrativo ')
@section('meta-content', 'Costo Administrativo')
@section('meta-keywords', 'Costo Administrativo')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s8 m8 l9">
                        <h5 class="left-align">
                            <a class="footer-text left-align" href="{{route('costoadministrativo.index')}}">
                                <i class="material-icons arrow-l">
                                    arrow_back
                                </i>
                            </a>
                            Costos Administrativos
                        </h5>
                    </div>
                    <div class="col s4 m4 l3 rigth-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li class="active">Costos Administrativos</li>
                        </ol>
                      </div>
                </div>
                <div class="card ">

                    <div class="card-content">
                    @if(session()->has('login_role') && session()->get('login_role') == App\User::IsActivador())
                        <div class="row">
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <div class="center">
                                        <span class="card-title center-align">
                                            Costos Administrativos Fijos Mensuales {{config('app.name')}} {{Carbon\Carbon::now()->year}}
                                        </span>
                                        <i class="material-icons">
                                            settings_input_svideo
                                        </i>
                                    </div>
                                </div>
                            </div>
                            <div class="divider">
                            </div>
                            <div class="row">
                                    <div class="col s12 m12 l12">
                                        <label class="active" for="selectnodo">Nodo <span class="red-text">*</span></label>
                                        <select class="js-states browser-default select2 " onchange="selectCostoAdministrativoNodo.selectCostoAdministrativoForNodo()" tabindex="-1" style="width: 100%" id="selectnodo" >
                                            <option value="">Seleccione nodo</option>
                                            @foreach($nodos as $nodo)
                                              <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <br>

                                <table class="display responsive-table centered cell-border display compact" id="costoadministrativo_administrador_table"  style="width:100%">

                                    <thead>
                                        <tr>
                                            <th rowspan="2">Nodo</th>
                                            <th rowspan="2">Nombre</th>
                                            <th colspan="3">Costos</th>
                                        </tr>
                                        <tr>
                                            <th>Costos Administrativos por mes</th>
                                            <th>Costos Administrativos por día</th>
                                            <th>Costos Administrativos por hora</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th colspan="2" style="text-align:right"></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>

                                    </tr>
                                </tfoot>
                                </table>
                        </div>
                    @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsDinamizador())
                        <div class="row">
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <div class="center-align">
                                        <span class="card-title center-align">
                                            Costos Administrativos Fijos Mensuales Tecnopaque Nodo {{\NodoHelper::returnNameNodoUsuario()}} {{Carbon\Carbon::now()->year}}
                                        </span>
                                        <i class="material-icons">
                                            settings_input_svideo
                                        </i>
                                    </div>
                                </div>

                            </div>
                            <div class="divider">
                            </div>
                            <br>
                            <table class="display responsive-table centered cell-border display compact" id="costoadministrativo_dinamizador_table1" style="width:100%">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Nodo</th>
                                        <th rowspan="2">Nombre</th>
                                        <th colspan="3">Costos</th>
                                        <th rowspan="2">Editar</th>
                                    </tr>
                                    <tr>
                                        <th>Costos Administrativos por mes</th>
                                        <th>Costos Administrativos por día</th>
                                        <th>Costos Administrativos por hora</th>

                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" style="text-align:right"></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div  class="modal detalleUsers">
  <div class="modal-content">
    <center><h4 class="center-aling"></h4></center>
    <div class="divider"></div>
    <div class="titulo_users"></div>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-action modal-close waves-effect waves-yellow btn-flat ">Cerrar</a>
  </div>
</div>
@endsection
