@extends('layouts.app')

@section('meta-title', 'Asesoria y Usos' )

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
                            Asesorías y usos
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li class="active">Asesoría y uso </li>
                        </ol>
                    </div>
                </div>
                <div class="card mailbox-content">
                    <div class="card-content">
                        <div class="row no-m-t no-m-b">
                            <div class="col s12 m12 l12">

                                <div class="mailbox-view">
                                    <div class="mailbox-view-header center-align ">
                                        <div class="row no-m-t no-m-b">
                                            @if(session()->has('login_role') && session()->get('login_role') == App\User::IsDinamizador())
                                                <div class="col s12 m12 l12">
                                                    <span class="card-title center-align absolute-center hand-of-Sean-fonts orange-text text-darken-3">
                                                        Asesorias y usos de Tecnoparque Nodo {{ \NodoHelper::returnNameNodoUsuario() }}
                                                    </span>
                                                </div>
                                            @else
                                                <div class="col s12 m8 l8">
                                                    <span class="card-title center-align absolute-center hand-of-Sean-fonts orange-text text-darken-3">
                                                        Asesorias y usos de Infraestructura
                                                    </span>
                                                </div>
                                                <div class="col s12 m4 l4 show-on-large hide-on-med-and-down">
                                                    @if(session()->has('login_role') == App\User::IsGestor() || session()->has('login_role') == App\User::IsArticulador())
                                                        <a  href="{{route('usoinfraestructura.create')}}" class="waves-effect waves-grey light-green btn-flat search-tabs-button right show-on-large hide-on-med-and-down">Nueva Asesoria</a>
                                                    @else
                                                        <a  href="{{route('usoinfraestructura.create')}}" class="waves-effect waves-grey light-green btn-flat search-tabs-button right show-on-large hide-on-med-and-down">Nuevo uso de Infraestructura</a>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="divider">
                        </div>
                        <div class=" mailbox-view mailbox-text">
                            <div class="row no-m-t no-m-b search-tabs-row search-tabs-header ">
                                <div class="input-field col s12 m2 l2">
                                    <label class="active" for="filter_year">Año <span class="red-text">*</span></label>
                                    <select name="filter_year" id="filter_year" @if(session()->has('login_role') && (session()->get('login_role') == App\User::IsGestor() || session()->get('login_role') == App\User::IsTalento())) onchange="usoinfraestructuraIndex.queryActivitiesByAnio()" @endif>
                                        @for ($i=$year; $i >= 2016; $i--)
                                            <option value="{{$i}}" >{{$i}}</option>
                                        @endfor
                                        <option value="all" >todos</option>
                                    </select>
                                </div>
                                @if(session()->has('login_role') && session()->get('login_role') == App\User::IsDinamizador())

                                <div class="input-field col s12 m4 l4">

                                    <select class="js-states browser-default select2" name="filter_gestor" id="filter_gestor" >
                                        <option value="all" >todos</option>
                                        @foreach($gestores as $id => $gestor)
                                            <option value="{{$id}}">{{$gestor}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                @if(session()->has('login_role') && (session()->get('login_role') == App\User::IsGestor() || session()->get('login_role') == App\User::IsTalento()))

                                <div class="input-field col s12 m4 l4">
                                    <label class="active" for="filter_actividad">Actividad <span class="red-text">*</span></label>
                                    <select name="filter_actividad" id="filter_actividad">
                                        <option value="all" >Todas</option>
                                    </select>
                                </div>
                                @endif

                                <div class="col s12 m6 l4 offset-m3 right">
                                    <button class="waves-effect waves-grey btn-flat search-tabs-button right" id="download_usoinfraestructura"><i class="material-icons">cloud_download</i>Descargar</button>
                                    <button class="waves-effect waves-grey btn-flat search-tabs-button right" id="filter_usoinfraestructura"><i class="material-icons">search</i>Filtrar</button>
                                </div>
                            </div>
                            <table class="display responsive-table datatable-example dataTable" id="usoinfraestructa_data_table" width="100%">
                                <thead>
                                    <th width="10%">Fecha</th>
                                    <th width="20%">Asesor</th>
                                    <th width="10%">Tipo Asesoria</th>
                                    <th width="35%">Nombre</th>
                                    <th width="10%">Fase</th>
                                    <th width="5%">Asesoría Directa</th>
                                    <th width="5%">Asesoría Indirecta</th>
                                    <th width="5%">Detalles</th>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
                @if(session()->has('login_role') && (session()->get('login_role') == App\User::IsGestor()|| session()->get('login_role') == App\User::IsTalento() || session()->get('login_role') == App\User::IsArticulador() ))
                <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
                <a href="{{route('usoinfraestructura.create')}}"  class="btn tooltipped btn-floating btn-large green" data-position="left" data-delay="50" data-tooltip="{{session()->has('login_role') == App\User::IsGestor() ? 'Nueva Asesoria' : 'Nuevo uso de Infraestructura'}}">
                        <i class="material-icons">add_circle</i>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</main>

@endsection
