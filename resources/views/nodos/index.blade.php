@extends('layouts.app')

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s8 m8 l10">
                        <h5 class="left-align">
                            <i class="material-icons left">
                                domain
                            </i>
                            Nodos
        
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li class="active">Nodos</li>
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
                                            Nodos {{ config('app.name')}}
                                        </span>
                                    </div>
                                </div>
                                <div class="col s12 l2">
                                    <div class="click-to-toggle show-on-large hide-on-med-and-down">
                                        <a href="{{route('nodo.create')}}" class="waves-effect waves-light btn-large"><i class="material-icons left">add_circle</i>Nuevo Nodo</a>
                                    </div>
                                </div>
                            </div>
                            <div class="divider">
                            </div>
                            <br>
                                <table class="display responsive-table" id="nodos_table">
                                    <thead>
                                        <th >Centro de Formación</th>
                                        <th >Nombre</th>
                                        <th >Dirección</th>
                                        <th >Ubicación</th>
                                        <th >Detalle</th>
                                        <th >Editar</th>
                                    </thead>
                                </table>
                        </div>
                    </div>
                </div>
                <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
                    <a href="{{route('nodo.create')}}"  class="btn tooltipped btn-floating btn-large green" data-position="left" data-delay="50" data-tooltip="Nuevo Nodo">
                         <i class="material-icons">add_circle</i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

