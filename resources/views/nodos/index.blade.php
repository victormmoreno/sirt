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
                <div class="card mailbox-content">
                    <div class="row no-m-t no-m-b">
                        <div class="col s12 m12 l12">
                            <div class="mailbox-view">
                                <div class="mailbox-view-header">
                                    <span class="card-title primary-text center">
                                        Nodos {{ config('app.name')}}
                                    </span>
                                    @can('create', \App\Models\Nodo::class)
                                    <div class="right mailbox-buttons">
                                        <div class=" show-on-large hide-on-med-and-down">
                                            <a  href="{{route('nodo.create')}}" class="waves-effect bg-secondary white-text btn-flat search-tabs-button right show-on-large hide-on-med-and-down"> Nuevo Nodo</a>
                                        </div>
                                    </div>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class=" mailbox-view mailbox-text">
                        <div class="row no-m-t no-m-b search-tabs-row search-tabs-header ">
                            @can('downloadAll', \App\Models\Nodo::class)
                                <div class="right-align">
                                    <a href="{{route('excel.excelnodo')}}" class="waves-effect bg-secondary-lighten white-text  waves-light btn btn-flat"><i class="material-icons right">cloud_download</i>Descargar</a>
                                </div>
                            @endcan
                        </div>
                        <table class="display dark_mode responsive-table datatable-example dataTable" id="nodos_table" style="width: 100%">
                            <thead class="bg-primary white-text">
                                <th >Centro de Formación</th>
                                <th >Nombre</th>
                                <th >Dirección</th>
                                <th >Ubicación</th>
                                <th >Estado</th>
                                <th >Detalle</th>
                            </thead>
                        </table>
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

