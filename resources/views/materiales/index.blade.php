@extends('layouts.app')

@section('meta-title', 'Materiales')

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s8 m8 l10">
                        <h5 class="left-align">
                            <i class="material-icons left">
                                local_library
                            </i>
                            Materiales de Formación
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li class="active">Materiales</li>
                        </ol>
                    </div>
                </div>
                <div class="card ">
                    <div class="card-content">
                        <div class="row">
                            
                                @if(session()->has('login_role') && session()->get('login_role') == App\User::IsAdministrador())
                                    <div class="row">
                                        <div class="col s12 m12 l12">
                                            <div class="center-align">
                                                <span class="card-title center-align">
                                                    Materiales de Formación {{ config('app.name')}}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider">
                                    </div> 
                                    <div class="row">
                                        <div class="col s12 m12 l12">
                                            <label class="active" for="selectnodo">Nodo <span class="red-text">*</span></label>
                                            <select class="js-states browser-default select2 " onchange="selectMaterialesPorNodo.selectMaterialesForNodo()" tabindex="-1" style="width: 100%" id="selectnodo" >
                                                <option value="">Seleccione nodo</option>
                                                @foreach($nodos as $nodo)
                                                  <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                                                @endforeach
                                            </select>
                                            
                                        </div>
                                    </div>
                                            
                                @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsDinamizador() || session()->get('login_role') == App\User::IsGestor())
                                    <div class="col s12 m12 l10">
                                        <div class="center-align">
                                            <span class="card-title center-align">
                                                @if(session()->has('login_role') && session()->get('login_role') == App\User::IsDinamizador())
                                                Materiales Tecnoparque nodo {{ \NodoHelper::returnNameNodoUsuario() }}
                                                @elseif(session()->get('login_role') == App\User::IsGestor())
                                                    Materiales {{ isset(auth()->user()->gestor->lineatecnologica->abreviatura) ? auth()->user()->gestor->lineatecnologica->abreviatura : '' }} - {{ isset(auth()->user()->gestor->lineatecnologica->nombre) ? auth()->user()->gestor->lineatecnologica->nombre : '' }} | Tecnoparque nodo {{ \NodoHelper::returnNameNodoUsuario() }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col s12 l2">
                                        <div class="click-to-toggle show-on-large hide-on-med-and-down">
                                            <a class="btnregister btn btn-floating btn-large tooltipped green" data-delay="50" data-position="button" data-tooltip="Nuevo Material de Formación" href="{{route('material.create')}}">
                                                <i class="material-icons">
                                                    local_library
                                                </i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="divider">
                                    </div>   
                                @endif
                            
                             
                            <br>
                            @if(session()->has('login_role') && session()->get('login_role') == App\User::IsAdministrador())
                                <table class="display responsive-table" id="materiales_administrador_table">
                                    <thead>
                                        <th width="20%">Fecha Adquisición</th>
                                        <th width="20%">Linea Tecnológica</th>
                                        <th width="20%">Código de Material</th>
                                        <th width="30%">Nombre de Material</th>
                                        <th width="15%">Presentación</th>
                                        <th width="15%">Medida</th>
                                        <th width="10%">Cantidad Adquirida</th>
                                        <th width="20%">Valor Unitario</th>
                                        <th width="20%">Valor total</th>
                                        <th width="15%">Detalle</th>
                                    </thead>
                                </table>
                            @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsDinamizador())
                                <table class="display responsive-table" id="materiales_dinamizador_table">
                                    <thead>
                                        <th width="20%">Fecha Adquisición</th>
                                        <th width="20%">Linea Tecnológica</th>
                                        <th width="20%">Código de Material</th>
                                        <th width="30%">Nombre de Material</th>
                                        <th width="15%">Presentación</th>
                                        <th width="15%">Medida</th>
                                        <th width="10%">Cantidad Adquirida</th>
                                        <th width="20%">Valor Unitario</th>
                                        <th width="20%">Valor total</th>
                                        <th width="15%">Detalle</th>
                                        <th width="15%">Editar</th>

                                    </thead>
                                </table>
                            @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())
                                <table class="display responsive-table" id="materiales_gestor_table">
                                    <thead>
                                        <th width="20%">Fecha Adquisición</th>
                                        <th width="20%">Linea Tecnológica</th>
                                        <th width="20%">Código de Material</th>
                                        <th width="30%">Nombre de Material</th>
                                        <th width="15%">Presentación</th>
                                        <th width="15%">Medida</th>
                                        <th width="10%">Cantidad Adquirida</th>
                                        <th width="20%">Valor Unitario</th>
                                        <th width="20%">Valor total</th>
                                        <th width="15%">Detalle</th>
                                        <th width="15%">Editar</th>

                                    </thead>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
