@extends('layouts.app')

@section('meta-title', 'Materiales')

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
            <h5 class="left left-align primary-text">
                <i class="material-icons left primary-text">
                    local_library
                </i>
                Materiales de Formación
            </h5>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li class="active">Materiales</li>
                </ol>
            </div>
        </div>
        <div class="row no-m-t no-m-b">
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12 m4 l4">
                            <div class="center-align">
                                <span class="card-title center-align primary-text">
                                    Materiales de Formación {{ config('app.name')}}
                                </span>
                            </div>
                        </div>
                        @can('create', App\Models\Material::class)
                            <a href="{{route('material.create')}}" class="waves-effect waves-grey bg-secondary white-text btn-flat right show-on-large hide-on-med-and-down m-l-xs">Nuevo Material</a>
                        @endcan
                        @can('import', App\Models\Material::class)
                            <a href="{{route('materiales.import')}}" class="waves-effect waves-grey bg-secondary-darken white-text btn-flat right show-on-large hide-on-med-and-down m-l-xs">Importar materiales</a>
                        @endcan
                        @can('download', App\Models\Material::class)
                            <a href="{{route('download.materiales')}}" class="waves-effect waves-grey bg-secondary-lighten white-text btn-flat right show-on-large hide-on-med-and-down ml-x">Descargar materiales</a>
                        @endcan
                    </div>
                    <div class="row">
                        @can('showFiltersForAdmins', App\Models\Material::class)
                            @include('materiales.filtros.admins')
                        @endcan
                        <br>
                        <table class="display responsive-table" id="materiales_table"  style="width: 100%">
                            <thead>
                                <th width="15%">Fecha Compra</th>
                                <th width="20%">Linea Tecnológica</th>
                                <th width="20%">Código de Material</th>
                                <th width="30%">Nombre de Material</th>
                                <th width="15%">Presentación</th>
                                <th width="15%">Medida</th>
                                <th width="10%">Tamaño presentacion o venta/paquete</th>
                                <th width="20%">Valor Unitario</th>
                                <th width="20%">Valor total</th>
                                <th width="15%">Detalle</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @can('create', App\Models\Material::class)
            <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
                <a href="{{route('material.create')}}"  class="btn tooltipped btn-floating btn-large green" data-position="left" data-delay="50" data-tooltip="Nuevo Material">
                    <i class="material-icons">add_circle</i>
                </a>
            </div>
        @endcan
    </div>
</main>
@endsection
@push('script')
    <script>
        @if(session()->get('login_role') != App\User::IsAdministrador() && session()->get('login_role') != App\User::IsActivador())
            selectMaterialesPorNodo.selectMaterialesForNodo();
        @endif
    </script>
@endpush