@extends('layouts.app')
@section('meta-title', 'Ideas de proyecto')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <h5 class="left primary-text">
                        <a class="primary-text" href="{{route('idea.index')}}">
                            <i class="material-icons left">
                                arrow_back
                            </i>
                        </a>
                        Empresas
                    </h5>
                    <div class="right right-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('idea.index')}}">Ideas</a></li>
                            <li class="active">Buscar idea</li>
                        </ol>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div class="mailbox-view">
                                    <div class="search-users">
                                        <div class="container">
                                            <h2 class="header center primary-text">Ideas</h2>
                                            <div class="row center">
                                                <h5 class="header col s12 light black-text text-lighten-1">Ingrese el criterio de búsqueda para verificar si la idea se encuentra registrada.</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col s12">
                                                <form id="formSearchIdeas" action="{{ route('idea.search.rq') }}" method="POST">
                                                    {!! csrf_field() !!}
                                                    <div class="row">
                                                        <div class="input-field col s12 m4 l4">
                                                            <select class="js-states browser-default select2" tabindex="-1" style="width: 100%" name="txttype_search" id="txttype_search">
                                                                <option value="codigo_idea">Código de idea</option>
                                                                {{-- <option value='JSON_EXTRACT(datos_idea, "$.nombre_proyecto.answer")'>Nombre de idea</option> --}}
                                                                <option value="users.nombres">Nombres del talento</option>
                                                                <option value="users.apellidos">Apellidos del talento</option>
                                                                <option value="ug.nombres">Nombres del experto</option>
                                                            </select>
                                                        </div>
                                                        <div class="input-field col s12 m8 l8">
                                                            <input type="text" id="txtidea_search" name="txtidea_search">
                                                            <label for="txtidea_search">Criterio de búsqueda</label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="input-field col s6 center-align offset-s3">
                                                            <button type="submit" class="bg-secondary btn-large"><i class="material-icons right">search</i>Buscar idea</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div id="resultados_ideas"></div>
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
@include('ideas.functions')
