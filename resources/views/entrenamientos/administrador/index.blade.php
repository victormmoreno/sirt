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
                    <h5 class="left-align">
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
                    <div class="col s12 m12 l12">
                        <div class="center-align">
                        <span class="card-title center-align">Entrenamientos de Tecnoparque</span>
                        <div class="divider"></div>
                        </div>
                    </div>
                    </div>
                    <div class="input-fiel col s12 m12 l12">
                    <label class="active" for="txtnodo">Nodo <span class="red-text">*</span></label>
                    <select class="initialized" id="txtnodo" name="txtnodo" style="width: 100%" tabindex="-1" onchange="consultarEntrenamientosPorNodo_Administrador(this)">
                        <option value="">Seleccione nodo</option>
                        @foreach($nodos as $nodo)
                        <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                        @endforeach
                    </select>
                    </div>
                    <div class="divider"></div>
                    <table id="entrenamientosPorNodo_tableAdministrador" style="width: 100%" class="display responsive-table datatable-example dataTable">
                    <thead>
                        <tr>
                        <th>Consecutivo</th>
                        <th>Primera Sesion</th>
                        <th>Segunda Sesion</th>
                        <th>Correos</th>
                        <th>Fotos</th>
                        <th>Listado de Asistentes</th>
                        <th>Ideas</th>
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
<div id="modalIdeasEntrenamiento" class="modal modal-fixed-footer">
    <div class="modal-content">
        <center><h4 id="fechasEntrenamiento" class="center-aling"></h4></center>
        <div class="divider"></div>
        <div>
        <table class="striped">
            <thead>
            <tr>
                <th>Idea de Proyecto</th>
                <th>¿Confirmación a los Entrenamientos?</th>
                <th>¿Convocado a Comité?</th>
                <th>Canvas</th>
                <th>Asistencia al Primer Entrenamiento</th>
                <th>Asistencia al Segundo Entrenamiento</th>
            </tr>
            </thead>
            <tbody id="ideasEntrenamiento">

            </tbody>
        </table>
        </div>
    </div>
    <div class="modal-footer  white-text">
        <a href="#!" class="modal-action modal-close waves-effect waves-yellow btn-flat ">Cerrar</a>
    </div>
</div>
@endsection
