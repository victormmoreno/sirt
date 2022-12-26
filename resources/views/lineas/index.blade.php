@extends('layouts.app')

@section('meta-title', 'Lineas Tecnologicas')

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
            <div class="left left-align">
                <h5 class="left-align primary-text">
                    <i class="material-icons left">linear_scale</i>Líneas
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li class="active">Líneas</li>
                </ol>
            </div>
        </div>
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="card ">
                    <div class="card-content">
                        <div class="row">
                            <div class="row">
                                <div class="col s12 m12 l10">
                                    <div class="center-align">
                                        <span class="card-title center-align primary-text">
                                            Lineas {{ config('app.name')}}
                                        </span>
                                    </div>
                                </div>
                                <div class="col s12 l2">
                                    <a href="{{route('lineas.create')}}" class="waves-effect waves-grey bg-secondary white-text btn-flat search-tabs-button right show-on-large hide-on-med-and-down">Nueva Linea Tecnológica</a>
                                </div>
                            </div>
                            <div class="divider"></div>
                            <br>
                            <table class="display responsive-table datatable-example dataTable" id="linea_administrador_table" style="width: 100%">
                                <thead class="bg-primary white-text">
                                    <th width="40%">Abreviatura</th>
                                    <th width="50%">Linea</th>
                                    <th width="5%">Detalles</th>
                                    <th width="5%">Editar</th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
                    <a href="{{route('lineas.create')}}"  class="btn tooltipped btn-floating btn-large bg-secondary" data-position="left" data-delay="50" data-tooltip="Nueva Linea Tecnológica">
                         <i class="material-icons">add_circle</i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
