@extends('layouts.app')
@section('meta-title', 'Taller de fortalecimiento')
@section('meta-content', 'Taller de fortalecimiento')
@section('meta-keywords', 'Taller de fortalecimiento')
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
                        Taller de fortalecimiento
                    </h5>
                </div>
                <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li class="active">Taller de fortalecimiento</li>
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
                                <span class="card-title center-align">Talleres de fortalecimiento de tecnoparque</span>
                                <div class="divider"></div>
                            </div>
                        </div>
                    </div>
                    <div class="input-fiel col s12 m12 l12">
                    <label class="active" for="filter_nodo">Nodo <span class="red-text">*</span></label>
                    <select class="initialized" id="filter_nodo" name="filter_nodo" style="width: 100%" tabindex="-1" onchange="consultarEntrenamientosPorNodo()">
                        <option value="">Seleccione nodo</option>
                        @foreach($nodos as $nodo)
                        <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                        @endforeach
                    </select>
                    </div>
                    <div class="divider"></div>
                    <table id="entrenamientosPorNodo_table" style="width: 100%" class="display responsive-table datatable-example dataTable">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Fecha</th>
                            <th>Ideas</th>
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
        </div>
    </div>
</main>
@include('talleres.modals')
@endsection
