@extends('layouts.app')
@section('meta-title', 'Grupos de Investigación')
@section('meta-content', 'Grupos de Investigación')
@section('meta-keywords', 'Grupos de Investigación')
@section('content')
    <main class="mn-inner inner-active-sidebar">
        <div class="content">
            <div class="row no-m-t no-m-b">
                <div class="col s12 m12 l12">
                    <div class="row">
                        <h5 class="left left-align primary-text">
                            <i class="material-icons left">
                                group_work
                            </i>
                            Grupos de investigación
                        </h5>
                        <div class="right-align show-on-large hide-on-med-and-down">
                            <ol class="breadcrumbs">
                                <li><a href="{{ route('home') }}">Inicio</a></li>
                                <li class="active">Grupos de investigación</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <div class="row">
                                        <div
                                            class="col s12 {{ auth()->user()->can('create', App\Models\GrupoInvestigacion::class)? 'm8 l8': 'm12 l12' }}">
                                            <div class="center-align">
                                                <span class="card-title center-align primary-text">Grupos de Investigación
                                                    de Tecnoparque</span>
                                            </div>
                                        </div>
                                        @can('create', App\Models\GrupoInvestigacion::class)
                                            <div class="col s12 m4 l4 right">
                                                <a href="{{ route('grupo.create') }}"
                                                    class="btn bg-secondary right show-on-large hide-on-med-and-down">Nuevo
                                                    grupo de investigación</a>
                                            </div>
                                        @endcan
                                    </div>
                                    <div class="divider"></div>
                                    <table style="width: 100%" id="grupoDeInvestigacionTecnoparque_table"
                                        class="display responsive-table datatable-example dataTable">
                                        <thead>
                                            <tr>
                                                <th>Código del Grupo de Investigación</th>
                                                <th>Nombre del Grupo de Investigación</th>
                                                <th>Ciudad</th>
                                                <th>Tipo de Grupo de Investigación</th>
                                                <th>Institución</th>
                                                <th>Clasificación de Colciencias</th>
                                                <th>Detalles</th>
                                                <th>Editar</th>
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
    <div id="detalleDeUnGrupoDeInvestigacion" class="modal">
        <div class="modal-content">
            <center>
                <h4 id="modalDetalleDeUnGrupoDeInvestigacion_titulo" class="center-aling"></h4>
            </center>
            <div class="divider"></div>
            <div id="modalDetalleDeUnGrupoDeInvestigacion_detalle_empresa"></div>
        </div>
        <div class="modal-footer white-text">
            <a href="#!" class="modal-action modal-close waves-effect waves-yellow btn-flat">Cerrar</a>
        </div>
    </div>
@endsection
