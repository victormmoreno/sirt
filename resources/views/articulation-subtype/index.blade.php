@extends('layouts.app')
@section('meta-title', __('articulation-subtype'))
@section('content')
    @php
        $year = Carbon\Carbon::now()->year;
    @endphp
    <main class="mn-inner inner-active-sidebar">
        <div class="content">
            <div class="row no-m-t no-m-b">
                <div class="left left-align">
                    <h5 class="left-align orange-text text-darken-3">
                        <i class="material-icons left">autorenew</i>{{__('articulation-subtype')}}
                    </h5>
                </div>
                <div class="right right-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">{{ __('Home') }}</a></li>
                        <li class="active">{{__('articulation-subtype')}}</li>
                    </ol>
                </div>
            </div>
            <div class="row no-m-t no-m-b">
                <div class="col s12 m12 l12">
                    <div class="card">
                        <div class="card-content">
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <div class="row">
                                        <div class="col s12 m8 l8">
                                            <div class="center-align orange-text text-darken-3">
                                                <span class="card-title center-align">{{__('articulation-subtype')}} </span>
                                            </div>
                                        </div>
                                        <div class="col s12 m4 l4 ">
                                            @can('create', App\Models\ArticulationSubtype::class)
                                                <a  href="{{route('tiposubarticulaciones.create')}}" class="m-r-lg waves-effect waves-grey grey darken-1 white-text btn-flat search-tabs-button right show-on-large hide-on-med-and-down">{{__('New ArticulationSubtype')}}</a>
                                            @endcan
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                    <div class="row search-tabs-row search-tabs-header">
                                        @can('viewNodes', App\Models\ArticulationStage::class)
                                            <div class="input-field col s12 m2 l2">
                                                <label class="active" for="filter_node_artuculation_subtype">Nodo <span class="red-text">*</span></label>
                                                <select name="filter_node_artuculation_subtype" id="filter_node_artuculation_subtype">
                                                    <option value="all" >todos</option>
                                                    @foreach($nodos as $id => $name)
                                                        <option value="{{$id}}">{{$name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endcan
                                        <div class="input-field col s12 m2 l1">
                                            <label class="active" for="filter_state_artuculation_subtype">{{__('Status')}} <span class="red-text">*</span></label>
                                            <select name="filter_state_artuculation_subtype" id="filter_state_artuculation_subtype">
                                                <option value="all">Todos</option>
                                                <option value="Ocultar">Ocultar</option>
                                                <option value="Mostrar">Mostrar</option>
                                            </select>
                                        </div>
                                        <div class="col s12 m6 l4 offset-m3 right">
                                            <button class="waves-effect waves-grey btn-flat search-tabs-button right" id="filter_articulation_subtype"><i class="material-icons">search</i>{{__('Filter')}}</button>
                                        </div>
                                    </div>
                                    <table id="articulation_subtype_data_table" class="display responsive-table datatable-example dataTable" style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th>Fecha registro</th>
                                            <th>Tipo Articulación</th>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>Entidad</th>
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
                    @if((session()->has('login_role') && session()->get('login_role') === App\User::IsArticulador()))
                        <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
                            <a href="{{route('articulation-stage.create')}}"  class="btn tooltipped btn-floating btn-large grey" data-position="left" data-delay="50" data-tooltip="Nueva Articulación">
                                <i class="material-icons">add</i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection

