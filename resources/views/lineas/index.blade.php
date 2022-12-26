@extends('layouts.app')

@section('meta-title', 'Lineas Tecnologicas')

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s8 m8 l10">
                        <h5 class="left-align">
                            <i class="material-icons left">
                                linear_scale
                            </i>
                            Lineas
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li class="active">Lineas</li>
                        </ol>
                    </div>
                </div>
                <div class="card ">
                    <div class="card-content">
                        <div class="row">
                            <div class="row">
                                <div class="col s12 m12 l10">
                                    <div class="center-align">
                                        <span class="card-title center-align">
                                            Lineas {{ config('app.name')}}
                                        </span>
                                    </div>
                                </div>
                                <div class="col s12 l2">
                                    <div class="click-to-toggle show-on-large hide-on-med-and-down">
                                        <a href="{{route('lineas.create')}}" class="waves-effect waves-light btn-large"><i class="material-icons left">add_circle</i>Nueva Linea Tecnológica</a>
                                    </div>
                                </div>
                            </div>
                            <div class="divider"></div>  
                            <br>
                            <table class="display responsive-table" id="linea_administrador_table">
                                <thead>
                                    <th width="15%">Abreviatura</th>
                                    <th width="30%">Linea</th>
                                    <th width="40%">Detalles</th>
                                    <th width="15%">Editar</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
                    <a href="{{route('lineas.create')}}"  class="btn tooltipped btn-floating btn-large green" data-position="left" data-delay="50" data-tooltip="Nueva Linea Tecnológica">
                         <i class="material-icons">add_circle</i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
