@extends('layouts.app')
@section('meta-title', 'Equipos')
@section('meta-content', 'Equipos')
@section('meta-keywords', 'Equipos')

@section('content')
    <main class="mn-inner inner-active-sidebar">
        <div class="content">
            <div class="row no-m-t no-m-b">
                <div class="col s12 m12 l12">
                    <div class="row no-m-t no-m-b m-r-lg m-l-lg">
                        <h5 class="left left-align primary-text">
                            <i class="material-icons left primary-text">account_balance_wallet</i>
                            Equipos
                        </h5>
                        <div class="right rigth-align show-on-large hide-on-med-and-down">
                            <ol class="breadcrumbs">
                                <li><a href="{{ route('home') }}">Inicio</a></li>
                                <li class="active">Equipos</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card ">
                        <div class="card-content">
                            <div class="row">
                                <div class="col s12 m8 l8">
                                    <div class="center-align">
                                        <span class="card-title center-align primary-text">
                                            Equipos de tecnoparque
                                        </span>
                                    </div>
                                </div>
                                @can('create', App\Models\Equipo::class)
                                    <a href="{{ route('equipo.create') }}"
                                        class="waves-effect waves-grey bg-secondary white-text btn-flat right show-on-large hide-on-med-and-down m-l-xs">Nuevo
                                        Equipo</a>
                                @endcan
                                @can('import', App\Models\Equipo::class)
                                    <a href="{{ route('equipo.import') }}"
                                        class="waves-effect waves-grey bg-secondary-darken white-text btn-flat right show-on-large hide-on-med-and-down m-l-xs">Importar
                                        equipos</a>
                                @endcan
                            </div>
                            <div class="divider"></div>
                            <div class="row">
                                @can('showOptionsForAdmin', App\Models\Equipo::class)
                                    <div class="input-field col s12 m2 l2">
                                        <label class="active" for="filter_nodo">Nodo <span class="red-text">*</span></label>
                                        <select class="js-states browser-default select2" name="filter_nodo" id="filter_nodo">
                                            @forelse($nodos as $id => $name)
                                                <option value="{{ $id }}">{{ $name }}</option>
                                            @empty
                                                <option>No se encontraron Resultados</option>
                                            @endforelse
                                            <option value="all">todos</option>
                                        </select>
                                    </div>
                                @endcan
                                <div class="input-field col s12 m2 l2">
                                    <label class="active" for="filter_state">Estado <span class="red-text">*</span></label>
                                    <select name="filter_state" id="filter_state">
                                        <option value="si">Habilitados</option>
                                        <option value="no">Inhabilitados</option>
                                        <option value="all">todos</option>
                                    </select>
                                </div>
                                <div class="col s12 m6 l4 offset-m3 right">
                                    <button class="waves-effect waves-grey btn-flat search-tabs-button right"
                                        id="download_equipos"><i
                                            class="material-icons left">cloud_download</i>Descargar</button>
                                    <button class="waves-effect waves-grey btn-flat search-tabs-button right"
                                        id="filter_equipo"><i class="material-icons left">search</i>Buscar</button>
                                </div>
                            </div>
                            <br>
                            @include('equipo.table')
                        </div>
                    </div>
                </div>
            </div>
            @can('create', App\Models\Empresa::class)
                <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
                    <a href="{{ route('equipo.create') }}" class="btn tooltipped btn-floating btn-large green"
                        data-position="left" data-delay="50" data-tooltip="Nuevo equipo">
                        <i class="material-icons">add</i>
                    </a>
                </div>
            @endcan
        </div>
    </main>
    <div class="modal modal-equipo">
        <div class="modal-content">
            <center>
                <h4 id="titulo" class="center-aling"></h4>
            </center>
            <div class="divider"></div>
            <div id="detalle_equipo"></div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-yellow btn-flat ">Cerrar</a>
        </div>
    </div>
@endsection
