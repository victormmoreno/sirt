@extends('layouts.app')

@section('meta-title', 'Sublineas')

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
                            Sublineas {{config('app.name')}} 
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li class="active">Sublineas</li>
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
                                            Sublineas {{ config('app.name')}}
                                        </span>
                                    </div>
                                </div>
                                <div class="col s12 l2">
                                    <div class="click-to-toggle show-on-large hide-on-med-and-down">
                                        <a href="{{route('sublineas.create')}}" class="waves-effect waves-light btn-large"><i class="material-icons left">add_circle</i>Nueva Sublinea</a>
                                    </div>
                                </div>
                            </div>
                            <div class="divider"></div> 
                            <br>
                            <table class="display responsive-table" id="sublineas_table" width="100%">
                                <thead>
                                    <th>Nombre Sublinea</th>
                                    <th>Lineas</th>
                                    <th>Editar</th> 
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
                    <a href="{{route('sublineas.create')}}"  class="btn tooltipped btn-floating btn-large green" data-position="left" data-delay="50" data-tooltip="Nueva Sublinea">
                         <i class="material-icons">add_circle</i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
