@extends('layouts.app')
@section('meta-title', 'Entrenamientos')
@section('meta-content', 'Entrenamientos')
@section('meta-keywords', 'Entrenamientos')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
            <div class="row">
                <div class="col s8 m8 l10">
                    <h5 class="left-align hand-of-Sean-fonts orange-text text-darken-3">
                        <i class="material-icons left">
                            library_books
                        </i>
                        Entrenamientos
                    </h5>
                </div>
                <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li class="active">Entrenamientos</li>
                    </ol>
                </div>
            </div>
            <div class="card">
            <div class="card-content">
                <div class="row">
                <div class="col s12 m12 l12">
                    <div class="row">
                    <div class="col s12 m10 l10">
                        <div class="center-align hand-of-Sean-fonts orange-text text-darken-3">
                        <span class="card-title center-align">Entrenamientos de Tecnoparque nodo {{$nodo}}</span>
                        </div>
                    </div>
                    <div class="col s12 m2 l2 show-on-large hide-on-med-and-down">
                        <a href="{{ route('entrenamientos.create') }}">
                        <div class="card green">
                            <div class="card-content center">
                            <i class="left material-icons white-text">add</i>
                            <span class="white-text">Nuevo Entrenamiento</span>
                            </div>
                        </div>
                        </a>
                    </div>
                    </div>
                    <div class="divider"></div>
                    <table id="entrenamientos_nodo_table" class="display responsive-table datatable-example dataTable">
                    <thead>
                        <tr>
                        <th>Consecutivo</th>
                        <th>Primera Sesion</th>
                        <th>Segunda Sesion</th>
                        <th>Correos</th>
                        <th>Fotos</th>
                        <th>Listado de Asistentes</th>
                        <th>Ideas</th>
                        <th>Editar</th>
                        <th>Inhabilitar</th>
                        <th>Evidencias</th>
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
        <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
            <a href="{{route('entrenamientos.create')}}" class="btn btn-floating btn-large tooltipped green" data-position="left" data-delay="50" data-tooltip="Nuevo Entrenamiento">
            <i class="material-icons">exposure_plus_1</i>
            </a>
        </div>
        </div>
    </div>
</main>
@include('entrenamientos.modals')
@endsection
