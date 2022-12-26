@extends('layouts.app')
@section('meta-title', 'Usuarios')
@section('content')
@php
    $year = Carbon\Carbon::now()->year;
@endphp
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row no-m-t no-m-b">
                    <div class="col s8 m8 l10">
                        <h5 class="left-align hand-of-Sean-fonts orange-text text-darken-3">
                            <i class="material-icons left">
                                supervised_user_circle
                            </i>
                            Usuarios
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li class="active">Usuarios</li>
                        </ol>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="row no-m-t no-m-b">
                            <div class="col s12 m12 l12">
                                <div class="row no-m-t no-m-b">
                                    <div class="col s12 m8 l8">
                                        <div class="center-align hand-of-Sean-fonts orange-text text-darken-3">
                                            @if((session()->has('login_role') && session()->get('login_role') === App\User::IsAdministrador() ))
                                                <span class="card-title center-align">Usuarios de {{config('app.name')}}</span>
                                            @else
                                                <span class="card-title center-align">Usuarios de Tecnoparque nodo {{ \NodoHelper::returnNameNodoUsuario() }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col s12 m4 l4 show-on-large hide-on-med-and-down">
                                        <a  href="{{route('usuario.search')}}" class="waves-effect waves-grey grey darken-1 btn-flat search-tabs-button right show-on-large hide-on-med-and-down">Buscar Usuario</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="divider"></div>
                        <div class="row no-m-t no-m-b search-tabs-row search-tabs-header ">
                            <div class="input-field col s12 m2 l2">
                                <label class="active" for="filter_rol">Rol <span class="red-text">*</span></label>
                                <select  name="filter_rol" id="filter_rol" onchange="UserIndex.showInputs()">
                                    <option value="all" >todos</option>
                                    @forelse($roles as $id => $name)
                                        <option value="{{$name}}">{{$name}}</option>
                                    @empty
                                    <option>No se encontraron Resultados</option>
                                    @endforelse
                                </select>
                            </div>

                            <div class="input-field col s12 m2 l2">
                                <label class="active" for="filter_state">Acceso sistema <span class="red-text">*</span></label>
                                <select name="filter_state" id="filter_state">
                                    <option value="si" >Habilitados</option>
                                    <option value="no" >Inhabilitados</option>
                                    <option value="all" >todos</option>
                                </select>
                            </div>
                            <div class="input-field col s12 m2 l2" id="divyear" style="display:none;">
                                <label class="active" for="filter_year_activo">Año actividad <span class="red-text">*</span></label>
                                <select class="js-states browser-default select2"  name="filter_year_activo" id="filter_year_activo" >
                                    @for ($i=$year; $i >= 2016; $i--)
                                        <option value="{{$i}}" >{{$i}}</option>
                                    @endfor
                                    <option value="all" >todos</option>
                                </select>
                            </div>

                            <div class="col s12 m6 l4 offset-m3 right">
                                <button class="waves-effect waves-grey btn-flat search-tabs-button right" id="download_users"><i class="material-icons">cloud_download</i>Descargar</button>
                                <button class="waves-effect waves-grey btn-flat search-tabs-button right" id="filter_user"><i class="material-icons">search</i>Filtrar</button>
                            </div>
                        </div>
                        <table id="users_data_table" class="display responsive-table datatable-example dataTable" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Tipo Documento</th>
                                    <th>Documento</th>
                                    <th>Usuario</th>
                                    <th>Correo</th>
                                    <th>Celular</th>
                                    <th>Roles</th>
                                    <th>Último Login</th>
                                    <th>Acceso sistema</th>
                                    <th>Detalles</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
                    <a href="{{route('usuario.search')}}"  class="btn tooltipped btn-floating btn-large grey darken-1" data-position="left" data-delay="50" data-tooltip="Buscar Usuario">
                        <i class="material-icons">search</i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
