@extends('layouts.app')
@if(session()->has('login_role') && session()->get('login_role') == App\User::IsAdministrador())
    @section('meta-title', 'Equipos')
@elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsDinamizador())
    @section('meta-title', 'Equipos' . 'Tecnoparque Nodo ' . \NodoHelper::returnNameNodoUsuario())
@endif

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s8 m8 l10">
                        <h5 class="left-align">
                            <i class="material-icons">account_balance_wallet</i>
                            Equipos
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li class="active">Equipos</li>
                        </ol>
                    </div>
                </div>
                <div class="card ">
                    <div class="card-content">
                        @if(session()->has('login_role') && session()->get('login_role') == App\User::IsAdministrador() )
                        <div class="row">
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <div class="center-align">
                                        <span class="card-title center-align">
                                            Equipos {{ config('app.name')}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="divider">
                            </div> 
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <label class="active" for="selectnodo">Nodo <span class="red-text">*</span></label>
                                    <select class="js-states browser-default select2 " onchange="selectEquipoPorNodo.selectEquipoForNodo()" tabindex="-1" style="width: 100%" id="selectnodo" >
                                        <option value="">Seleccione nodo</option>
                                        @foreach($nodos as $nodo)
                                          <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>
                            <br>
                                <table class="display responsive-table" id="equipos_de_tecnoparque_administrador_table">
                                    <thead>
                                        <th width="15%">Linea Tecnológica</th>
                                        <th width="15%">Equipo</th>
                                        <th width="15%">Referencia</th>
                                        <th width="15%">Marca</th>
                                        <th width="15%">Costo Adquisición</th>
                                        <th width="15%">Vida Util (Años)</th>
                                        <th width="15%">Promedio Horas uso al año</th>
                                        <th width="15%">Año de compra</th>
                                        <th width="15%">Año fin depreciación</th>
                                        <th width="15%">Depreciación por año</th>
                                    </thead>
                    
                                </table>
                        </div>
                        @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsDinamizador())
                            <div class="row">
                                <div class="row">
                                    <div class="col s12 m12 l10">
                                        <div class="center-align">
                                            <span class="card-title center-align">
                                                Equipos Tecnoparque Nodo {{\NodoHelper::returnNameNodoUsuario()}}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col s12 l2">
                                        <div class="click-to-toggle show-on-large hide-on-med-and-down">
                                            <a class="btnregister waves-effect waves-light-sena btn" href="{{route('equipo.create')}}">
                                                <i class="material-icons">add_circle</i>
                                                 Nuevo Equipo
                                            </a>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="divider">
                                </div>  
                                <br>
                                    <table class="display responsive-table" id="equipo_tecnoparque_dinamizador_table">
                                        <thead>
                                            <th width="15%">Linea Tecnológica</th>
                                            <th width="15%">Equipo</th>
                                            <th width="15%">Referencia</th>
                                            <th width="15%">Marca</th>
                                            <th width="15%">Costo Adquisición</th>
                                            <th width="15%">Vida Util (Años)</th>
                                            <th width="15%">Promedio Horas uso al año</th>
                                            <th width="15%">Año de compra</th>
                                            <th width="15%">Año fin depreciación</th>
                                            <th width="15%">Depreciación por año</th>
                                            <th width="15%">Editar</th>
                                        </thead>
                        
                                    </table>
                            </div>
                        @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())
                            <div class="row">
                                <div class="row">
                                    <div class="col s12 m12 l12">
                                        <div class="center-align">
                                            <span class="card-title center-align">
                                                Equipos {{auth()->user()->gestor->lineatecnologica->nombre}} |  Tecnoparque Nodo {{\NodoHelper::returnNameNodoUsuario()}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="divider">
                                </div>  
                                <br>
                                    <table class="display responsive-table" id="equipo_tecnoparque_gestor_table">
                                        <thead>
                                            <th width="15%">Linea Tecnológica</th>
                                            <th width="15%">Equipo</th>
                                            <th width="15%">Referencia</th>
                                            <th width="15%">Marca</th>
                                            <th width="15%">Costo Adquisición</th>
                                            <th width="15%">Vida Util (Años)</th>
                                            <th width="15%">Promedio Horas uso al año</th>
                                            <th width="15%">Año de compra</th>
                                            <th width="15%">Año fin depreciación</th>
                                            <th width="15%">Depreciación por año</th>
                                        </thead>
                        
                                    </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @if(session()->has('login_role') && session()->get('login_role') == App\User::IsDinamizador())
            <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
                <a href="{{route('equipo.create')}}"  class="btn tooltipped btn-floating btn-large green" data-position="left" data-delay="50" data-tooltip="Nuevo equipo">
                     <i class="material-icons">straighten</i>
                </a>
            </div>
        @endif
    </div>
</main>
@endsection
