@extends('layouts.app')
@section('meta-title', 'Articulaciones PBT')
@section('content')
@php
    $year = Carbon\Carbon::now()->year;
@endphp
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s8 m8 l9">
                <h5 class="left-align orange-text text-darken-3">
                    <i class="material-icons left">autorenew</i>Articulaciones PBT
                </h5>
            </div>
            <div class="col s4 m4 l3 rigth-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li class="active">Articulaciones PBT</li>
                </ol>
            </div>
        </div>
        <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
            <div class="card">
            <div class="card-content">
                <div class="row">
                <div class="col s12 m12 l12">
                    <div class="row">
                    @if((session()->has('login_role') && session()->get('login_role') === App\User::IsAdministrador()))
                        <div class="col s12 m8 l8">
                            <div class="center-align orange-text text-darken-3">
                                <span class="card-title center-align">Articulaciones PBT -  {{config('app.name')}}</span>
                            </div>

                        </div>
                        <div class="col s12 m4 l4 ">
                            <a  href="{{route('tipoarticulaciones.index')}}" class="waves-effect waves-grey grey darken-1 white-text btn-flat search-tabs-button right show-on-large hide-on-med-and-down"><i class="material-icons left">settings</i>tipos de Articulaciones</a>
                        </div>
                    @elseif((session()->has('login_role') && session()->get('login_role') === App\User::IsDinamizador()))
                    <div class="col s12 m12 l12">
                        <div class="center-align orange-text text-darken-3">
                            <span class="card-title center-align">Articulaciones PBT - nodo {{ \NodoHelper::returnNameNodoUsuario() }}</span>
                        </div>
                    </div>
                    @elseif((session()->has('login_role') && session()->get('login_role') === App\User::IsArticulador()))
                        <div class="col s12 m8 l8">
                        <div class="center-align orange-text text-darken-3">
                            <span class="card-title center-align">Articulaciones PBT - {{ auth()->user()->nombres }} {{ auth()->user()->apellidos }} </span>
                        </div>
                        </div>
                        <div class="col s12 m4 l4 ">
                        <a  href="{{route('articulaciones.create')}}" class="waves-effect waves-grey grey darken-1 white-text btn-flat search-tabs-button right show-on-large hide-on-med-and-down">Nueva Articulación</a>
                        </div>
                    @else
                        <div class="col s12 m12 l12">
                        <div class="center-align orange-text text-darken-3">
                            <span class="card-title center-align">Articulaciones PBT - {{ auth()->user()->nombres }} {{ auth()->user()->apellidos }} </span>
                        </div>
                        </div>
                    @endif
                    </div>
                    <div class="divider"></div>
                        <div class="row search-tabs-row search-tabs-header">
                            @if((session()->has('login_role') && session()->get('login_role') == App\User::IsAdministrador()))
                            <div class="input-field col s12 m2 l2">
                                <label class="active" for="filter_nodo_art">Nodo <span class="red-text">*</span></label>
                                <select name="filter_nodo_art" id="filter_nodo_art">
                                    <option value="all" >todos</option>
                                    @foreach($nodos as $id => $name)
                                        <option value="{{$id}}">{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <div class="input-field col s12 m2 l1">
                                <label class="active" for="filter_year_art">Año <span class="red-text">*</span></label>
                                <select name="filter_year_art" id="filter_year_art">
                                    @for ($i=$year; $i >= 2016; $i--)
                                        <option value="{{$i}}" >{{$i}}</option>
                                    @endfor
                                    <option value="all" >todos</option>
                                </select>
                            </div>
                            <div class="input-field col s12 m2 l1">
                                <label class="active" for="filter_phase">Fases <span class="red-text">*</span></label>
                                <select name="filter_phase" id="filter_phase">
                                <option value="all" >todos</option>
                                    @forelse($fases  as $id => $name)
                                        <option value="{{$id}}" >{{$name}}</option>
                                    @empty
                                        <option>No se encontraron resultados</option>
                                    @endforelse

                                </select>
                            </div>

                            <div class="input-field col s12 m3 l2">
                                <label class="active" for="filter_tipo_articulacion">Tipo Articulación</label>
                            <select  name="filter_tipo_articulacion" id="filter_tipo_articulacion">
                                <option value="all">Todos</option>
                                @forelse($tipoarticulaciones  as $id => $name)
                                        <option value="{{$id}}" >{{$name}}</option>
                                    @empty
                                        <option>No se encontraron resultados</option>
                                    @endforelse
                            </select>
                            </div>
                            <div class="input-field col s12 m3 l2">
                                <label class="active" for="filter_alcance_articulacion">Alcance</label>
                                <select name="filter_alcance_articulacion" id="filter_alcance_articulacion">
                                    <option value="all" >todos</option>
                                    @forelse($alcances  as $id => $name)
                                        <option value="{{$id}}" >{{$name}}</option>
                                    @empty
                                        <option>No se encontraron resultados</option>
                                    @endforelse
                                </select>
                            </div>

                            <div class="col s12 m6 l4 offset-m3 right">
                                <button class="waves-effect waves-grey btn-flat search-tabs-button right" id="download_archive_art"><i class="material-icons">cloud_download</i>Descargar</button>
                                <button class="waves-effect waves-grey btn-flat search-tabs-button right" id="filter_articulacion"><i class="material-icons">search</i>Filtar</button>
                            </div>
                        </div>
                    <table id="articulaciones_data_table" class="display responsive-table datatable-example dataTable" style="width: 100%">
                        <thead>
                        <tr>
                            <th>Nodo</th>
                            <th>Código Articulación</th>
                            <th>Nombre de Articulación</th>
                            <th>Articulador</th>
                            <th>Fase</th>
                            <th>Fecha de Registro</th>
                            <th>Proceso</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
            </div>
            @if((session()->has('login_role') && session()->get('login_role') === App\User::IsArticulador()))
            <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
            <a href="{{route('articulaciones.create')}}"  class="btn tooltipped btn-floating btn-large grey" data-position="left" data-delay="50" data-tooltip="Nueva Articulación">
                <i class="material-icons">add</i>
            </a>
            </div>
            @endif
        </div>
        </div>
    </div>
</main>
@endsection

