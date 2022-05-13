@extends('layouts.app')
@section('meta-title', 'Ideas')
@section('content')
@php
    $year = Carbon\Carbon::now()->year;
@endphp
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
            <div class="row">
                <div class="col s8 m8 l9">
                    <h5 class="left-align hand-of-Sean-fonts orange-text text-darken-3">
                        <i class="material-icons left">
                            lightbulb
                        </i>
                        Ideas de Proyecto
                    </h5>
                </div>
                <div class="col s4 m4 l3 rigth-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li class="active">Ideas de Proyecto</li>
                    </ol>
                </div>
            </div>
            <div class="card">
            <div class="card-content">
                <div class="row">
                <div class="col s12 m12 l12">
                    <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="center-align hand-of-Sean-fonts orange-text text-darken-3">
                            @if((session()->has('login_role') && session()->get('login_role') === App\User::IsAdministrador() ))
                                <span class="card-title center-align">Ideas de {{config('app.name')}}</span>
                            @else
                                <span class="card-title center-align">Ideas de Tecnoparque nodo {{ \NodoHelper::returnNameNodoUsuario() }}</span>
                            @endif
                        </div>
                    </div>
                    </div>
                    <div class="divider"></div>

                        <div class="row search-tabs-row search-tabs-header">
                            @if((session()->has('login_role') && session()->get('login_role') == App\User::IsAdministrador()))
                            <div class="input-field col s12 m2 l2">
                                <label class="active" for="filter_nodo">Nodo <span class="red-text">*</span></label>
                                <select name="filter_nodo" id="filter_nodo">
                                    <option value="all" >todos</option>
                                    @foreach($nodos as $id => $name)
                                        <option value="{{$id}}">{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <div class="input-field col s12 m2 l1">
                                <label class="active" for="filter_state">Año <span class="red-text">*</span></label>
                                <select name="filter_year_ideas" id="filter_year_ideas">
                                    @for ($i=$year; $i >= 2016; $i--)
                                        <option value="{{$i}}" >{{$i}}</option>
                                    @endfor
                                    <option value="all" >todos</option>
                                </select>
                            </div>
                            <div class="input-field col s12 m2 l1">
                                <label class="active" for="filter_state">Estado <span class="red-text">*</span></label>
                                <select name="filter_state" id="filter_state">
                                    @forelse($estadosIdeas  as $id => $name)
                                        <option value="{{$id}}" >{{$name}}</option>
                                    @empty
                                        <option>No se encontraron resultados</option>
                                    @endforelse
                                    <option value="all" >todos</option>
                                </select>
                            </div>

                            <div class="input-field col s12 m2 l1">
                                <label class="active" for="filter_vieneconvocatoria">Convocatoria</label>
                            <select  name="filter_vieneconvocatoria" id="filter_vieneconvocatoria">
                                <option value="all">Todas</option>
                                <option value="si">Si</option>
                                <option value="no">No</option>
                            </select>
                            </div>
                            <div class="input-field col s12 m6 l3">
                                <input type="text" id="filter_convocatoria" placeholder="nombre de convocatoria">
                            </div>
                            <div class="col s12 m6 l4 offset-m3 right">
                                <button class="waves-effect waves-grey btn-flat search-tabs-button right" id="download_excel"><i class="material-icons">cloud_download</i>Descargar</button>
                                <button class="waves-effect waves-grey btn-flat search-tabs-button right" id="filter_idea"><i class="material-icons">search</i>Buscar</button>
                            </div>
                        </div>


                    <table id="ideas_data_table" class="display responsive-table datatable-example dataTable" style="width: 100%">
                        <thead>
                        <tr>
                            <th>Código de la Idea</th>
                            <th>Fecha de Registro</th>
                            <th>Persona</th>
                            <th>Correo</th>
                            <th>Contacto</th>
                            <th>Nombre de la Idea</th>
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
    @include('ideas.modals')
</main>
@endsection

