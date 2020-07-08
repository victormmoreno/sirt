@extends('layouts.app')
@section('meta-title', 'CSIBT')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s8 m8 l10">
                        <h5 class="left-align">
                            <a class="footer-text left-align" href="{{route('csibt')}}">
                                <i class="material-icons arrow-l">
                                    arrow_back
                                </i>
                            </a>
                            Comité de Selección de Ideas
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('csibt')}}">CSIBT</a></li>
                            <li class="active">{{$comite->codigo}}</li>
                        </ol>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <br>
                        <center>
                            <span class="card-title center-align">Comité - {{$comite->codigo}} <b>({{$comite->estado->nombre}})</b></span>
                        </center>
                        <div class="divider"></div>
                        @include('comite.detalle_asignado')
                        <div class="divider"></div>
                        <div class="row">
                            <div class="col s12 m12 l12 center">
                                <a href="{{route('csibt.evidencias', $comite->id)}}">
                                  <div class="card-panel blue-grey white-text">
                                    <i class="material-icons left">library_books</i>Evidencias del comité.
                                  </div>
                                </a>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class="row center">
                            <a href="{{route('csibt')}}" class="waves-effect red lighten-2 btn center-aling">
                                <i class="material-icons right">backspace</i>Cancelar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection