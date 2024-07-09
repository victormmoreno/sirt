@extends('layouts.app')
@section('meta-title', 'Migraciones')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
            <div class="left left-align">
                <h5 class="left-align primary-text">
                    <i class="material-icons left">attach_file</i>Migraciones
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li class="active">Migraciones</li>
                </ol>
            </div>
        </div>
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div class="primary-text">
                                    <div class="mailbox-view-header">
                                        <div class="center-align">
                                            <h1 class="card-title center-align text-2xl no-m">Migraciones de base de datos</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="divider"></div>
                            </div>
                            <div class="row">
                                <div class="col s12 m4 l4">
                                    <a href="{{route('migracion.proyectos')}}">
                                        <div class="card stats-card green lighten-3" style="cursor:pointer">
                                            <div class="card-content">
                                                <span class="stats-counter">
                                                    Migración de proyectos
                                                </span>
                                                <br>
                                            </div>
                                            <div class="progress stats-card-progress bg-secondary">
                                                <div class="determinate"></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col s12 m4 l4">
                                    <a href="{{route('migracion.proyectos.caracterizacion')}}">
                                        <div class="card stats-card green lighten-3" style="cursor:pointer">
                                            <div class="card-content">
                                                <span class="stats-counter">
                                                    Migración de caracterización de proyectos
                                                </span>
                                                <br>
                                            </div>
                                            <div class="progress stats-card-progress bg-secondary">
                                                <div class="determinate"></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col s12 m4 l4">
                                    <a href="{{route('migracion.form.archivos.xml')}}">
                                        <div class="card stats-card green lighten-3" style="cursor:pointer">
                                            <div class="card-content">
                                                <span class="stats-counter">
                                                    Generar archivo XML
                                                </span>
                                                <br>
                                            </div>
                                            <div class="progress stats-card-progress bg-secondary">
                                                <div class="determinate"></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
