@extends('layouts.app')
@section('meta-title', 'Articulaciones PBT')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
            <div class="left left-align">
                <h5 class="left-align primary-text">
                    <i class="material-icons left">settings</i>{{__('articulation-type')}}
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">{{ __('Home') }}</a></li>
                    <li class="active">{{__('articulation-type')}}</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12 m8 l8">
                                <div class="center-align primary-text">
                                    <span class="card-title center-align">Configuración Articulaciones - {{__('articulation-type')}}</span>
                                </div>
                            </div>
                            <div class="col s12 m4 l4 ">
                                @can('create', App\Models\ArticulationType::class)
                                <a  href="{{route('tipoarticulaciones.create')}}" class="waves-effect bg-secondary white-text btn-flat search-tabs-button right show-on-large hide-on-med-and-down">Nueva {{__('articulation-type')}}</a>
                                @endcan
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class="row search-tabs-row search-tabs-header">
                            <div class="input-field col s12 m2 l2">
                                <label class="active" for="filter_state_type_art">Estado</label>
                                <select  name="filter_state_type_art" id="filter_state_type_art">
                                    <option value="all">Todos</option>
                                    <option value="Ocultar">Ocultar</option>
                                    <option value="Mostrar">Mostrar</option>
                                </select>
                            </div>
                            <div class="col s12 m6 l4 offset-m3 right">
                                <button class="waves-effect waves-grey bg-secondary white-text btn-flat search-tabs-button right" id="filter_type_art"><i class="material-icons">search</i>Filtrar</button>
                            </div>
                        </div>
                        <table id="type_art_data_table" class="display responsive-table datatable-example dataTable" style="width: 100%">
                            <thead class="bg-primary white-text">
                                <tr>
                                    <th>Fecha registro</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                    <th>Detalles</th>
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
</main>
@endsection
