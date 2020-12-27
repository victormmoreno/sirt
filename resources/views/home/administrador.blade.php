@extends('layouts.app')

@section('meta-title','Incio')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<main class="mn-inner inner-active-sidebar">
  <div class="middle-content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m6 l3 ">
        <div class="card stats-card">
          <div class="card-content">
            <div class="card-options">
              <ul class="hide-on-med-only">
                <li class="red-text "><span class="badge cyan lighten-1">Colombia</span></li>
              </ul>
            </div>
            <span class="card-title">Nodos</span>
            <span class="stats-counter"><span class="counter">{{$countNodos}}</span><small>En el país</small></span>
          </div>
        </div>
      </div>

      <div class="col s12 m6 l3">
        <div class="card stats-card">
          <div class="card-options">
              <ul class="hide-on-med-only">
                <li class="red-text"><span class="badge cyan lighten-1">{{$countDinamizadoresActivos}} Dinamizadores Activos</span></li>
              </ul>
          </div>
          <div class="card-content">
            <span class="card-title "><b>Dinamizadores</b> </span>
            <span class="stats-counter"><small> Total de Dinamizadores: {{$totalDinamizadores}}</small></span>
          </div>
        </div>
      </div>

      <div class="col s12 m6 l3">
        <div class="card stats-card">
          <div class="card-options">
              <ul class="hide-on-med-only">
                <li class="red-text"><span class="badge cyan lighten-1">{{$countGestoresActivos}} Gestores Activos</span></li>
              </ul>
          </div>
          <div class="card-content">
            <span class="card-title "><b>Gestores</b> </span>
            <span class="stats-counter"><small> Total de Gestores: {{$totalGestores}}</small></span>
          </div>
        </div>
      </div>
      <div class="col s12 m6 l3">
        <div class="card stats-card">
          <div class="card-options">
              <ul class="hide-on-med-only">
                <li class="red-text"><span class="badge cyan lighten-1">{{$countTalentosActivos}} Talentos Activos</span></li>
              </ul>
          </div>
          <div class="card-content">
            <span class="card-title "><b>Talentos</b> </span>
            <span class="stats-counter"><small> Total de Talentos: {{$totalTalentos}}</small></span>
          </div>
        </div>
      </div>
    </div>

    <div class="row no-m-t no-m-b">

      <div class="col s12 m12 l12">
        <div class="card card-transparent">
          <div class="card-content">
            <center>
              <p class="card-title aling-center">Bienvenido <span class="secondary-title"> Sistema Nacional de la Red de Tecnoparques Colombia</span></p>
            </center>
            <div class="row">
              <div class="col s12 m12 l10 offset-l1">
                <img class="materialboxed responsive-img" src="{{ asset('img/logonacional_Negro.png') }}" alt="sena | Tecnoparque">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  {{-- <div class="inner-sidebar">
    <span class="inner-sidebar-title center-aling"><b></b> Administradores </span>
    <div class="message-list">
    </div>
  </div> --}}
</main>

 
@endsection

