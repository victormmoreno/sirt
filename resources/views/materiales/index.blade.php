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
                            <div class="row">
                                @if(session()->has('login_role') && session()->get('login_role') == App\User::IsAdministrador())
                                    <div class="col s12 m12 l12">
                                        <div class="center-align">
                                            <span class="card-title center-align">
                                                Materiales {{ config('app.name')}}
                                            </span>
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
                                @endif
                            </div>
                            <div class="divider">
                            </div>  
                            <br>
                            @if(session()->has('login_role') && session()->get('login_role') == App\User::IsAdministrador())
                                <table class="display responsive-table" id="materiales_administrador_table">
                                    <thead>
                                        <th width="15%">Abreviatura</th>
                                        <th width="30%">Linea</th>
                                        <th width="40%">Descripcion</th>
                                        <th width="40%">Detalles</th>
                                        <th width="15%">Editar</th>
                                    </thead>
                                </table>
                            @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsDinamizador())
                                <table class="display responsive-table" id="materiales_dinamizador_table">
                                    <thead>
                                        <th width="15%">Abreviatura</th>
                                        <th width="30%">Linea</th>
                                        <th width="40%">Descripcion</th>
                                        <th width="15%">Editar</th>
                                    </thead>
                                </table>
                            @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())
                                <table class="display responsive-table" id="materiales_gestor_table">
                                    <thead>
                                        <th width="15%">Abreviatura</th>
                                        <th width="30%">Linea</th>
                                        <th width="40%">Descripcion</th>
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
