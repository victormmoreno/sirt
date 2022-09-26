@extends('layouts.app')
@if(session()->has('login_role') && session()->get('login_role') == App\User::IsActivador())
    @section('meta-title', 'Mantenimientos '. config('app.name'))
@elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsDinamizador())
    @section('meta-title', 'Mantenimientos' . 'Tecnoparque Nodo ' . \NodoHelper::returnNameNodoUsuario())
@endif

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s8 m8 l10">
                        <h5 class="left-align">
                           <i class="material-icons">settings_applications</i>
                            Mantenimientos
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li class="active">Mantenimientos</li>
                        </ol>
                    </div>
                </div>
                <div class="card ">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12 {{auth()->user()->can('create', App\Models\EquipoMantenimiento::class) ? 'm10 m10' : 'm12 l12'}}">
                                <div class="center-align">
                                    <span class="card-title center-align">
                                        Mantenimientos {{ config('app.name')}}
                                    </span>
                                </div>
                            </div>
                            @can('create', App\Models\EquipoMantenimiento::class)
                            <div class="col s12 m2 l2 show-on-large hide-on-med-and-down">
                                <a href="{{ route('mantenimiento.create') }}">
                                  <div class="card green">
                                    <div class="card-content center">
                                      <i class="left material-icons white-text">add_circle_outline</i>
                                      <span class="white-text">Nuevo Mantenimiento</span>
                                    </div>
                                  </div>
                                </a>
                              </div>
                            @endcan
                        </div>
                        @can('showIndexForAdmin', App\Models\EquipoMantenimiento::class)
                        <div class="row">
                            <div class="divider">
                            </div>
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <label class="active" for="selectnodo">Nodo <span class="red-text">*</span></label>
                                    <select class="js-states browser-default select2 " onchange="selectMantenimientosEquiposPorNodo.selectMantenimientosEquipoForNodo()" tabindex="-1" style="width: 100%" id="selectnodo" >
                                        <option value="">Seleccione nodo</option>
                                        @foreach($nodos as $nodo)
                                          <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>
                            <br>
                                <table class="display responsive-table" id="mantenimientosequipos_administrador_table">
                                    <thead>
                                        <th width="15%">Linea Tecnológica</th>
                                            <th width="15%">Equipo</th>
                                            <th width="15%">Año Mantenimiento</th>
                                            <th width="15%">valor Mantenimiento</th>
                                            <th width="15%">Detalle</th>
                                    </thead>
                    
                                </table>
                        </div>  
                        @elsecan('showIndexForDinamizador', App\Models\EquipoMantenimiento::class)
                        <div class="row">
                            <div class="row">
                                <div class="col s12 m2 l2 show-on-large hide-on-med-and-down">
                                    <a href="{{ route('mantenimiento.create') }}">
                                      <div class="card green">
                                        <div class="card-content center">
                                          <i class="left material-icons white-text">add_circle_outline</i>
                                          <span class="white-text">Nuevo Mantenimiento</span>
                                        </div>
                                      </div>
                                    </a>
                                  </div>
                            </div>
                            <div class="divider">
                            </div>  
                            <br>
                                <table class="display responsive-table" id="mantenimientosequipos_dinamizador_table">
                                    <thead>
                                        <th width="15%">Linea Tecnológica</th>
                                        <th width="15%">Equipo</th>
                                        
                                        <th width="15%">Año Mantenimiento</th>
                                        <th width="15%">valor Mantenimiento</th>
                                        <th width="15%">Detalle</th>
                                        <th width="15%">Editar</th>
                                    </thead>
                    
                                </table>
                        </div>
                        @elsecan('showIndexForExperto', App\Models\EquipoMantenimiento::class)
                        <div class="row">
                            <div class="divider">
                            </div>  
                            <br>
                                <table class="display responsive-table" id="mantenimientosequipos_gestor_table">
                                    <thead>
                                        <th width="15%">Linea Tecnológica</th>
                                        <th width="15%">Equipo</th>
                                        <th width="15%">Año Mantenimiento</th>
                                        <th width="15%">valor Mantenimiento</th>
                                        <th width="15%">Detalle</th>
                                    </thead>
                                </table>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        @can('create', App\Models\EquipoMantenimiento::class)
        <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
            <a href="{{route('mantenimiento.create')}}"  class="btn tooltipped btn-floating btn-large green" data-position="left" data-delay="50" data-tooltip="Nuevo Mantenimiento">
                 <i class="material-icons">add_circle_outline</i>
            </a>
        </div>
        @endcan
    </div>
</main>
@endsection
