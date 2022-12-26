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
                        Talleres de fortalecimiento
                    </h5>
                </div>
                <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li class="active">Talleres de fortalecimiento</li>
                    </ol>
                </div>
            </div>
            <div class="card">
            <div class="card-content">
                <div class="row">
                <div class="col s12 m12 l12">
                    <div class="row">
                    <div class="col s12 m10 l10">
                        <div class="center-align">
                        <span class="card-title center-align">Talleres de entrenamiento de tecnoparque nodo {{ \NodoHelper::returnNameNodoUsuario() }}</span>
                        </div>
                    </div>
                    </div>
                    <div class="divider"></div>
                    <table id="entrenamientosPorNodo_tableDinamizador" class="display responsive-table datatable-example dataTable">
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
@include('entrenamientos.modals')
@endsection
