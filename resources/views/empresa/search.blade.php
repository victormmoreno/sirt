@extends('layouts.app')
@section('meta-title', 'Empresas')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <h5 class="left primary-text">
                        <a class="primary-text" href="{{route('empresa')}}">
                            <i class="material-icons left">
                                arrow_back
                            </i>
                        </a>
                        Empresas
                    </h5>
                    <div class="right right-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('empresa')}}">Empresas</a></li>
                            <li class="active">Buscar Empresa</li>
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
                                            <h2 class="header center primary-text">Empresas</h2>
                                            <div class="row center">
                                                <h5 class="header col s12 light black-text text-lighten-1"> Ingrese el NIT de la empresa para verificar si se encuentra registrada.</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col s12">
                                                <form id="formSearchEmpresas" action="{{ route('empresa.search.rq') }}" method="POST">
                                                    {!! csrf_field() !!}
                                                    <div class="row">
                                                        <div class="input-field col s12 m12 l12">
                                                            <input type="text" id="txtnit_search" name="txtnit_search" class="autocomplete">
                                                            <label for="txtnit_search">NIT de la empresa</label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="input-field col s6 center-align offset-s3">
                                                            <button type="submit" class="bg-secondary btn-large"><i class="material-icons right">search</i>Buscar Empresa</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div id="empresas_encontradas"></div>
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
