@extends('layouts.app')
@section('meta-title', 'Nodos')

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
            <div class="left left-align">
                <h5 class="left-align primary-text">
                    <i class="material-icons left">domain</i>Nodos
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li class="active">Nodos</li>
                </ol>
            </div>
        </div>
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="card ">
                    <div class="card-content">
                        <div class="row">
                            <div class="row">
                                <div class="col s12 @can('create', \App\Models\Nodo::class) m8 l8 @else m12 l12 @endcan">
                                    <div class="center-align">
                                        <span class="card-title center-align primary-text">
                                            Nodos {{ config('app.name')}}
                                        </span>
                                    </div>
                                </div>
                                @can('create', \App\Models\Nodo::class)
                                    <div class="col s12 m4 l4 show-on-large hide-on-med-and-down">
                                        <a  href="{{route('nodo.create')}}" class="waves-effect waves-grey bg-secondary white-text btn-flat search-tabs-button right show-on-large hide-on-med-and-down">Nuevo Nodo</a>
                                    </div>
                                @endcan
                            </div>
                            <div class="divider">
                            </div>
                                @can('downloadAll', \App\Models\Nodo::class)
                                    <div class="right-align">
                                        <a href="{{route('excel.excelnodo')}}" class="waves-effect waves-light btn btn-flat"><i class="material-icons right">cloud_download</i>Descargar</a>
                                    </div>
                                @endcan
                                <table class="display responsive-table datatable-example dataTable" id="nodos_table" style="width: 100%">
                                    <thead class="bg-primary white-text">
                                        <th >Centro de Formación</th>
                                        <th >Nombre</th>
                                        <th >Dirección</th>
                                        <th >Ubicación</th>
                                        <th >Detalle</th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                </div>
                <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
                    <a href="{{route('nodo.create')}}"  class="btn tooltipped btn-floating btn-large bg-secondary" data-position="left" data-delay="50" data-tooltip="Nuevo Nodo">
                         <i class="material-icons">add_circle</i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

