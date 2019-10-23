@extends('layouts.app')

@section('meta-title', 'Uso Infraestructura ' )

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                
                <div class="row">
                    <div class="col s8 m8 l10">
                        <h5 class="left-align">
                            <i class="material-icons left">
                                domain
                            </i>
                            Uso Infraestructura
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align">
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
                                        <div class="center-align">
                                            <span class="card-title center-align">
                                                Usos de Infraestructura {{ config('app.name')}}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col s12 l2">
                                    
                                </div>
                                <div class="divider"></div>
                                <br>
                                <div class="row">
                                    <div class="col s12 m12 l12">
                                        <label class="active" for="selectnodo">Nodo <span class="red-text">*</span></label>
                                        <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" id="selectnodo" onchange="UsoInfraestructuraAdministrador.selectUsoInfraestructuraPorNodo()">
                                            <option value="">Seleccione nodo</option>
                                            @foreach($nodos as $id => $nodo)
                                              <option value="{{$id}}">{{$nodo}}</option>
                                            @endforeach
                                        </select>
                                        
                                    </div>
                                </div>
                                <div class="row">
                                    <table class="display responsive-table" id="usoinfraestructura_administrador_table">
                                        <thead>
                                            <th>Fecha</th>
                                            <th>Nombre</th>
                                            <th>Asesoria Directa</th>
                                            <th>Asesoria Indirecta</th>
                                            <th>Detalles</th>
                                        </thead>
                        
                                    </table>
                                </div>
                            @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsDinamizador())
                                
                                <div class="row">
                                    <div class="col s12 m12 l12">
                                        <div class="center-align">
                                            <span class="card-title center-align">
                                                Usos de Infraestructura  Tecnoparque nodo {{ \NodoHelper::returnNameNodoUsuario() }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col s12 l2">
                                    
                                </div>
                                <div class="divider"></div>
                                <br>
                                
                                <div class="row">
                                    <table class="display responsive-table" id="usoinfraestructura_dinamizador_table">
                                        <thead>
                                            <th>Fecha</th>
                                            <th>Nombre</th>
                                            <th>Asesoria Directa</th>
                                            <th>Asesoria Indirecta</th>
                                            <th>Detalles</th>
                                        </thead>
                        
                                    </table>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col s12 m12 l10">
                                        <div class="center-align">
                                            <span class="card-title center-align">
                                                Usos de Infraestructura 
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col s12 l2">
                                        <div class="click-to-toggle show-on-large hide-on-med-and-down">
                                            <a class="btnregister btn btn-floating btn-large tooltipped green" data-delay="50" data-position="button" data-tooltip="Nuevo Uso de Infraestructura" href="{{route('usoinfraestructura.create')}}">
                                                <i class="material-icons">
                                                    domain
                                                </i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="divider"></div>
                                <br>
                                <div class="row">
                                    <table class="display responsive-table" id="usoinfraestructura_table">
                                        <thead>
                                            <th>Fecha</th>
                                            <th>Nombre</th>
                                            <th>Asesoria Directa</th>
                                            <th>Asesoria Indirecta</th>
                                            <th>Detalles</th>
                                            <th>Editar</th>
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
                 <i class="material-icons">domain</i>
            </a>
        </div>
        @endif
    </div>
</main>

@endsection
