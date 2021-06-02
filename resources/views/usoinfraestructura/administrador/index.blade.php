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
                                {{-- <div class="mailbox-options">
                                    <ul>
                                        <li>
                                            <a href="{{{route('usuario.index')}}}">
                                                Todas las asesorias y usos
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{{route('usuario.mytalentos')}}}">
                                                asesorias y usos por gestor
                                            </a>
                                        </li>
                                    </ul>
                                </div> --}}
                                <div class="mailbox-view">
                                    <div class="mailbox-view-header center-align ">
                                        <span class="card-title center-align absolute-center hand-of-Sean-fonts orange-text text-darken-3">Asesorias y usos de {{config('app.name')}}</span>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="divider">
                        </div>
                        <div class=" mailbox-view mailbox-text">
                            <div class="row no-m-t no-m-b search-tabs-row search-tabs-header ">
                                <div class="input-field col s12 m2 l2">
                                    <label class="active" for="filter_nodo">Nodo <span class="red-text">*</span></label>
                                    <select class="js-states browser-default select2" name="filter_nodo" id="filter_nodo" onchange="usoinfraestructuraIndex.queryGestoresByNodo()">
                                        
                                        @forelse($nodos as $id => $name)
                                            <option value="{{$id}}">{{$name}}</option>
                                        @empty
                                            <option>No se encontraron Resultados</option>
                                        @endforelse
                                        <option value="all" >todos</option>
                                    </select>
                                </div>
                                <div class="input-field col s12 m4 l4">
                                    <label class="active" for="filter_gestor">Gestor Asesor <span class="red-text">*</span></label>
                                    <select class="js-states browser-default select2" name="filter_gestor" id="filter_gestor" >
                                        <option value="" >Seleccione primero el nodo</option>
                                    </select>
                                </div>

                                <div class="input-field col s12 m2 l2">
                                    <label class="active" for="filter_year">Año actividad <span class="red-text">*</span></label>
                                    <select class="js-states browser-default select2"  name="filter_year" id="filter_year" >
                                        @for ($i=$year; $i >= 2016; $i--)
                                            <option value="{{$i}}" >{{$i}}</option>
                                        @endfor
                                        <option value="all" >todos</option>
                                    </select>
                                </div>


                                <div class="col s12 m6 l4 offset-m3 right">
                                <button class="waves-effect waves-grey btn-flat search-tabs-button right" id="download_usoinfraestructura"><i class="material-icons">cloud_download</i>Descargar</button>
                                    <button class="waves-effect waves-grey btn-flat search-tabs-button right" id="filter_usoinfraestructura"><i class="material-icons">search</i>Buscar</button>
                                </div>
                            </div>
                            <table class="display responsive-table datatable-example dataTable" id="usoinfraestructa_data_table" width="100%">
                                <thead>
                                    <th width="10%">Fecha</th>
                                    <th width="20%">Asesor</th>
                                    <th width="45%">Nombre</th>
                                    <th width="10%">Fase</th>
                                    <th width="5%">Asesoría Directa</th>
                                    <th width="5%">Asesoría Indirecta</th>
                                    <th width="5%">Detalles</th>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
