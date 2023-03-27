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
            <h5 class="left left-align primary-text">
                <i class="material-icons left">
                    lightbulb
                </i>
                Ideas de Proyecto
            </h5>
            <div class="right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li class="active">Ideas de Proyecto</li>
                </ol>
            </div>
            <div class="card">
            <div class="card-content">
                <div class="row">
                <div class="col s12 m12 l12">
                    <div class="row">
                        <div class="col s12 m8 l8">
                            <div class="center-align primary-text">
                                <span class="card-title center-align">Ideas de Tecnoparque</span>
                            </div>
                        </div>
                        @can('create', App\Models\Idea::class)
                            <div class="col s12 m4 l4">
                                <a href="{{ route('idea.create') }}" class="bg-secondary btn withe-text right"><i class="material-icons left">add</i> Nueva Idea de Proyecto</a>
                            </div>
                        @endcan
                        @can('search', App\Models\Idea::class)
                        <div class="col s12 m4 l4">
                            <a href="{{ route('idea.buscar') }}" class="bg-secondary btn withe-text right"><i class="material-icons left">search</i>Buscar idea de proyecto</a>
                        </div>
                        @endcan
                    </div>
                    <div class="divider"></div>
                    @can('showFilters', App\Models\Idea::class)
                        <div class="row search-tabs-row search-tabs-header">
                            @can('showNodosInput', App\Models\Idea::class)
                            <div class="input-field col s12 m2 l2">
                                <label class="active" for="filter_nodo">Nodo <span class="red-text">*</span></label>
                                <select name="filter_nodo[]" id="filter_nodo" multiple required>
                                    <option value="all" selected>Todos</option>
                                    @foreach($nodos as $id => $name)
                                        <option value="{{$id}}">{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endcan
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
                            @can('export', App\Models\Idea::class)
                            <div class="col s12 m6 l4 offset-m3 right">
                                <button class="waves-effect waves-grey bg-secondary-lighten white-text btn-flat right show-on-large hide-on-med-and-down m-l-xs" id="download_excel"><i class="material-icons left">cloud_download</i>Descargar</button>
                                <button class="waves-effect waves-grey bg-secondary white-text btn-flat right show-on-large hide-on-med-and-down m-l-xs" id="filter_idea"><i class="material-icons left">search</i>Filtrar</button>
                            </div>
                            @endcan
                        </div>
                    @endcan
                    @include('ideas.table')
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

