@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
    @php
        $year = Carbon\Carbon::now();
        $year = $year->isoFormat('YYYY');
    @endphp
    <main class="mn-inner inner-active-sidebar">
        <div class="content">
            <div class="row no-m-t no-m-b m-r-lg m-l-lg">
                <div class="left left-align">
                    <h5 class="left-align primary-text">
                        <i class="material-icons left">library_books</i>Proyectos de Base Tecnológica
                    </h5>
                </div>
                <div class="right right-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="active">Proyectos</li>
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
                                        <div class="col s12 m8 l8">
                                            <div class="center-align">
                                                <span class="card-title center-align orange-text text-darken-3">Proyectos de {{ auth()->user()->nombres }} {{ auth()->user()->apellidos }} </span>
                                            </div>
                                        </div>
                                        <div class="col s12 m4 l4 ">
                                            <a href="{{route('proyecto.create')}}"
                                               class="waves-effect bg-secondary white-text btn-flat search-tabs-button right show-on-large hide-on-med-and-down">Nuevo
                                                Proyecto</a>
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                    <div id="proyectos">
                                        <div class="row">
                                            <div class="col s12 m12 l12">
                                                <div class="input-field col s12 m12 l12">
                                                    <select class="js-states" tabindex="-1" style="width: 100%"
                                                            id="anho_proyectoPorAnhoGestorNodo"
                                                            name="anho_proyectoPorAnhoGestorNodo"
                                                            onchange="consultarProyectosDelGestorPorAnho();">
                                                        @for ($i=2016; $i <= $year; $i++)
                                                            <option
                                                                value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                    <label for="anho_proyectoPorAnhoGestorNodo">Seleccione el
                                                        Año</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            @include('proyectos.table')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('proyectos.modals')
@endsection
