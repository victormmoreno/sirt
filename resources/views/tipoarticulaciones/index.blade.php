@extends('layouts.app')
@section('meta-title', 'Articulaciones PBT')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s8 m8 l9">
                <h5 class="left-align orange-text text-darken-3">
                    <i class="material-icons left">autorenew</i>Articulaciones PBT
                </h5>
            </div>
            <div class="col s4 m4 l3 rigth-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li><a href="{{route('articulaciones.index')}}">Articulaciones PBT</a></li>
                    <li class="active">Tipo Articulaciones</li>
                </ol>
            </div>
        </div>
        <div class="card">
            <div class="card-content">
                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="row">
                            <div class="col s12 m8 l8">
                                <div class="center-align  orange-text text-darken-3">
                                    <span class="card-title center-align">Configuración Articulaciones - Tipo Articulaciones</span>
                                </div>
                            </div>
                            <div class="col s12 m4 l4 ">
                                <a  href="{{route('tipoarticulaciones.create')}}" class="waves-effect waves-grey grey darken-1 white-text btn-flat search-tabs-button right show-on-large hide-on-med-and-down">Nuevo tipo Articulación</a>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class="row search-tabs-row search-tabs-header">
                            <div class="input-field col s12 m2 l2">
                                <label class="active" for="filter_nodo_type_art">Nodo <span class="red-text">*</span></label>
                                <select name="filter_nodo_type_art" id="filter_nodo_type_art">
                                    <option value="all" >todos</option>
                                    @foreach($nodos as $id => $name)
                                        <option value="{{$id}}">{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-field col s12 m2 l2">
                                <label class="active" for="filter_state_type_art">Estado</label>
                                <select  name="filter_state_type_art" id="filter_state_type_art">
                                    <option value="all">Todos</option>
                                    <option value="Ocultar">Ocultar</option>
                                    <option value="Mostrar">Mostrar</option>
                                </select>
                            </div>
                            <div class="col s12 m6 l4 offset-m3 right">
                                <button class="waves-effect waves-grey btn-flat search-tabs-button right" id="filter_type_art"><i class="material-icons">search</i>Buscar</button>
                            </div>
                        </div>
                        <table id="type_art_data_table" class="display responsive-table datatable-example dataTable" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Fecha registro</th>
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
    </div>
</main>
@endsection
