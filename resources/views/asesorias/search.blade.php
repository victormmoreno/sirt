@extends('layouts.app')

@section('meta-title', 'Asesoría y Uso')

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
            <div class="left left-align">
                <h5 class="left-align primary-text">
                    <a class="footer-text left-align" href="{{route('asesorias.index')}}">
                    <i class="material-icons left">arrow_back</i>
                    </a>
                    Asesorias y Usos
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li><a href="{{route('asesorias.index')}}">Asesorias y Usos</a></li>
                    <li class="active">Buscar Asesoria</li>
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
                                        <div class="search-asesories">
                                            <div class="container">
                                                <br><br>
                                                <h2 class="header center primary-text">Asesorias y usos</h2>
                                                <div class="row center">
                                                    <h5 class="header col s12 light black-text text-lighten-1"> Ingrese los campos para buscar la asesoria y uso.</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container">
                                            <div class="row">
                                                <div class="col s12">
                                                    <form id="formSearchAsesorie" action="{{ route('asesorie.search')}}" method="POST">
                                                        {!! csrf_field() !!}
                                                        <div class="row">

                                                            <div class="input-field col s12 m4 l4">
                                                                {{-- @can('moduleType', \App\Models\UsoInfraestructura::class) --}}
                                                                <select class="js-states browser-default select2" tabindex="-1" style="width: 100%" name="type_search" id="type_search" onchange="asesorieSearch.changetextLabel()">
                                                                    @forelse($modules as $id => $name)
                                                                        <option value="{{$id}}" @if($loop->first) selected @endif>{{$name}}</option>
                                                                    @empty
                                                                        <option>No se encontraron Resultados</option>
                                                                    @endforelse
                                                                </select>
                                                                {{-- @endcan --}}
                                                            </div>
                                                            <div class="input-field col s12 m8 l8">
                                                                <input type="text" id="search_asesorie" name="search_asesorie" class="autocomplete">
                                                                <label for="search_asesorie">ingrese código de asesoria</label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="input-field col s6  center-align offset-s3">
                                                                <button  type="submit" class="waves-effect waves-light bg-secondary btn-large"><i class="material-icons right">search</i><span>Buscar Asesoria</span></button>
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
