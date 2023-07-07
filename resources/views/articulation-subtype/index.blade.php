@extends('layouts.app')
@section('meta-title', __('articulation-subtype'))
@section('content')
    @php
        $year = Carbon\Carbon::now()->year;
    @endphp
    <main class="mn-inner inner-active-sidebar">
        <div class="content">
            <div class="row no-m-t no-m-b m-r-lg m-l-lg">
                <div class="left left-align">
                    <h5 class="left-align primary-text">
                        <i class="material-icons left">settings</i>{{__('articulation-subtype')}}
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
                                            <div class="center-align primary-text">
                                                <span class="card-title center-align">{{__('articulation-subtype')}} </span>
                                            </div>
                                        </div>
                                        <div class="col s12 m4 l4 ">
                                            @can('create', App\Models\ArticulationSubtype::class)
                                                <a  href="{{route('tiposubarticulaciones.create')}}" class="m-r-lg waves-effect bg-secondary white-text btn-flat search-tabs-button right show-on-large hide-on-med-and-down">{{__('New ArticulationSubtype')}}</a>
                                            @endcan
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                    <div class="row search-tabs-row search-tabs-header">
                                        @can('viewNodes', App\Models\ArticulationStage::class)
                                            <div class="input-field col s12 m12 l3">
                                                <label class="active" for="filter_node_artuculation_subtype">Nodo <span class="red-text">*</span></label>
                                                <select multiple tabindex="-1" style="width: 100%" name="filter_node_artuculation_subtype" id="filter_node_artuculation_subtype" required>
                                                    <option value="all">todos</option>
                                                    @forelse ($nodos as $nodo)
                                                        <option value="{{ $nodo->id }}">{{ $nodo->nodos }}</option>
                                                    @empty
                                                        <option>{{__('No results found')}}</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        @endcan
                                        <div class="input-field col s12 m12 l1">
                                            <label class="active" for="filter_state_artuculation_subtype">{{__('Status')}} <span class="red-text">*</span></label>
                                            <select name="filter_state_artuculation_subtype" id="filter_state_artuculation_subtype">
                                                <option value="all">Todos</option>
                                                <option value="Ocultar">Ocultar</option>
                                                <option value="Mostrar">Mostrar</option>
                                            </select>
                                        </div>
                                        <div class="col s12 m6 l4 offset-m3 right">
                                            <button class="waves-effect waves-grey bg-secondary white-text btn-flat search-tabs-button right" id="filter_articulation_subtype"><i class="material-icons">search</i>{{__('Filter')}}</button>
                                        </div>
                                    </div>
                                    <table id="articulation_subtype_data_table" class="display responsive-table datatable-example dataTable" style="width: 100%">
                                        <thead class="bg-primary white-text">
                                            <tr>
                                                <th>{{__('Created_at')}}</th>
                                                <th>{{__('articulation-type')}}</th>
                                                <th>{{__('Name')}}</th>
                                                <th>{{__('Description')}}</th>
                                                <th>{{__('Entities')}}</th>
                                                <th>{{__('Status')}}</th>
                                                <th>{{__('Details')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @can('create', App\Models\ArticulationSubtype::class)
                        <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
                            <a href="{{route('tiposubarticulaciones.create')}}"  class="btn tooltipped btn-floating btn-large bg-secondary" data-position="left" data-delay="50" data-tooltip="{{__('New ArticulationSubtype')}}">
                                <i class="material-icons">add</i>
                            </a>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </main>
@endsection

