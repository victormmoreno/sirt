@extends('layouts.app')
@section('meta-title', 'Taller de fortalecimiento')
@section('content')
    <main class="mn-inner inner-active-sidebar">
        <div class="content">
            <div class="row no-m-t no-m-b">
                <div class="col s12 m12 l12">
                    <div class="row">
                        <h5 class="left primary-text">
                            <a href="{{ route('taller') }}">
                                <i class="left material-icons primary-text">arrow_back</i>
                            </a> Taller de fortalecimiento
                        </h5>
                        <div class="right right--align show-on-large hide-on-med-and-down">
                            <ol class="breadcrumbs">
                                <li><a href="{{ route('home') }}">Inicio</a></li>
                                <li><a href="{{ route('taller') }}">Taller de fortalecimiento</a></li>
                                <li class="active">Nuevo taller de fortalecimiento</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <br>
                                    <div class="center">
                                        <span class="card-title center-align primary-text">Nuevo taller de
                                            fortalecimiento</span>
                                    </div>
                                    <div class="divider"></div>
                                    <form action="{{ route('taller.store') }}" method="post" id="formEntrenamientosCreate">
                                        @include('talleres.form')
                                        <div class="divider"></div>
                                        <div class="center">
                                            <button type="submit" class="bg-secondary btn center-aling"><i
                                                    class="material-icons right">send</i>Guardar</button>
                                            <a href="{{ route('taller') }}" class="bg-danger btn center-aling"><i
                                                    class="material-icons left">backspace</i>Cancelar</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
