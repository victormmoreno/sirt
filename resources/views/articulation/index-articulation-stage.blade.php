@extends('layouts.app')
@section('meta-title', __('articulation-stage'))
@section('content')
@php
    $year = Carbon\Carbon::now()->year;
@endphp
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="left left-align">
                <h5 class="left-align orange-text text-darken-3">
                    <i class="material-icons left">autorenew</i>{{__('articulation-stage')}}
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">{{ __('Home') }}</a></li>
                    <li class="active">{{__('articulation-stage')}}</li>
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
                                    <div class="col s12 @can('create', App\Models\ArticulationStage::class)  m8 l8 @else m12 l12  @endcan">
                                    <div class="center-align orange-text text-darken-3">
                                        <span class="card-title center-align">{{__('articulation-stage')}} </span>
                                    </div>
                                    </div>
                                    @can('create', App\Models\ArticulationStage::class)
                                        <div class="col s12 m4 l4 ">
                                            <a  href="{{route('articulation-stage.create')}}" class="m-r-lg waves-effect waves-grey grey darken-1 white-text btn-flat search-tabs-button right show-on-large hide-on-med-and-down">{{__('New ArticulationStage')}}</a>
                                        </div>
                                    @endcan
                                </div>
                                <div class="divider"></div>
                                <div class="row search-tabs-row search-tabs-header">
                                        @can('viewNodes', App\Models\ArticulationStage::class)
                                            <div class="input-field col s12 m2 l2">
                                                <label class="active" for="filter_node_articulationStage">Nodo <span class="red-text">*</span></label>
                                                <select name="filter_node_articulationStage" id="filter_node_articulationStage">
                                                    <option value="all" >todos</option>
                                                    @foreach($nodos as $id => $name)
                                                        <option value="{{$id}}">{{$name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endcan
                                        <div class="input-field col s12 m2 l1">
                                            <label class="active" for="filter_year_articulationStage">Año <span class="red-text">*</span></label>
                                            <select name="filter_year_articulationStage" id="filter_year_articulationStage">
                                                @for ($i=$year; $i >= 2016; $i--)
                                                    <option value="{{$i}}" >{{$i}}</option>
                                                @endfor
                                                <option value="all" >todos</option>
                                            </select>
                                        </div>
                                        <div class="input-field col s12 m2 l1">
                                            <label class="active" for="filter_status_articulationStage">{{__('Status')}} <span class="red-text">*</span></label>
                                            <select name="filter_status_articulationStage" id="filter_status_articulationStage">
                                                <option value="all" >todos</option>
                                                <option value="1" >Abierto</option>
                                                <option value="0" >Cerrado</option>
                                            </select>
                                        </div>
                                        <div class="col s12 m6 l4 offset-m3 right">
                                            @can('downloadReports', App\Models\ArticulationStage::class)
                                                <button class="waves-effect waves-grey btn-flat search-tabs-button right" id="download_articulationStage"><i class="material-icons">cloud_download</i>{{__('Download')}}</button>
                                            @endcan
                                            <button class="waves-effect waves-grey btn-flat search-tabs-button right" id="filter_articulationStage"><i class="material-icons">search</i>{{__('Filter')}}</button>
                                        </div>
                                    </div>
                                <table id="articulationStage_data_table" class="highlight  responsive-table datatable-example dataTable" style="width: 100%">
                                        <thead class="orange accent-2 border-bottom-0 border-dark">
                                        <tr>
                                            <th>{{__('Node')}}</th>
                                            <th>{{__('Name articulation-stage')}}</th>
                                            <th>{{__('Name articulation')}}</th>
                                            <th>{{__('Description')}}</th>
                                            <th>{{__('Status')}} / {{__('Phase')}}</th>
                                            <th>{{__('Start Date')}}</th>
                                            <th>{{__('Process')}}</th>
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

