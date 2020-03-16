@extends('layouts.app')

@section('meta-title', 'Uso Infraestructura ' )

@section('content')
@php
  $year = Carbon\Carbon::now()->year;
@endphp
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s8 m8 l10">
                        <h5 class="left-align hand-of-Sean-fonts orange-text text-darken-3">
                            <i class="material-icons left">
                                domain
                            </i>
                            Usos de Infraestructura
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li class="active">Uso Infraestructura </li>
                        </ol>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            
                            
                            @if(session()->has('login_role') && session()->get('login_role') == App\User::IsAdministrador())
                                <div class="row">
                                    <div class="col s12 m12 l12">
                                        <div class="center-align hand-of-Sean-fonts orange-text text-darken-3">
                                            <span class="card-title center-align">
                                                Usos de Infraestructura {{ config('app.name')}}
                                                <div class="divider"></div>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col s12 l2">
                                    </div>
                
                                </div>
                                
                                <div class="row">
                                    <div class="col s12 m3 l3">
                                        <label class="active" for="selectnodo">Nodo <span class="red-text">*</span></label>
                                        <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" id="selectnodo" onchange="UsoInfraestructuraAdministrador.queryGestoresByNodo()">
                                            <option value="">Seleccione nodo</option>
                                            @foreach($nodos as $id => $nodo)
                                                <option value="{{$id}}">{{$nodo}}</option>
                                            @endforeach
                                        </select>
                                        
                                    </div>
                                    <div class="col s12 m3 l3">
                                        <label class="active" for="selectGestor">Gestor <span class="red-text">*</span></label>
                                        <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" id="selectGestor">
                                            <option value="">Seleccione primero un nodo</option>
                                            
                                        </select>
                                    </div>
                                    <div class="col s12 m3 l3">
                                        <label class="active" for="selectYear">Año <span class="red-text">*</span></label>
                                        <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" id="selectYear" onchange="UsoInfraestructuraAdministrador.queryActivitiesByGestor()">
                                            <option value="" selected>Seleccione Año</option>
                                            @for ($i=2016; $i <= $year; $i++)
                                                <option value="{{$i}}" >{{$i}}</option>
                                                @endfor
                                        </select>
                                    </div>
                                    <div class="col s12 m3 l3">
                                        <label class="active" for="selectActivity">Actividad <span class="red-text">*</span></label>
                                        <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" id="selectActivity" >
                                            <option value="">primero seleccciona nodo, gestor y año</option>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12 m4 l4 offset-l4">
                                        <a onclick="UsoInfraestructuraAdministrador.ListActividadesPorGestor()" href="javascript:void(0)">
                                            <div class="card blue">
                                                <div class="card-content center flow-text">
                                                    <i class="left material-icons white-text small">search</i>
                                                    <span class="white-text">Consultar Uso de Infraestructura</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="divider"></div>
                                <br>
                                <div class="row">
                                    <table class="display responsive-table" id="usoinfraestructura_administrador_table">
                                        <thead>
                                            <th>Fecha</th>
                                            <th>Nombre</th>
                                            <th>Fase</th>
                                            <th>Asesoria Directa</th>
                                            <th>Asesoria Indirecta</th>
                                            <th>Detalles</th>
                                        </thead>
                        
                                    </table>
                                </div>
                            @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsDinamizador())
                                
                                <div class="row">
                                    <div class="col s12 m12 l12">
                                        <div class="center-align hand-of-Sean-fonts orange-text text-darken-3">
                                            <span class="card-title center-align">
                                                Usos de Infraestructura  Tecnoparque nodo {{ \NodoHelper::returnNameNodoUsuario() }}
                                                <div class="divider"></div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col s12 m4 l4">
                                        <label class="active" for="selectGestor">Gestor <span class="red-text">*</span></label>
                                        <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" id="selectGestor">
                                            <option value="">Seleccione Gestor</option>
                                            @foreach($gestores as $id => $gestor)
                                                <option value="{{$id}}">{{$gestor}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col s12 m4 l4">
                                        <label class="active" for="selectYear">Año <span class="red-text">*</span></label>
                                        <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" id="selectYear" onchange="usoinfraestructura.queryActivitiesByGestor()">
                                            <option value="" selected>Seleccione Año</option>
                                            @for ($i=2016; $i <= $year; $i++)
                                                <option value="{{$i}}" >{{$i}}</option>
                                                @endfor
                                        </select>
                                    </div>
                                    <div class="col s12 m4 l4">
                                        <label class="active" for="selectActivity">Actividad <span class="red-text">*</span></label>
                                        <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" id="selectActivity" >
                                            <option value="">primero seleccciona gestor y año</option>
                                            {{-- @foreach($nodos as $id => $nodo)
                                                <option value="{{$id}}">{{$nodo}}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12 m4 l4 offset-l4">
                                        <a onclick="usoinfraestructura.ListActividadesPorGestor()" href="javascript:void(0)">
                                            <div class="card blue">
                                                <div class="card-content center flow-text">
                                                    <i class="left material-icons white-text small">search</i>
                                                    <span class="white-text">Consultar Uso de Infraestructura</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="divider"></div>
                                <br>
                                
                                <div class="row">
                                    <table class="display responsive-table" id="usoinfraestructura_dinamizador_table">
                                        <thead>
                                            <th>Fecha</th>
                                            <th>Nombre</th>
                                            <th>Fase</th>
                                            <th>Asesoria Directa</th>
                                            <th>Asesoria Indirecta</th>
                                            <th>Detalles</th>
                                        </thead>
                                    </table>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col s12 m12 l10">
                                        <div class="center-align hand-of-Sean-fonts orange-text text-darken-3">
                                            <span class="card-title center-align">
                                                Usos de Infraestructura 
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="col s12 m2 l2 show-on-large hide-on-med-and-down">
                                        <a class="red" href="{{ route('usoinfraestructura.create') }}">
                                          <div class="card green">
                                            <div class="card-content center">
                                              <i class="left material-icons white-text">add</i>
                                              <span class="white-text">Nuevo Uso de Infraestructura</span>
                                            </div>
                                          </div>
                                        </a>
                                      </div>
                                </div>
                                <div class="divider"></div>
                                <br>
                                <div class="row">
                                    @if(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())
                                    <div class="col s12 m6 l6">
                                        <label class="active" for="selectYear">Año <span class="red-text">*</span></label>
                                        <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" id="selectYear" onchange="UsoInfraestructuraGestor.queryActivitiesByGestor({{$gestor_id}})">
                                            <option value="" selected>Seleccione Año</option>
                                            @for ($i=2016; $i <= $year; $i++)
                                                <option value="{{$i}}" >{{$i}}</option>
                                                @endfor
                                        </select>
                                    </div>
                                    <div class="col s12 m6 l6">
                                        <label class="active" for="selectActivity">Actividad <span class="red-text">*</span></label>
                                        <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" id="selectActivity" >
                                            <option value="">Seleccione Actividad</option>
                                            {{-- @foreach($proyectos as $id => $proyecto)
                                              <option value="{{$id}}">{{$proyecto}}</option>
                                            @endforeach --}}
                                        </select>       
                                    </div>
                                    
                                    @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsTalento())
                                        <div class="col s12 m12 l12">
                                            <label class="active" for="selecProyecto">Proyecto <span class="red-text">*</span></label>
                                            <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" id="selecProyecto" onchange="usoinfraestructuraIndex.selectProyectListDatatables()">
                                                <option value="">Seleccione Proyecto</option>
                                                @foreach($proyectos as $id => $proyecto)
                                                <option value="{{$id}}">{{$proyecto}}</option>
                                                @endforeach
                                            </select>       
                                        </div>
                                    @endif
                                </div>
                                @if(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())
                                <div class="row">
                                    <div class="col s12 m4 l4 offset-l4">
                                        <a onclick="UsoInfraestructuraGestor.ListActividadesPorGestor({{$gestor_id}})" href="javascript:void(0)">
                                            <div class="card blue">
                                                <div class="card-content center flow-text">
                                                    <i class="left material-icons white-text small">search</i>
                                                    <span class="white-text">Consultar Uso de Infraestructura</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="divider"></div>
                                <br>
                                @endif
                                <div class="row">
                                    <table class="display responsive-table" id="usoinfraestructura_table">
                                        <thead>
                                            <th>Fecha</th>
                                            <th>Nombre</th>
                                            <th>Fase</th>
                                            <th>Asesoria Directa</th>
                                            <th>Asesoria Indirecta</th>
                                            <th>Detalles</th>
                                        </thead>
                                    </table>
                                </div>
                            @endif 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor() || session()->get('login_role') == App\User::IsTalento())
        <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">

            <a href="{{route('usoinfraestructura.create')}}"  class="btn tooltipped btn-floating btn-large green" data-position="left" data-delay="50" data-tooltip="Nuevo Uso de Infraestructura">
                 <i class="material-icons">add</i>
            </a>
        </div>
        @endif
    </div>
</main>

@endsection
