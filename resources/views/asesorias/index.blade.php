@extends('layouts.app')

@section('meta-title', 'Asesoria y Usos' )

@section('content')
@php
    $yearNow = Carbon\Carbon::now()->year;
@endphp

<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
            <div class="left left-align">
                <h5 class="left-align primary-text">
                    <i class="material-icons left">domain</i> Asesorías y usos
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">{{ __('Home') }}</a></li>
                    <li class="active">Asesoría y uso</li>
                </ol>
            </div>
        </div>
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="card mailbox-content">
                    <div class="card-content">
                        <div class="row no-m-t no-m-b">
                            <div class="col s12 m12 l12">
                                <div class="mailbox-view">
                                    <div class="mailbox-view-header">
                                        <span class="card-title primary-text center center-aligm">
                                            Asesorias y usos de Infraestructura
                                        </span>
                                        @canany(['search', 'create', 'indicadores'], \App\Models\UsoInfraestructura::class)
                                        <div class="right mailbox-buttons">
                                            <div class=" show-on-large hide-on-med-and-down">
                                                @can('create', App\Models\UsoInfraestructura::class)
                                                    <a href="{{route('asesorias.create')}}" class="waves-effect bg-secondary white-text btn-flat search-tabs-button right show-on-large hide-on-med-and-down">Nueva Asesoria</a>
                                                @endcan
                                                @can('search', App\Models\UsoInfraestructura::class)
                                                    <a href="{{route('asesorias.search')}}" class="waves-effect bg-info white-text btn-flat search-tabs-button right show-on-large hide-on-med-and-down">Buscar Asesoria</a>
                                                @endcan
                                                @can('indicadores', App\Models\UsoInfraestructura::class)
                                                    <a href="{{route('asesorias.indicadores')}}" class="waves-effect bg-tertiary white-text btn-flat search-tabs-button right show-on-large hide-on-med-and-down">Indicadores</a>
                                                @endcan
                                            </div>
                                        </div>
                                        @endcanany
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class=" mailbox-view mailbox-text">
                            <div class="row no-m-t no-m-b search-tabs-row search-tabs-header">
                                @can('moduleType', \App\Models\UsoInfraestructura::class)
                                    <div class="input-field col s12 m6 l2">
                                        <label class="active" for="filter_module">Tipo Asesoria <span class="red-text">*</span></label>
                                        <select name="filter_module" id="filter_module">
                                            @forelse($modules as $id => $name)
                                                <option value="{{$id}}" @if($loop->first) selected @endif>{{$name}}</option>
                                            @empty
                                                <option>No se encontraron Resultados</option>
                                            @endforelse
                                        </select>
                                    </div>
                                @endcan
                                @can('listNodes', \App\Models\UsoInfraestructura::class)
                                    <div class="input-field col s12 m6 l2">
                                        <label class="active" for="filter_node">Nodo <span class="red-text">*</span></label>
                                        <select multiple tabindex="-1" style="width: 100%" name="filter_node[]" id="filter_node">
                                            @forelse($nodos as $nodo)
                                                <option value="{{$nodo->id}}" @if($loop->first) selected @endif>{{$nodo->nodos}}</option>
                                            @empty
                                                <option>No se encontraron Resultados</option>
                                            @endforelse
                                            <option value="all" >todos</option>
                                        </select>
                                    </div>
                                @endcan
                                <div class="input-field col s12 m6 l2">
                                    <input type="date" id="filter_start_date" name="filter_start_date" value="{{Carbon\Carbon::create($yearNow, 1, 1)->toDateString() }}">
                                    <label  for="start_date">Desde <span class="red-text">*</span></label>
                                </div>
                                <div class="input-field col s12 m6 l2">
                                    <input type="date" id="filter_end_date" name="filter_end_date" value="{{Carbon\Carbon::now()->toDateString()}}">
                                    <label  for="end_date">Hasta <span class="red-text">*</span></label>
                                </div>
                                <div class="col s12 m12 l4  right">
                                    @can('export', \App\Models\UsoInfraestructura::class)
                                    <button class="waves-effect waves-grey bg-secondary-lighten white-text btn-flat search-tabs-button right p-h-md" id="download_asesories"><i class="material-icons">cloud_download</i>Descargar</button>
                                    @endcan
                                    <button class="waves-effect  waves-grey bg-secondary white-text btn-flat search-tabs-button right p-h-md" id="filter_asesories"><i class="material-icons">search</i>Filtrar</button>
                                </div>
                            </div>
                            <table class="display responsive-table datatable-example dataTable" id="asesorie_data_table" width="100%">
                                <thead class="bg-primary white-text">
                                    <th width="10%">Nodo</th>
                                    <th width="10%">Código</th>
                                    <th width="10%">Fecha</th>
                                    <th width="20%">Asesor</th>
                                    <th width="10%">Tipo Asesoria</th>
                                    <th width="35%">Nombre</th>
                                    <th width="10%">Fase</th>
                                    <th width="5%">Detalles</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                @canany(['search', 'create'], \App\Models\UsoInfraestructura::class)
                <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up" style="bottom: 45px; right: 24px;">
                    <a class="btn-floating btn-large bg-primary">
                        <i class="large material-icons">arrow_upward</i>
                    </a>
                    <ul>
                        @can('search', \App\Models\UsoInfraestructura::class)
                            <li><a href="{{route('asesorias.search')}}"  class="btn-floating tooltipped bg-info white-text" data-position="left" data-delay="50" data-tooltip="Buscar asesoria" style="transform: scaleY(0.4) scaleX(0.4) translateY(40px) translateX(0px); opacity: 0;"><i class="material-icons">search</i></a></li>
                        @endcan
                        @can('create', \App\Models\UsoInfraestructura::class)
                            <li><a href="{{route('asesorias.create')}}"  class="btn-floating tooltipped bg-secondary white-text" data-position="left" data-delay="50" data-tooltip="{{session()->has('login_role') == App\User::IsExperto() ? 'Nueva Asesoria' : 'Nuevo uso de Infraestructura'}}" style="transform: scaleY(0.4) scaleX(0.4) translateY(40px) translateX(0px); opacity: 0;"><i class="material-icons">add_box</i></a></li>
                        @endcan
                    </ul>
                </div>
                @endcanany
            </div>
        </div>
    </div>
</main>

@endsection
@push('script')
@endpush
