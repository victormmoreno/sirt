@extends('layouts.app')
@section('meta-title', 'Taller de fortalecimiento')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <div class="row">
              <div class="col s8 m8 l9">
                  <h5>
                    <a class="footer-text left-align" href="{{route('entrenamientos')}}">
                      <i class="left material-icons">arrow_back</i>
                    </a> Taller de fortalecimiento
                  </h5>
              </div>
              <div class="col s4 m4 l3 rigth-align show-on-large hide-on-med-and-down">
                  <ol class="breadcrumbs">
                      <li><a href="{{route('home')}}">Inicio</a></li>
                      <li><a href="{{route('entrenamientos')}}">Taller de fortalecimiento</a></li>
                      <li class="active">Nuevo taller de fortalecimiento</li>
                  </ol>
              </div>
          </div>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                <br>
                <center>
                  <span class="card-title center-align">Nuevo taller de fortalecimiento - Tecnoparque nodo {{ \NodoHelper::returnNameNodoUsuario() }}</span>
                </center>
                <div class="divider"></div>
                <form action="{{route('entrenamientos.store')}}" method="post" id="formEntrenamientosCreate">
                  @include('entrenamientos.form')
                  <div class="divider"></div>
                  <center>
                    <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done_all</i>Guardar</button>
                    <a href="{{route('entrenamientos')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
                  </center>
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
