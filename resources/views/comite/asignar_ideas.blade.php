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
                                <a class="footer-text left-align" href="{{ route('csibt') }}">
                                    <i class="material-icons arrow-l left">
                                        arrow_back
                                    </i>
                                </a>
                                Comité de Selección de Ideas
                            </h5>
                        </div>
                        <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                            <ol class="breadcrumbs">
                                <li><a href="{{ route('home') }}">Inicio</a></li>
                                <li><a href="{{ route('csibt') }}">CSIBT</a></li>
                                <li class="active">Asignar ideas</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <br>
                            <center>
                                <span class="card-title center-align">Asignar ideas del comité a expertos -
                                    <b>{{ $comite->codigo }}</b></span>
                            </center>
                            <div class="divider"></div>
                            <div class="row">
                                <form action="{{ route('csibt.asignar.store', $comite->id) }}" id="formComiteAsignarCreate"
                                    method="post">
                                    {!! method_field('PUT') !!}
                                    @include('comite.form_asignar_ideas', [
                                        'btnText' => 'Guardar',
                                    ])
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
