@extends('layouts.app')

@section('meta-title', 'Materiales')

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s8 m8 l10">
                        <h5 class="left-align hand-of-Sean-fonts orange-text text-darken-3">
                            <i class="material-icons left orange-text text-darken-3">
                                local_library
                            </i>
                            Materiales de Formación
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align  show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li class="active">Materiales</li>
                        </ol>
                    </div>
                </div>
                <div class="card ">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12 m8 l8">
                                <div class="center-align">
                                    <span class="card-title center-align hand-of-Sean-fonts orange-text text-darken-3">
                                        Materiales de Formación {{ config('app.name')}}
                                    </span>
                                </div>
                            </div>
                            @can('create', App\Models\Material::class)
                                <div class="col s12 m4 l4 right">
                                    <a  href="{{route('material.create')}}" class="waves-effect waves-grey grey darken-1 white-text btn-flat search-tabs-button right show-on-large hide-on-med-and-down">Nuevo Material</a>
                                </div>
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
                @can('create', App\Models\Material::class)
                    <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
                        <a href="{{route('material.create')}}"  class="btn tooltipped btn-floating btn-large green" data-position="left" data-delay="50" data-tooltip="Nuevo Material">
                            <i class="material-icons">add_circle</i>
                        </a>
                    </div>
                @endcan
            </div>
        </div>
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