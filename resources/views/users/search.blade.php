@extends('layouts.app')

@section('meta-title', 'Usuarios')

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
            <div class="left left-align">
                <h5 class="left-align primary-text">
                    <a class="footer-text left-align" href="{{route('usuario.index')}}">
                    <i class="material-icons left">arrow_back</i>
                    </a>
                    Usuarios | Perfil
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li><a href="{{route('usuario.index')}}">Usuarios</a></li>
                    <li class="active">Buscar Usuario</li>
                </ol>
            </div>
        </div>
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <div class="mailbox-view">
                                        <div class="search-users">
                                            <div class="container">
                                                <br><br>
                                                <h2 class="header center primary-text">Usuarios</h2>
                                                <div class="row center">
                                                    <h5 class="header col s12 light black-text text-lighten-1"> Ingrese los campos para verificar si el usuario está registrado.</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container">
                                            <div class="row">
                                                <div class="col s12">
                                                    <form id="formSearchUser" action="{{ route('usuario.search.user')}}" method="POST">
                                                        {!! csrf_field() !!}
                                                        <div class="row">
                                                            <div class="input-field col s12 m4 l4">
                                                                <select class="js-states browser-default select2" tabindex="-1" style="width: 100%" name="txttype_search" id="txttype_search" onchange="userSearch.changetextLabel()">
                                                                    <option value="1">Número de documento</option>
                                                                    <option value="2">Correo Electrónico</option>
                                                                </select>
                                                            </div>
                                                            <div class="input-field col s12 m8 l8">
                                                                <input type="text" id="txtsearch_user" name="txtsearch_user" class="autocomplete">
                                                                <label for="txtsearch_user">Número de documento</label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="input-field col s6  center-align offset-s3">
                                                                <button  type="submit" class="waves-effect waves-light bg-secondary btn-large"><i class="material-icons right">search</i><span class="Nombre-usuario">Buscar Usuario</span></button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <div id="response-alert"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
