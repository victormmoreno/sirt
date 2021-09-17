@extends('layouts.app')
@section('meta-title', 'Soporte')
@php
    $year = Carbon\Carbon::now()->year;
@endphp
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
            <div class="row">
                <div class="col m9 l9">
                    <h5 class="left-align orange-text text-darken-3">
                        <i class="material-icons left">help</i>Soporte
                    </h5>
                </div>
                <div class="col m3 l3 rigth-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li class="active">Soporte</li>
                    </ol>
                </div>
            </div>
            <div class="card">
            <div class="card-content">
                <div class="row">
                <div class="col s12 m12 l12">
                    <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="center-align  orange-text text-darken-3">
                            <span class="card-title center-align">Soporte {{config('app.name')}}</span>
                        </div>
                    </div>
                    </div>
                    <div class="divider"></div>
                    <div class="row search-tabs-row search-tabs-header">

                        <div class="input-field col s12 m2 l1">
                            <label class="active" for="filter_year_support">Año <span class="red-text">*</span></label>
                            <select name="filter_year_support" id="filter_year_support">
                                @for ($i=$year; $i >= 2021; $i--)
                                    <option value="{{$i}}" >{{$i}}</option>
                                @endfor
                                <option value="all" >todos</option>
                            </select>
                        </div>
                        <div class="input-field col s12 m3 l4">
                            <label class="active" for="filter_request_support">Tipo Solicitud<span class="red-text">*</span></label>
                            <select name="filter_request_support" id="filter_request_support">
                                <option value="all">Todos</option>
                                <option value="Incidencia">Incidencia</option>
                                <option value="Requerimiento">Requerimiento</option>
                            </select>
                        </div>
                        <div class="input-field col s12 m2 l2">
                            <label class="active" for="filter_state_support">Estado</label>
                            <select  name="filter_state_support" id="filter_state_support">
                                <option value="Pendiente">Pendiente</option>
                                <option value="En Espera">En Espera</option>
                                <option value="Solucionado">Solucionado</option>
                                <option value="all">Todos</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4 offset-m3 right">

                            <button class="waves-effect waves-grey btn-flat search-tabs-button right" id="filter_support"><i class="material-icons">search</i>Buscar</button>
                        </div>
                    </div>
                    <table id="support_data_table" class="display responsive-table datatable-example dataTable" style="width: 100%">
                        <thead>
                        <tr>
                            <th>Ticket</th>
                            <th>Fecha</th>
                            <th>Persona</th>
                            <th>Correo</th>
                            <th>Asunto</th>
                            <th>Estado</th>
                            <th>Detalles</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
</main>
@endsection
